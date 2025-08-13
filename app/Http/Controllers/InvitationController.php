<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class InvitationController extends Controller
{
    public function create()
    {
        return view('invitation.create');
    }

    public function store(Request $request)
    {
        $inviter = Auth::user();
        
        $isSuperAdmin = $inviter->role === 'SuperAdmin';
        
        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
        ];
        
        if (!$isSuperAdmin) {
            $rules['role'] = ['required', 'in:Admin,Member'];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        if ($isSuperAdmin) {
            $company = Company::create([
                'name' => $request->name,
            ]);

            $role = 'Admin';
            $company_id = $company->id;
        } else {
            
            $company_id = $inviter->company_id;
            $role = $request->role;
        }
        
        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'email_verified_at'  => Carbon::now(),
            'password'   => Hash::make('12345678'), 
            'role'       => $role,
            'company_id' => $company_id ?? null,
        ]);

        return back()->with('success', 'Invitation sent successfully.');
    }
}

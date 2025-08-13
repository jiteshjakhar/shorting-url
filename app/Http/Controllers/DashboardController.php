<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ShortUrl;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $clients = collect();
        $shortUrls = collect();

        if ($user->role === 'SuperAdmin') {
            $clients = User::whereNot('role', 'SuperAdmin')->get();
            $shortUrls = ShortUrl::all();

        } elseif ($user->role === 'Admin') {
            $clients = User::whereIn('role', ['Admin', 'Member'])
                ->where('company_id', $user->company_id)
                ->get();

            $shortUrls = ShortUrl::where('company_id', $user->company_id)->get();

        } elseif ($user->role === 'Member') {
            $clients = collect([$user]);
            $shortUrls = ShortUrl::where('user_id', $user->id)->get();
        }

        return view('dashboard', compact('clients', 'shortUrls', 'user'));
    }
}

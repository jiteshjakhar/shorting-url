<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ShortUrlController extends Controller
{
    public function create()
    {
        return view('short_urls.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'long_url' => 'required|url|max:255',
        ]);

        $user = Auth::user();

        $shortCode = substr($request->long_url, 0, 20);
        $shortCode = $shortCode .'/'. rand(1000, 9999);
        
        ShortUrl::create([
            'user_id'    => $user->id,
            'company_id' => $user->company_id,
            'original_url'   => $request->long_url,
            'short_code' => $shortCode,
        ]);

        return redirect()->back()->with('success', "Short URL generated successfully!");
    }
}

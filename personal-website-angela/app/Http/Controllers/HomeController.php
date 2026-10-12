<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * UC1.1 — Melihat Showcase / About Me Author.
     */
    public function index()
    {
        $profile = config('profile');

        return view('home', [
            'profile' => $profile,
        ]);
    }
}

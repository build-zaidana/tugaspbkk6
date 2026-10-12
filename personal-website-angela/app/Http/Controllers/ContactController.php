<?php

namespace App\Http\Controllers;

class ContactController extends Controller
{
    /**
     * UC2 — Melihat Contact Person Author.
     */
    public function index()
    {
        return view('contact', [
            'contact' => config('profile.contact'),
        ]);
    }
}

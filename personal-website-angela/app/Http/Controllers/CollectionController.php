<?php

namespace App\Http\Controllers;

use App\Models\Achievement;

class CollectionController extends Controller
{
    /**
     * UC4 — Melihat Personal Collection Author (achievement / sertifikat),
     * dikelompokkan per tahun agar mudah ditelusuri.
     */
    public function index()
    {
        $achievements = Achievement::orderByDesc('year')->get()->groupBy('year');

        return view('collection', [
            'achievements' => $achievements,
        ]);
    }
}

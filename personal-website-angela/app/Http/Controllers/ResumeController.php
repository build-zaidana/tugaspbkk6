<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResumeController extends Controller
{
    /**
     * UC5 — Mendownload resume Author.
     *
     * File resume disimpan di storage/app/public/resume dan disajikan lewat
     * disk 'public' supaya bisa di-deploy tanpa expose struktur folder asli.
     */
    public function download(): StreamedResponse
    {
        $path = 'resume/CV_Angela_Vania_Sugiyono.pdf';

        abort_unless(Storage::disk('public')->exists($path), 404, 'File resume belum tersedia.');

        return Storage::disk('public')->download($path, 'CV_Angela_Vania_Sugiyono.pdf');
    }
}

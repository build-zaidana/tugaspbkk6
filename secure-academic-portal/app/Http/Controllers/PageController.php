<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $portfolio = $this->portfolio($request);

        return view('home', [
            'portfolio' => $portfolio,
            'courseTasks' => $portfolio?->courseTasks()->orderByDesc('tanggal_pengumpulan')->latest()->get() ?? collect(),
        ]);
    }

    public function about(Request $request): View
    {
        return view('about', ['portfolio' => $this->portfolio($request)]);
    }

    public function project(Request $request): View
    {
        $portfolio = $this->portfolio($request);

        return view('project', [
            'portfolio' => $portfolio,
            'projects' => $portfolio?->projects()->latest()->get() ?? collect(),
        ]);
    }

    private function portfolio(Request $request): ?User
    {
        return $request->user() ?? User::where('email', config('portfolio.public_email'))->first();
    }

    public function hitung(int $angka1, int $angka2, string $operasi): View
    {
        switch ($operasi) {
            case 'tambah':
                $hasil = $angka1 + $angka2;
                break;

            case 'kurang':
                $hasil = $angka1 - $angka2;
                break;

            case 'kali':
                $hasil = $angka1 * $angka2;
                break;

            case 'bagi':
                if ($angka2 == 0) {
                    $hasil = '(error) -division by zero-';
                    break;
                }
                $hasil = $angka1 / $angka2;
                break;

            default:
                $hasil = '(error) -Operasi tidak Sesuai-';
                break;
        }

        return view('hitung', compact('angka1', 'angka2', 'operasi', 'hasil'));
    }
}

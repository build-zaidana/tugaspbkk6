<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function project()
    {
        return view('project');
    }

    public function calculator($angka1, $angka2, $operasi)
{
    switch ($operasi) {
        case 'tambah':
            $hasil = $angka1 + $angka2;
            $simbol = '+';
            break;

        case 'kurang':
            $hasil = $angka1 - $angka2;
            $simbol = '-';
            break;

        case 'kali':
            $hasil = $angka1 * $angka2;
            $simbol = '×';
            break;

        case 'bagi':
            if ($angka2 == 0) {
                return 'Tidak bisa melakukan pembagian dengan 0.';
            }

            $hasil = $angka1 / $angka2;
            $simbol = '÷';
            break;

        default:
            return 'Operasi tidak valid. Gunakan: tambah, kurang, kali, atau bagi.';
    }

    return view('calculator', compact('angka1', 'angka2', 'operasi', 'hasil', 'simbol'));
}
}

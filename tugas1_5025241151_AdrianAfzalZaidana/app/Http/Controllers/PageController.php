<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        $nama = "Adrian Afzal Zaidana";
        $nrp = "5025141151";
        return view('home', compact('nama', 'nrp'));
    }
    public function about(){
        $profile_dept = "Lorem ipsum....";
        return view('about', compact('profile_dept'));
    }
    public function project(){
        $project_plan = "lorem ipsum ....";
        return view('project', compact('project_plan'));
    }

    public function hitung(int $angka1, int $angka2, string $operasi){
        switch ($operasi) {
            case 'tambah':
                $hasil = $angka1+$angka2;
                break;

            case 'kurang':
                $hasil = $angka1-$angka2;
                break;

            case 'kali':
                $hasil = $angka1*$angka2;
                break;

            case 'bagi':
                if ($angka2==0) {
                    $hasil = "(error) -division by zero-";
                    break;
                }
                $hasil = $angka1/$angka2;
                break;

            default:
                $hasil = "(error) -Operasi tidak Sesuai-";
                break;
        }

        return view('hitung', compact('angka1','angka2','operasi','hasil'));
    }
}

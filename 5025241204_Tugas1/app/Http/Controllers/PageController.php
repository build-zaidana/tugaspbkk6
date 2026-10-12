<?php

namespace App\Http\Controllers;
class PageController
{
    // GET /Home
    public function index()
    {
        $data = [
            'nama'  => 'Lorem Ipsum',   
            'nrp'   => '5025xxxxxx',          
            'kelas' => 'PBKK A',               
            'kelompok' => '4',                 
        ];

        return view('home', $data);
    }

    // GET /about
    public function about()
    {
        $profil = [
            'nama_departemen' => 'Departemen Teknik Informatika',
            'institusi'       => 'Institut Teknologi Sepuluh Nopember (ITS)',
            'fakultas'        => 'Fakultas Teknologi Elektro dan Informatika Cerdas (FTEIC)',
            'deskripsi'       => 'Lorem Ipsum',
        ];

        return view('about', $profil);
    }

    // GET /project
    public function project()
    {
        $project = [
            'judul_ide'   => 'Lorem Ipsum', 
            'sub_tema'    => 'Lorem Ipsum',
            'deskripsi'   => 'Lorem Ipsum.',
            'anggota_kelompok' => [
                'Nama Anggota 1',
                'Nama Anggota 2',
                'Nama Anggota 3',
            ],
        ];

        return view('project', $project);
    }

    // GET /calculator: kalkulator
    public function calculator()
    {
        return view('calculator');
    }
}

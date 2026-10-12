{{-- <!DOCTYPE html>

<html>
    <head>
        <title>
            Project Plan
        </title>
    </head>
    <body>
        <div>
            <h1>
                Rencana Final Project
            </h1>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    ​       </p>
        </div>
    </body>
</html> --}}

@extends('layout')

@section('title', 'Project Plan')

@section('content')
    <h1>
        Rencana Final Project
    </h1>
    <p>
        Agentic Web Security Auditor adalah aplikasi desktop berbasis Laravel, Livewire,
        dan NativePHP yang menggunakan AI untuk membantu melakukan assessment keamanan website secara otomatis.
        Agent dapat memetakan attack surface, menjalankan berbagai security tools,
        menganalisis dan menggabungkan hasil temuan, memprioritaskan vulnerability berdasarkan tingkat risiko,
        serta memberikan evidence dan rekomendasi remediation yang mudah dipahami.
        Proyek ini ditujukan untuk pengujian pada website milik sendiri atau sistem yang telah memberikan izin,
        dengan LLM berperan sebagai orchestration layer yang menentukan langkah pemeriksaan berdasarkan kondisi target.
    </p>
@endsection

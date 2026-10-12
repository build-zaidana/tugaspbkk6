@extends('layouts.app')

@section('title', 'Agentic AI')

@section('content')

<style>
    .agent-page {
        min-height: calc(100vh - 120px);
        background: #f5f5f5;
        padding: 60px 20px;
    }

    .agent-card {
        max-width: 950px;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #dddddd;
        border-radius: 18px;
        padding: 50px 60px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
    }

    .agent-label {
        display: inline-block;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 1.5px;
        color: #666666;
        margin-bottom: 20px;
    }

    .agent-title {
        font-size: 46px;
        line-height: 1.15;
        font-weight: 700;
        color: #111111;
        margin-bottom: 35px;
    }

    .agent-title span {
        font-style: italic;
        font-weight: 500;
    }

    .agent-content {
        color: #333333;
        font-size: 17px;
        line-height: 1.8;
    }

    .agent-content p {
        margin-bottom: 20px;
    }

    .agent-content .lead {
        font-size: 20px;
        line-height: 1.7;
        color: #222222;
    }

    .agent-content strong {
        font-weight: 700;
        color: #111111;
    }

    .agent-features {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 35px;
    }

    .feature-box {
        border: 1px solid #dddddd;
        border-radius: 12px;
        padding: 18px;
        text-align: center;
        background: #fafafa;
        font-size: 14px;
        font-weight: 600;
        color: #222222;
    }

    .agent-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-top: 40px;
        padding-top: 25px;
        border-top: 1px solid #e5e5e5;
    }

    .agent-footer-label {
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 1px;
        color: #666666;
    }

    .agent-back {
        text-decoration: none;
        color: #111111;
        font-weight: 600;
        border-bottom: 1px solid #111111;
        padding-bottom: 3px;
    }

    .agent-back:hover {
        color: #666666;
    }

    @media (max-width: 768px) {
        .agent-card {
            padding: 35px 25px;
        }

        .agent-title {
            font-size: 36px;
        }

        .agent-features {
            grid-template-columns: 1fr;
        }

        .agent-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<section class="agent-page">
    <article class="agent-card">

        <div class="agent-label">
            03 / KELOMPOK 04
        </div>

        <h1 class="agent-title">
            Agentic AI untuk
            <br>
            <span>keamanan web.</span>
        </h1>

        <div class="agent-content">

            <p class="lead">
                Kami merancang aplikasi
                <strong>Dynamic Application Security Testing (DAST)</strong>
                yang menggunakan Agentic AI untuk membantu menemukan kerentanan
                pada aplikasi web secara mandiri.
            </p>

            <p>
                Agen ini bekerja seperti pentester: memetakan halaman dan endpoint,
                membaca respons HTTP, lalu menentukan uji berikutnya berdasarkan
                temuan sebelumnya. Hasil pengujian dirangkum menjadi laporan yang
                mudah dipahami, lengkap dengan saran perbaikan di tingkat kode.
            </p>

            <p>
                Versi awal akan berfokus pada crawling halaman, analisis form,
                pengiriman payload uji untuk SQL Injection dan XSS, serta validasi
                respons. Pengujian dilakukan secara legal pada target lokal seperti
                OWASP Juice Shop atau DVWA.
            </p>

        </div>

        <div class="agent-features">
            <div class="feature-box">
                Reconnaissance
            </div>

            <div class="feature-box">
                AI Reasoning
            </div>

            <div class="feature-box">
                Security Report
            </div>
        </div>

        <div class="agent-footer">

            <span class="agent-footer-label">
                AGENTIC SECURITY / MVP
            </span>

            <a href="{{ route('home') }}" class="agent-back">
                Kembali ke Home ↗
            </a>

        </div>

    </article>
</section>

@endsection

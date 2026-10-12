@extends('layouts.app')

@section('title', 'Contact — Angela Vania Sugiyono')

@section('content')
{{-- UC2: Melihat Contact Person Author --}}
<h1 class="font-script text-4xl md:text-5xl text-brand-pink-dark mb-6 reveal">Get in Touch</h1>

<div class="window-card max-w-lg reveal">
    <div class="window-titlebar">
        <span class="dot" style="background:#ff5f57"></span>
        <span class="dot" style="background:#febc2e"></span>
        <span class="dot" style="background:#28c840"></span>
    </div>
    <div class="p-5 space-y-3 text-sm">
        <div class="flex items-center gap-3">
            <span class="font-bold w-20 text-brand-pink-dark text-xs uppercase tracking-wide">Email</span>
            <a href="mailto:{{ $contact['email'] }}" class="hover:underline">{{ $contact['email'] }}</a>
        </div>
        <div class="flex items-center gap-3">
            <span class="font-bold w-20 text-brand-pink-dark text-xs uppercase tracking-wide">Location</span>
            <span>{{ $contact['location'] }}</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="font-bold w-20 text-brand-pink-dark text-xs uppercase tracking-wide">LinkedIn</span>
            <a href="{{ $contact['linkedin'] }}" target="_blank" class="hover:underline break-all">{{ $contact['linkedin'] }}</a>
        </div>
        <div class="flex items-center gap-3">
            <span class="font-bold w-20 text-brand-pink-dark text-xs uppercase tracking-wide">GitHub</span>
            <a href="{{ $contact['github'] }}" target="_blank" class="hover:underline break-all">{{ $contact['github'] }}</a>
        </div>
    </div>
</div>
@endsection

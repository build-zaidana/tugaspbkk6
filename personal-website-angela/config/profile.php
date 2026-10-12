<?php

return [
    'name' => 'Angela Vania Sugiyono',
    'tagline' => 'Informatics Engineering Student — ITS Surabaya',
    'photo' => 'images/profile/profile_photo.png',
    'about' => "Passionate about research and continuous learning, I am dedicated to building innovative, scalable solutions. With a background that bridges intuitive UI/UX design and rigorous technical engineering, I maintain a product-centric mindset throughout the software lifecycle. Currently, I am deeply focused on AI/ML and Operating Systems—leveraging my experience as a Teaching Assistant to bridge complex system performance with seamless, user-focused experiences. I thrive on translating research concepts into impactful, production-ready software.",
    'education' => [
        [
            'school' => 'Institut Teknologi Sepuluh Nopember (ITS) — Surabaya',
            'degree' => 'Bachelor of Informatics Engineering',
            'score' => '3.29 / 4.00',
            'period' => 'Aug 2024 - Present',
        ],
        [
            'school' => '2 States Senior High School Surakarta',
            'degree' => 'Senior High School — Natural Sciences',
            'score' => '91.42 / 100.00',
            'period' => 'Jul 2021 - Jul 2024',
        ],
    ],
    'hard_skills' => ['C', 'C++', 'Python', 'Figma', 'SQL (MySQL)', 'PHP', 'HTML/CSS', 'Linux', 'Operating Systems', 'Computer Networks', 'Database Design (CDM/PDM)', 'GitHub', 'Railway'],
    'soft_skills' => ['Analytical Thinking', 'Critical Thinking', 'Problem Solving', 'Research', 'Project Management', 'Leadership', 'Public Speaking', 'Strategic Planning', 'Mentorship', 'Collaborative Teamwork'],

    // CATATAN PRIVASI: nomor HP sengaja TIDAK dimasukkan ke sini supaya tidak
    // ikut ter-commit ke repository Git kelompok (file ini bakal di-push).
    // Kalau suatu saat mau ditampilkan, taruh di file .env (yang otomatis
    // di-ignore Git) lalu panggil pakai env('CONTACT_PHONE') di sini —
    // JANGAN hardcode angka aslinya langsung di file config manapun.
    'contact' => [
        'email' => 'angelasugiyono95@gmail.com',
        'location' => 'Surabaya, East Java, Indonesia',
        'linkedin' => 'https://linkedin.com/in/angelavs',
        'github' => 'https://github.com/shzirley',
    ],
];

<?php

return [
    'title' => 'Sistem',
    'group' => 'Pengaturan',
    'back' => 'Kembali',
    'settings' => [
        'site' => [
            'title' => 'Pengaturan Situs',
            'description' => 'Atur berbagai pengaturan situs dengan mudah di sini.',
            'form' => [
                'site_name' => 'Nama Situs',
                'site_description' => 'Deskripsi singkat tentang situs Anda',
                'site_logo' => 'Unggah Logo Situs',
                'site_profile' => 'Atur Gambar Profil untuk Situs',
                'site_keywords' => 'Kata Kunci untuk SEO',
                'site_email' => 'Email Resmi Situs',
                'site_phone' => 'Nomor Kontak',
                'site_author' => 'Pemilik atau Penulis Situs',
            ],
            'site-map' => 'Buat Peta Situs',
            'site-map-notification' => 'Peta situs berhasil dibuat!',
        ],
        'social' => [
            'title' => 'Menu Media Sosial',
            'description' => 'Kelola tautan media sosial Anda dengan mudah.',
            'form' => [
                'site_social' => 'Tautan Media Sosial',
                'vendor' => 'Nama Platform',
                'link' => 'Tautan Profil atau Halaman',
            ],
        ],
        'location' => [
            'title' => 'Pengaturan Lokasi',
            'description' => 'Sesuaikan detail lokasi untuk situs Anda.',
            'form' => [
                'site_address' => 'Alamat Lengkap',
                'site_phone_code' => 'Kode Telepon',
                'site_location' => 'Lokasi Fisik',
                'site_currency' => 'Mata Uang yang Digunakan',
                'site_language' => 'Bahasa Utama Situs',
            ],
        ],
        'authentication' => [
            'title' => 'Pengaturan Login',
            'description' => 'Sesuaikan opsi login dan autentikasi dengan mudah.',
            'form' => [
                'section_title' => 'Informasi Situs',
                'site_name' => 'Nama Situs',
                'site_active' => 'Status Situs',
                'registration_enabled' => 'Pendaftaran Pengguna',
                'password_reset_enabled' => 'Reset Password',
                'sso_enabled' => 'Login dengan SSO',
            ],
        ],
    ],
];

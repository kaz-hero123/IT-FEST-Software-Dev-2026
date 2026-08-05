# Jelajah Madura
**Platform Digital Pariwisata Berkelanjutan Pulau Madura Berbasis Web**

*Dikembangkan untuk Software Development Competition - IT Festival 2026*

## 🌐 Informasi Akses (Penjurian)
- **URL Aplikasi**: [https://jelajahmadura.up.railway.app/](https://jelajahmadura.up.railway.app/)
- **Repository**: [https://github.com/kaz-hero123/IT-FEST-Software-Dev-2026](https://github.com/kaz-hero123/IT-FEST-Software-Dev-2026)

## 🔑 Akun Demo (Untuk Juri)
Berikut adalah kredensial yang dapat digunakan untuk menguji fitur-fitur aplikasi:

| Peran | URL Login | Email | Password |
|-------|-----------|-------|----------|
| **Administrator** | `/admin/login` | `admin@admin.com` | `password` |
| **Kontributor** | `/login` | `kontributor@kontributor.com` | `password` |

*(Catatan: Kredensial di atas terhubung ke sistem basis data seeder yang digunakan pada versi deployment)*

## 🚀 Fitur Unggulan
1. **Smart Predictor**: Sistem rekomendasi destinasi menggunakan algoritma *Simple Additive Weighting (SAW)* dengan parameter Eco-Score (C1) dan Popularitas (C2).
2. **Community-Driven Content**: Alur moderasi konten berlapis dari Kontributor ke Admin lengkap dengan audit trail (`moderation_notes`).
3. **Live Chat Interaktif**: Sistem live chat pengunjung dengan admin tanpa memerlukan registrasi (berbasis sesi `localStorage`).
4. **Green Image Pipeline**: Konversi otomatis format foto unggahan menjadi WebP 80% (resize max 1600px) menggunakan ekstensi native GD.

---
*Tim Manusia Berteknologi Gacor - SMKN 3 Pamekasan*

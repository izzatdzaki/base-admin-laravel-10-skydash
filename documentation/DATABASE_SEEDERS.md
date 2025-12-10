# Database Seeders - Master Data Jaspel

## 📋 Overview

Dokumentasi ini menjelaskan struktur dan isi dari seeder database untuk Master Data sistem Jaspel (Jasa Pelayanan Medis).

## 🗂️ Daftar Seeders

### 1. **UnitSeeder** 
Seeder untuk tabel `units` - Master data unit/ruangan di rumah sakit.

**Jumlah Data:** 12 records

**Struktur Data:**
- `kode`: Kode unit (unique)
- `ruang_unit`: Nama unit/ruangan
- `instalasi`: Instalasi induk

**Contoh Data:**
- ICU - Intensive Care Unit
- OK - Ruang Operasi
- POLI - Poliklinik Umum
- LAB - Laboratorium
- RAD - Radiologi
- IGD - Instalasi Gawat Darurat
- Dan lain-lain

---

### 2. **KelompokTindakanSeeder**
Seeder untuk tabel `kelompok_tindakan` - Pengelompokan tindakan medis.

**Jumlah Data:** 5 records

**Struktur Data:**
- `kode_tindakan`: Kode unik tindakan
- `kode_tarif`: Relasi ke tarif
- `instalasi_induk`: Instalasi induk
- `instansi_pelaksana`: Unit pelaksana
- `kelompok_tindakan`: Nama kelompok
- `detail_tindakan`: Detail tindakan
- `rincian_tindakan`: Rincian lengkap

**Contoh Data:**
- KT001 - Perawatan Intensif (ICU)
- KT002 - Operasi Bedah (OK)
- KT003 - Konsultasi (POLI)
- KT004 - Pemeriksaan Lab
- KT005 - Pemeriksaan Radiologi

---

### 3. **TarifMasterSeeder**
Seeder untuk tabel `tbl_tarif` - Master tarif layanan medis.

**Jumlah Data:** 8 records

**Struktur Data:**
- `kode_tarif`: Kode tarif (unique)
- `nama_tarif`: Nama layanan
- `instalasi`: Instalasi
- `instalasi_pelaksana`: Unit pelaksana
- `kode_klp`: Kode kelompok tindakan
- `klp_tindakan`: Nama kelompok
- `nama_tindakan`: Nama tindakan
- `biaya`: Biaya operasional
- `jasa`: Jasa pelayanan
- `tarif`: Total tarif

**Contoh Data:**
- TRF001 - Perawatan ICU Per Hari (Rp 7.000.000)
- TRF002 - Operasi Bedah Besar (Rp 13.000.000)
- TRF003 - Konsultasi Dokter Spesialis (Rp 250.000)
- TRF004 - Pemeriksaan Darah Lengkap (Rp 150.000)
- TRF005 - Rontgen Thorax (Rp 250.000)
- Dan lain-lain

---

### 4. **ParamedisSeeder**
Seeder untuk tabel `paramedis` - Master data tenaga medis (dokter & perawat).

**Jumlah Data:** 15 records

**Struktur Data:**
- `kode`: Kode unik paramedis
- `nama_paramedis`: Nama lengkap dengan gelar
- `ruang_unit`: Unit tempat bertugas

**Contoh Data:**

**Dokter:**
- PM001 - dr. Ahmad Hidayat, Sp.PD (ICU)
- PM002 - dr. Siti Nurhaliza, Sp.B (OK)
- PM003 - dr. Budi Santoso (POLI)
- PM004 - dr. Rina Wijaya, Sp.PK (LAB)
- Dan lain-lain

**Perawat:**
- PR001 - Ns. Ani Setiawati, S.Kep (ICU)
- PR002 - Ns. Bambang Wijaya, S.Kep (OK)
- PR003 - Ns. Citra Dewi, S.Kep (IGD)
- Dan lain-lain

---

### 5. **ParamedisPendampingSeeder**
Seeder untuk tabel `paramedis_pendamping` - Master data tenaga pendamping medis.

**Jumlah Data:** 10 records

**Struktur Data:**
- `kode_tarif`: Kode unik pendamping
- `nama_pendamping`: Nama/jenis pendamping
- `ruang_unit`: Unit tempat bertugas

**Contoh Data:**
- PD001 - Asisten Dokter Bedah (OK)
- PD002 - Perawat Anestesi (OK)
- PD003 - Perawat Instrumen (OK)
- PD004 - Perawat Sirkuler (OK)
- PD005 - Asisten Laboratorium (LAB)
- PD006 - Radiografer (RAD)
- Dan lain-lain

---

### 6. **PorsiJpSeeder**
Seeder untuk tabel `porsi_jp` - Distribusi jasa pelayanan (JP).

**Jumlah Data:** 8 records

**Struktur Data:**
- `kode_tarif`: Relasi ke tarif
- `instalasi_induk`: Instalasi induk
- `instansi_pelaksana`: Unit pelaksana
- `kelompok_tindakan`: Kelompok tindakan
- `jlp`: Jasa Lainnya Pelayanan (%)
- `jla`: Jasa Lainnya Administrasi (%)
- `jtl_st`: Jasa Tambahan Lainnya - ST (%)
- `jtl_p`: Jasa Tambahan Lainnya - P (%)

**Contoh Distribusi:**
- **Operasi Bedah:** JLP=70%, JLA=15%, JTL-ST=10%, JTL-P=5%
- **Perawatan ICU:** JLP=60%, JLA=20%, JTL-ST=10%, JTL-P=10%
- **Konsultasi:** JLP=50%, JLA=30%, JTL-ST=10%, JTL-P=10%
- **Lab/Radiologi:** JLP=55%, JLA=25%, JTL-ST=10%, JTL-P=10%

---

### 7. **PorsiJpTmoSeeder**
Seeder untuk tabel `porsi_jp_tmo` - Distribusi JP untuk Tim Medis Operasi.

**Jumlah Data:** 17 records

**Struktur Data:**
- `kode`: Kode unik
- `jenis_tmo`: Jenis tindakan medis
- `penerima_jp`: Penerima jasa pelayanan
- `porsi_jp`: Persentase porsi (%)

**Contoh Distribusi:**

**Operasi Besar:**
- Dokter Operator Utama: 40%
- Dokter Anestesi: 25%
- Asisten Bedah: 15%
- Perawat Instrumen: 10%
- Perawat Sirkuler: 10%

**Operasi Sedang:**
- Dokter Operator Utama: 40%
- Dokter Anestesi: 25%
- Asisten Bedah: 15%
- Perawat Instrumen: 12%
- Perawat Sirkuler: 8%

**Operasi Kecil:**
- Dokter Operator: 50%
- Perawat Asisten: 30%
- Perawat Instrumen: 20%

**Pemeriksaan Radiologi:**
- Dokter Radiologi: 60%
- Radiografer: 40%

**Pemeriksaan Laboratorium:**
- Dokter Patologi Klinik: 50%
- Analis Laboratorium: 50%

---

### 8. **PorsiCbgsSeeder**
Seeder untuk tabel `porsi_cbgs` - Distribusi jasa berdasarkan CBGS (Case Based Groups).

**Jumlah Data:** 5 records

**Struktur Data:**
- `porsi`: Persentase porsi (%)
- `nilai`: Nilai nominal

**Distribusi:**
1. 30% (Rp 3.000.000) - Jasa Medis
2. 25% (Rp 2.500.000) - Jasa Pelayanan
3. 20% (Rp 2.000.000) - Jasa Sarana
4. 15% (Rp 1.500.000) - Jasa Administrasi
5. 10% (Rp 1.000.000) - Jasa Lain-lain

**Total:** 100% (Rp 10.000.000)

---

## 🚀 Cara Menjalankan Seeder

### Menjalankan Semua Seeder
```bash
php artisan db:seed
```

### Menjalankan Seeder Spesifik
```bash
php artisan db:seed --class=UnitSeeder
php artisan db:seed --class=TarifMasterSeeder
php artisan db:seed --class=ParamedisSeeder
```

### Refresh Database + Seed
```bash
php artisan migrate:fresh --seed
```

### Rollback & Migrate Ulang
```bash
php artisan migrate:refresh --seed
```

---

## 📊 Urutan Eksekusi Seeder

Seeder dijalankan dalam urutan berikut (sesuai DatabaseSeeder.php):

1. **UserSeeder** - User & Authentication
2. **UnitSeeder** - Master Unit/Ruangan
3. **KelompokTindakanSeeder** - Master Kelompok Tindakan
4. **TarifMasterSeeder** - Master Tarif
5. **ParamedisSeeder** - Master Paramedis
6. **ParamedisPendampingSeeder** - Master Pendamping
7. **PorsiJpSeeder** - Distribusi JP
8. **PorsiJpTmoSeeder** - Distribusi JP TMO
9. **PorsiCbgsSeeder** - Distribusi CBGS
10. **PengaturanJasselSeeder** - Pengaturan Jaspel
11. **IndeksPegawaiSeeder** - Indeks Pegawai
12. **IndeksPerawatSeeder** - Indeks Perawat

---

## 📝 Catatan Penting

1. **Foreign Key Dependencies:** Pastikan seeder dijalankan sesuai urutan karena ada relasi antar tabel
2. **Unique Constraints:** Beberapa field memiliki constraint UNIQUE, jangan duplikasi data
3. **Data Sample:** Data yang ada adalah data sample/contoh untuk keperluan development
4. **Production Data:** Untuk production, sesuaikan data dengan kebutuhan rumah sakit yang sebenarnya
5. **Backup:** Selalu backup database sebelum menjalankan `migrate:fresh`

---

## 🔧 Troubleshooting

### Error: Duplicate Entry
```bash
# Solusi: Refresh database
php artisan migrate:fresh --seed
```

### Error: Class Not Found
```bash
# Solusi: Regenerate autoload
composer dump-autoload
php artisan db:seed
```

### Error: Foreign Key Constraint
```bash
# Solusi: Cek urutan seeder dan relasi tabel
# Pastikan parent table di-seed terlebih dahulu
```

---

## 📧 Support

Jika ada pertanyaan atau issue, silakan hubungi tim development.

**Version:** 1.0.0  
**Last Updated:** November 2, 2025

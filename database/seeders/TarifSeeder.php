<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarif;

class TarifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tarifs = [
            [
                'kode_tarif' => 'TR01071',
                'kode' => 'KT44',
                'instansi' => 'Gawat Darurat (IGD)',
                'instansi_pelaksana' => 'Kamar Jenazah',
                'kelompok_tindakan' => 'Pelayanan Kamar Jenazah',
                'nama_tindakan' => 'Sewa Kamar Jenazah/Hari',
                'detail_tindakan' => 'Pelayanan penyewaan kamar jenazah per hari',
                'js' => 50000,
                'jp' => 0,
                'tarif' => 50000,
            ],
            [
                'kode_tarif' => 'TR01072',
                'kode' => 'KT44',
                'instansi' => 'Gawat Darurat (IGD)',
                'instansi_pelaksana' => 'Kamar Jenazah',
                'kelompok_tindakan' => 'Pelayanan Kamar Jenazah',
                'nama_tindakan' => 'Penyimpanan Jenazah/Hari',
                'detail_tindakan' => 'Layanan penyimpanan jenazah per hari',
                'js' => 55000,
                'jp' => 55000,
                'tarif' => 110000,
            ],
            [
                'kode_tarif' => 'TR01073',
                'kode' => 'KT44',
                'instansi' => 'Gawat Darurat (IGD)',
                'instansi_pelaksana' => 'Kamar Jenazah',
                'kelompok_tindakan' => 'Pelayanan Kamar Jenazah',
                'nama_tindakan' => 'Pemandian Jenazah',
                'detail_tindakan' => 'Layanan pemandian dan persiapan jenazah',
                'js' => 250000,
                'jp' => 250000,
                'tarif' => 500000,
            ],
            [
                'kode_tarif' => 'TR01074',
                'kode' => 'KT44',
                'instansi' => 'Gawat Darurat (IGD)',
                'instansi_pelaksana' => 'Kamar Jenazah',
                'kelompok_tindakan' => 'Pelayanan Kamar Jenazah',
                'nama_tindakan' => 'Konservasi Jenazah',
                'detail_tindakan' => 'Layanan konservasi dan pengawetan jenazah',
                'js' => 100000,
                'jp' => 100000,
                'tarif' => 200000,
            ],
            [
                'kode_tarif' => 'TR01075',
                'kode' => 'KT44',
                'instansi' => 'Gawat Darurat (IGD)',
                'instansi_pelaksana' => 'Kamar Jenazah',
                'kelompok_tindakan' => 'Pelayanan Kamar Jenazah',
                'nama_tindakan' => 'Pemulasaraan Jenazah Ringan',
                'detail_tindakan' => 'Layanan pemulasaraan jenazah tingkat ringan',
                'js' => 250000,
                'jp' => 250000,
                'tarif' => 500000,
            ],
            [
                'kode_tarif' => 'TR01076',
                'kode' => 'KT44',
                'instansi' => 'Gawat Darurat (IGD)',
                'instansi_pelaksana' => 'Kamar Jenazah',
                'kelompok_tindakan' => 'Pelayanan Kamar Jenazah',
                'nama_tindakan' => 'Pemulasaraan Jenazah Sedang',
                'detail_tindakan' => 'Layanan pemulasaraan jenazah tingkat sedang',
                'js' => 300000,
                'jp' => 500000,
                'tarif' => 800000,
            ],
            [
                'kode_tarif' => 'TR01077',
                'kode' => 'KT44',
                'instansi' => 'Gawat Darurat (IGD)',
                'instansi_pelaksana' => 'Kamar Jenazah',
                'kelompok_tindakan' => 'Pelayanan Kamar Jenazah',
                'nama_tindakan' => 'Pemulasaraan Jenazah Besar',
                'detail_tindakan' => 'Layanan pemulasaraan jenazah tingkat besar',
                'js' => 350000,
                'jp' => 750000,
                'tarif' => 1100000,
            ],
            [
                'kode_tarif' => 'TR01078',
                'kode' => 'KT44',
                'instansi' => 'Gawat Darurat (IGD)',
                'instansi_pelaksana' => 'Kamar Jenazah',
                'kelompok_tindakan' => 'Pelayanan Kamar Jenazah',
                'nama_tindakan' => 'Pengawetan Jenazah / Formalin',
                'detail_tindakan' => 'Layanan pengawetan jenazah menggunakan formalin',
                'js' => 500000,
                'jp' => 500000,
                'tarif' => 1000000,
            ],
            [
                'kode_tarif' => 'TR01079',
                'kode' => 'KT44',
                'instansi' => 'Gawat Darurat (IGD)',
                'instansi_pelaksana' => 'Kamar Jenazah',
                'kelompok_tindakan' => 'Pelayanan Kamar Jenazah',
                'nama_tindakan' => 'Upacara Jenazah',
                'detail_tindakan' => 'Layanan upacara dan ceremonial jenazah',
                'js' => 800000,
                'jp' => 800000,
                'tarif' => 1600000,
            ],
            [
                'kode_tarif' => 'TR01080',
                'kode' => 'KT44',
                'instansi' => 'Gawat Darurat (IGD)',
                'instansi_pelaksana' => 'Kamar Jenazah',
                'kelompok_tindakan' => 'Pelayanan Kamar Jenazah',
                'nama_tindakan' => 'Visum Jenazah (PL)',
                'detail_tindakan' => 'Pemeriksaan visum jenazah untuk keperluan hukum',
                'js' => 200000,
                'jp' => 1500000,
                'tarif' => 1700000,
            ],
        ];

        foreach ($tarifs as $tarif) {
            Tarif::create($tarif);
        }
    }
}
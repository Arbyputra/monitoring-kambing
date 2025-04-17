<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DataKambingSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 30; $i++) {
            $jenis = $i % 2 == 0 ? 'jantan' : 'betina';
            $beratAwal = rand(20, 40);
            $riwayat = json_encode([
                $beratAwal,
                $beratAwal + rand(1, 2),
                $beratAwal + rand(3, 4),
            ]);

            $divaksin = $i % 3 != 0; // 2 dari 3 kambing divaksin
            $data[] = [
                'kode' => 'GT' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'jenis_kelamin' => $jenis,
                'perkiraan_umur' => rand(5, 24),
                'warna_bulu' => $jenis === 'jantan' ? 'Hitam Putih' : 'Coklat Muda',
                'berat_terakhir' => $beratAwal + rand(3, 5),
                'riwayat_berat' => $riwayat,
                'average_gain' => rand(20, 50) / 100, // misal 0.25
                'riwayat_kepemilikan' => 'Pak Budi / Desa Jetis',
                'status_vaksinasi' => $divaksin ? 'sudah' : 'belum',
                'riwayat_vaksinasi' => $divaksin ? 'Vaksin PMK (2023), Vaksin Enterotoxemia (2024)' : null,
                'gambar' => $i % 5 == 0 ? 'kambing.jpg' : 'noimage.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('data_kambing')->insert($data);
    }
}

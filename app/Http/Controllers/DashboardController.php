<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\data_kambing;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKambing = data_kambing::count();

        $rataAdg = data_kambing::avg('average_gain');

        $jenisKelamin = data_kambing::selectRaw('jenis_kelamin, COUNT(*) as jumlah')
            ->groupBy('jenis_kelamin')->pluck('jumlah', 'jenis_kelamin');

        $beratLabels = data_kambing::limit(7)->pluck('kode');
        $beratData = data_kambing::limit(7)->pluck('berat_terakhir');

        $totalKambing = data_kambing::count();
        $rataAdg = data_kambing::avg('average_gain');

        $jenisKelamin = data_kambing::selectRaw('jenis_kelamin, COUNT(*) as jumlah')
            ->groupBy('jenis_kelamin')->pluck('jumlah', 'jenis_kelamin');

        $beratLabels = data_kambing::limit(7)->pluck('kode');
        $beratData = data_kambing::limit(7)->pluck('berat_terakhir');

        // Ambil 1 kambing untuk grafik pertumbuhan
        $sampleKambing = data_kambing::whereNotNull('riwayat_berat')->latest()->first();
        $grafikKode = $sampleKambing?->kode ?? null;
        $riwayatBerat = [];

        if ($sampleKambing && $sampleKambing->riwayat_berat) {
            $decoded = json_decode($sampleKambing->riwayat_berat, true);
            $riwayatBerat = is_array($decoded) ? $decoded : [];
        }

        // Deteksi kambing stagnan: berat 3 terakhir sama
        $stagnan = data_kambing::all()->filter(function ($k) {
            $berats = json_decode($k->riwayat_berat ?? '[]');
            if (is_array($berats) && count($berats) >= 3) {
                $last = array_slice($berats, -3);
                return count(array_unique($last)) === 1; // semua berat sama
            }
            return false;
        });

        // Kelompok umur (bulan): <10, 10–15, >15
        $umurGroups = [
            'Umur < 10' => data_kambing::where('perkiraan_umur', '<', 10)->avg('berat_terakhir'),
            'Umur 10-15' => data_kambing::whereBetween('perkiraan_umur', [10, 15])->avg('berat_terakhir'),
            'Umur > 15' => data_kambing::where('perkiraan_umur', '>', 15)->avg('berat_terakhir'),
        ];

        // Jumlah kambing berdasarkan status vaksinasi
        $kambingDivaksin = data_kambing::whereNotNull('riwayat_vaksinasi')->where('riwayat_vaksinasi', '!=', '')->count();
        $kambingBelumDivaksin = $totalKambing - $kambingDivaksin;

        return view('dashboard', compact(
            'totalKambing',
            'rataAdg',
            'jenisKelamin',
            'beratLabels',
            'beratData',
            'grafikKode',
            'riwayatBerat',
            'stagnan',
            'umurGroups',
            'kambingDivaksin',
            'kambingBelumDivaksin',
        ));
    }
}

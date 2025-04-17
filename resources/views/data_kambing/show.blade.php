@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Detail Kambing</h2>

        <div class="row">
            <!-- KIRI: GAMBAR -->
            <div class="col-md-4 text-center">
                <div class="border rounded-4 overflow-hidden shadow-sm" style="height: 300px;">
                    <img src="{{ asset('images/' . ($kambing->gambar ?? 'noimage.jpg')) }}" alt="Foto Kambing"
                        class="img-fluid h-100 w-100 object-fit-cover">
                </div>
            </div>

            <!-- KANAN: DETAIL -->
            <div class="col-md-8">
                <div class="card p-4 shadow-sm rounded-4">
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Kode</div>
                        <div class="col-sm-8">{{ $kambing->kode }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Jenis Kelamin</div>
                        <div class="col-sm-8">{{ ucfirst($kambing->jenis_kelamin) }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Perkiraan Umur</div>
                        <div class="col-sm-8">{{ $kambing->perkiraan_umur }} bulan</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Warna Bulu</div>
                        <div class="col-sm-8">{{ $kambing->warna_bulu }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Berat Terakhir</div>
                        <div class="col-sm-8">{{ $kambing->berat_terakhir }} kg</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Riwayat Berat</div>
                        <div class="col-sm-8">
                            @if ($kambing->riwayat_berat && is_array(json_decode($kambing->riwayat_berat)))
                                @foreach (json_decode($kambing->riwayat_berat) as $berat)
                                    <span class="badge bg-secondary">{{ $berat }} kg</span>
                                @endforeach
                            @else
                                <em>Belum ada data</em>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Average Gain</div>
                        <div class="col-sm-8">{{ $kambing->average_gain ?? '-' }} kg/hari</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Riwayat Kepemilikan</div>
                        <div class="col-sm-8">{{ $kambing->riwayat_kepemilikan ?? '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-semibold">Status Vaksinasi</div>
                        <div class="col-sm-8 text-capitalize">{{ $kambing->status_vaksinasi }}</div>
                    </div>
                    @if($kambing->status_vaksinasi === 'sudah')
                        <div class="row mb-2">
                            <div class="col-sm-4 fw-semibold">Riwayat Vaksinasi</div>
                            <div class="col-sm-8">{!! nl2br(e($kambing->riwayat_vaksinasi ?? '-')) !!}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <a href="{{ route('data_kambing.index') }}" class="btn btn-secondary mt-4">Kembali ke Daftar</a>
    </div>
@endsection

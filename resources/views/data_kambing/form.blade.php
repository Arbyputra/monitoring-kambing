<div class="mb-3">
    <label class="form-label">Kode</label>
    <input type="text" name="kode" class="form-control border-secondary"
        value="{{ old('kode', $kambing->kode ?? '') }}" placeholder="Contoh: GT001" required>
</div>

<div class="mb-3">
    <label class="form-label">Jenis Kelamin</label>
    <select name="jenis_kelamin" class="form-control border-secondary" required>
        <option value="">-- Pilih Jenis Kelamin --</option>
        <option value="jantan" {{ old('jenis_kelamin', $kambing->jenis_kelamin ?? '') == 'jantan' ? 'selected' : '' }}>
            Jantan</option>
        <option value="betina" {{ old('jenis_kelamin', $kambing->jenis_kelamin ?? '') == 'betina' ? 'selected' : '' }}>
            Betina</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Perkiraan Umur (bulan)</label>
    <input type="number" name="perkiraan_umur" class="form-control border-secondary"
        value="{{ old('perkiraan_umur', $kambing->perkiraan_umur ?? '') }}" placeholder="Contoh: 12" required>
</div>

<div class="mb-3">
    <label class="form-label">Warna Bulu</label>
    <input type="text" name="warna_bulu" class="form-control border-secondary"
        value="{{ old('warna_bulu', $kambing->warna_bulu ?? '') }}" placeholder="Contoh: Putih cokelat belang" required>
</div>

<div class="mb-3">
    <label class="form-label">Berat Terakhir (kg)</label>
    <input type="number" step="0.01" name="berat_terakhir" class="form-control border-secondary"
        value="{{ old('berat_terakhir', $kambing->berat_terakhir ?? '') }}" placeholder="Contoh: 25.5" required>
</div>

<div class="mb-3">
    <label class="form-label">Riwayat Berat (pisahkan dengan koma)</label>
    <input type="text" name="riwayat_berat" class="form-control border-secondary"
        value="{{ old('riwayat_berat', isset($kambing) ? implode(',', json_decode($kambing->riwayat_berat ?? '') ?? []) : '') }}"
        placeholder="Contoh: 20.1,21.3,23.0,25.5">
</div>

<div class="mb-3">
    <label class="form-label">Average Gain (kg/hari)</label>
    <input type="number" step="0.01" name="average_gain" class="form-control border-secondary"
        value="{{ old('average_gain', $kambing->average_gain ?? '') }}" placeholder="Contoh: 0.25">
</div>

<div class="mb-3">
    <label class="form-label">Riwayat Kepemilikan</label>
    <input type="text" name="riwayat_kepemilikan" class="form-control border-secondary"
        value="{{ old('riwayat_kepemilikan', $kambing->riwayat_kepemilikan ?? '') }}" placeholder="Contoh: Pak Darto">
</div>

<div class="mb-3">
    <label class="form-label d-block">Status Vaksinasi</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status_vaksinasi" id="vaksin_sudah" value="sudah"
            {{ old('status_vaksinasi', $kambing->status_vaksinasi ?? '') === 'sudah' ? 'checked' : '' }}>
        <label class="form-check-label" for="vaksin_sudah">Sudah Vaksin</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="status_vaksinasi" id="vaksin_belum" value="belum"
            {{ old('status_vaksinasi', $kambing->status_vaksinasi ?? '') === 'belum' ? 'checked' : '' }}>
        <label class="form-check-label" for="vaksin_belum">Belum Vaksin</label>
    </div>
</div>

<div class="mb-3" id="riwayatVaksinGroup" style="display: none;">
    <label class="form-label">Riwayat Vaksinasi</label>
    <textarea name="riwayat_vaksinasi" class="form-control border-secondary">{{ old('riwayat_vaksinasi', $kambing->riwayat_vaksinasi ?? '') }}</textarea>
</div>


{{-- Script untuk show/hide --}}
@push('scripts')
    <script>
        function toggleRiwayatField() {
            const isSudah = document.getElementById('vaksin_sudah').checked;
            document.getElementById('riwayatVaksinGroup').style.display = isSudah ? 'block' : 'none';
        }

        document.getElementById('vaksin_sudah').addEventListener('change', toggleRiwayatField);
        document.getElementById('vaksin_belum').addEventListener('change', toggleRiwayatField);

        // Jalankan saat halaman pertama kali dibuka
        toggleRiwayatField();
    </script>
@endpush

<div class="mb-3">
    <label class="form-label">Gambar</label>
    <input type="file" name="gambar" class="form-control border-secondary">
    @if (isset($kambing) && $kambing->gambar)
        <div class="mt-2">
            <img src="{{ asset('images/' . $kambing->gambar) }}" alt="Gambar" width="100">
        </div>
    @endif
</div>

@push('scripts')
    <script>
        function toggleRiwayatField() {
            const isSudah = document.getElementById('vaksin_sudah').checked;
            const riwayatField = document.getElementById('riwayatVaksinGroup');
            if (riwayatField) {
                riwayatField.style.display = isSudah ? 'block' : 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleRiwayatField();

            const radioSudah = document.getElementById('vaksin_sudah');
            const radioBelum = document.getElementById('vaksin_belum');

            if (radioSudah && radioBelum) {
                radioSudah.addEventListener('change', toggleRiwayatField);
                radioBelum.addEventListener('change', toggleRiwayatField);
            }
        });
    </script>
@endpush

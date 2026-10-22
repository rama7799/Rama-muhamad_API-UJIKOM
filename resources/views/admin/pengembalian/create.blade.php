@extends('layouts.app')

@section('title', 'Proses Pengembalian - Panel Admin')
@section('header-title', 'Proses Pengembalian')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-2xl">

    <div class="mb-6 space-y-1">
        <p class="text-xs text-gray-500 uppercase font-semibold">Peminjam</p>
        <p class="text-lg font-bold text-red-600">{{ $peminjaman->user->name ?? '-' }}</p>

        <p class="text-xs text-gray-500 uppercase font-semibold mt-3">Batas Waktu Kembali</p>
        <p class="text-gray-800 font-medium">{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali_plan)->format('d/m/Y') }}</p>

        <p class="text-xs text-gray-500 uppercase font-semibold mt-3">Alat yang Dipinjam</p>
        <ul class="list-disc list-inside text-gray-800">
            @foreach($peminjaman->detailPinjams as $detail)
                <li>{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }} — {{ $detail->jumlah }} pcs</li>
            @endforeach
        </ul>
    </div>

    <form action="{{ route('admin.pengembalian.store', $peminjaman->id) }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Kembali</label>
            <input type="date" name="tgl_kembali" id="tgl_kembali" required
                value="{{ old('tgl_kembali', now()->format('Y-m-d')) }}"
                data-batas="{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali_plan)->format('Y-m-d') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Kondisi Alat</label>
            <select name="kondisi_kembali" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Denda (Rp)</label>
            <input type="number" name="denda" id="denda" min="0" placeholder="0"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p id="denda-info" class="text-xs text-gray-500 mt-1">
                Tidak ada denda — pengembalian tepat waktu atau lebih cepat.
            </p>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                Simpan Pengembalian
            </button>
            <a href="{{ route('admin.pengembalian.pilih') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition">
                Batal
            </a>
        </div>
    </form>
</div>

{{-- Hitung & tampilkan saran denda otomatis (Rp1.000/hari telat) secara live di form,
     tapi tetap bisa diedit manual sebelum disimpan --}}
<script>
    const tglKembaliInput = document.getElementById('tgl_kembali');
    const dendaInput = document.getElementById('denda');
    const dendaInfo = document.getElementById('denda-info');
    const TARIF_PER_HARI = 1000;

    function hitungDenda() {
        const batas = new Date(tglKembaliInput.dataset.batas);
        const kembali = new Date(tglKembaliInput.value);
        const selisihMs = kembali - batas;
        const hariTelat = selisihMs > 0 ? Math.ceil(selisihMs / (1000 * 60 * 60 * 24)) : 0;

        if (hariTelat > 0) {
            const denda = hariTelat * TARIF_PER_HARI;
            dendaInput.value = denda;
            dendaInfo.textContent = `Telat ${hariTelat} hari — saran denda Rp${denda.toLocaleString('id-ID')} (bisa diubah manual).`;
            dendaInfo.classList.add('text-red-600');
        } else {
            dendaInput.value = 0;
            dendaInfo.textContent = 'Tidak ada denda — pengembalian tepat waktu atau lebih cepat.';
            dendaInfo.classList.remove('text-red-600');
        }
    }

    tglKembaliInput.addEventListener('change', hitungDenda);
    document.addEventListener('DOMContentLoaded', hitungDenda);
</script>
@endsection
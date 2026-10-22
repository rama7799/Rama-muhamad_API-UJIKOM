@extends('layouts.app')

@section('title', 'Pilih Peminjaman - Panel Admin')
@section('header-title', 'Pilih Peminjaman untuk Dikembalikan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Peminjaman Aktif (Belum Dikembalikan)</h3>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-600 border-collapse">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3">Peminjam</th>
                    <th class="px-4 py-3">Alat Dipinjam</th>
                    <th class="px-4 py-3">Tgl Pinjam / Rencana Kembali</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($peminjamans as $item)
                    <tr class="hover:bg-gray-50 transition align-top">
                        <td class="px-4 py-4 font-medium text-gray-900">
                            {{ $item->user->name ?? '-' }}
                        </td>
                        <td class="px-4 py-4">
                            @forelse($item->detailPinjams as $detail)
                                <div class="mb-1 last:mb-0">
                                    <span class="font-medium text-gray-800">{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}</span>
                                    <span class="text-gray-400 text-xs">({{ $detail->jumlah }} pcs)</span>
                                </div>
                            @empty
                                <span class="text-gray-400 text-xs">-</span>
                            @endforelse
                        </td>
                        <td class="px-4 py-4">
                            Pinjam: {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('Y-m-d') }}<br>
                            Rencana: {{ \Carbon\Carbon::parse($item->tgl_kembali_plan)->format('Y-m-d') }}
                        </td>
                        <td class="px-4 py-4">
                            <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('admin.pengembalian.create', $item->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                                Proses Kembali
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">Tidak ada peminjaman aktif saat ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
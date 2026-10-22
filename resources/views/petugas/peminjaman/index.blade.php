@extends('layouts.app')

@section('title', 'Kelola Peminjaman - Petugas')
@section('header-title', 'Daftar Pengajuan & Transaksi Peminjaman')

@section('content')

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Peminjaman --}}
    <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <div class="p-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Data Peminjaman</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                        <th class="py-3 px-4 border-b">Peminjam</th>
                        <th class="py-3 px-4 border-b">Tanggal Pinjam</th>
                        <th class="py-3 px-4 border-b">Rencana Kembali</th>
                        <th class="py-3 px-4 border-b">Status</th>
                        <th class="py-3 px-4 border-b">Alat yang Dipinjam</th>
                        <th class="py-3 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($peminjamans as $item)
                        <tr class="hover:bg-gray-50 transition align-top">
                            <td class="py-3 px-4 border-b font-medium text-gray-900">
                                {{ $item->user->name ?? '-' }}
                            </td>
                            <td class="py-3 px-4 border-b">
                                {{ $item->tgl_pinjam }}
                            </td>
                            <td class="py-3 px-4 border-b">
                                {{ $item->tgl_kembali_plan }}
                            </td>
                            <td class="py-3 px-4 border-b">
                                <span class="px-2.5 py-1 rounded text-xs font-semibold 
                                    @if($item->status == 'diajukan') bg-yellow-100 text-yellow-700 
                                    @elseif($item->status == 'dipinjam') bg-blue-100 text-blue-700 
                                    @elseif($item->status == 'selesai') bg-emerald-100 text-emerald-700 
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 border-b">
                                <ul class="list-disc list-inside space-y-1 text-xs">
                                    @foreach($item->detailPinjam as $detail)
                                        <li>{{ $detail->alat->nama_alat ?? 'Alat' }} ({{ $detail->jumlah }} pcs)</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="py-3 px-4 border-b">
                                @if($item->status == 'diajukan')
                                    <form action="{{ route('petugas.peminjaman.setujui', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs px-3 py-1.5 rounded transition font-semibold">
                                            Setujui
                                        </button>
                                    </form>
                                @elseif($item->status == 'dipinjam')
                                    <form action="{{ route('petugas.peminjaman.proses', $item->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <input type="hidden" name="kondisi_kembali" value="Baik">
                                        <input type="hidden" name="denda" value="0">
                                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white text-xs px-3 py-1.5 rounded transition font-semibold" onclick="return confirm('Proses pengembalian alat ini?')">
                                            Terima Kembali
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
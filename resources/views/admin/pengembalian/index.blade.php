@extends('layouts.app')

@section('title', 'Data Pengembalian - Panel Admin')
@section('header-title', 'Manajemen Pengembalian')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 p-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
        <a href="{{ route('admin.pengembalian.pilih') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition whitespace-nowrap">
            + Proses Pengembalian
        </a>

        <form method="GET" action="{{ route('admin.pengembalian.index') }}" class="flex gap-2 w-full sm:w-auto">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Cari berdasarkan nama peminjam atau status..."
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 rounded-lg text-sm font-semibold transition whitespace-nowrap">
                Cari
            </button>
        </form>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-600 border-collapse">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3">Peminjam</th>
                    <th class="px-4 py-3">Alat Dipinjam</th>
                    <th class="px-4 py-3">Tgl Kembali</th>
                    <th class="px-4 py-3">Kondisi</th>
                    <th class="px-4 py-3">Denda</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($pengembalians as $item)
                    <tr class="hover:bg-gray-50 transition align-top">
                        <td class="px-4 py-4 font-medium text-gray-900">
                            {{ $item->peminjaman->user->name ?? '-' }}
                        </td>

                        <td class="px-4 py-4">
                            @forelse($item->peminjaman->detailPinjams ?? [] as $detail)
                                <div class="flex items-center gap-2 mb-2 last:mb-0">
                                    <div class="w-9 h-9 rounded bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400 text-xs">
                                        🔧
                                    </div>
                                    <div>
                                        <div class="text-gray-800 font-medium leading-tight">
                                            {{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}
                                        </div>
                                        <span class="inline-block bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full mt-0.5">
                                            {{ $detail->jumlah }} pcs
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <span class="text-gray-400 text-xs">-</span>
                            @endforelse
                        </td>

                        <td class="px-4 py-4">
                            {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('Y-m-d') }} 00:00:00
                        </td>

                        <td class="px-4 py-4">{{ $item->kondisi_kembali }}</td>

                        <td class="px-4 py-4 font-semibold {{ $item->denda > 0 ? 'text-red-600' : 'text-gray-500' }}">
                            Rp {{ number_format($item->denda, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-4">
                            @php
                                $status = $item->peminjaman->status ?? 'dikembalikan';
                            @endphp
                            @if($status == 'terlambat')
                                <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full">Telat</span>
                            @else
                                <span class="bg-emerald-100 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">Dikembalikan</span>
                            @endif
                        </td>

                        <td class="px-4 py-4 text-center whitespace-nowrap">
                            <a href="{{ route('admin.pengembalian.show', $item->id) }}"
                                class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition mr-1">
                                Detail
                            </a>
                            <form action="{{ route('admin.pengembalian.destroy', $item->id) }}" method="POST"
                                class="inline-block"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? Status peminjaman akan dikembalikan menjadi dipinjam.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">Belum ada data pengembalian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pengembalians->links() }}
    </div>
</div>
@endsection
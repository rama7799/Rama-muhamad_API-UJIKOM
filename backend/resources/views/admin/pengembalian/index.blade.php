@extends('layouts.app')

@section('title', 'Data Pengembalian - Panel Petugas')
@section('header-title', 'Daftar Pengembalian Alat')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 p-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-Berikut kode Blade yang sudah digabung dan dirapikan tanpa mengubah struktur HTML atau kelas Tailwind bawaanmu:

```blade
@extends('layouts.app')

@section('title', 'Data Pengembalian - Panel Admin')
@section('header-title', 'Daftar Pengembalian Alat')

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
        <a href="{{ route('admin.pengembalian.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            + Proses Pengembalian Baru
        </a>

        <form method="GET" action="{{ route('admin.pengembalian.index') }}" class="flex gap-2 w-full sm:w-auto">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari peminjam / kondisi..." class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-64">
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                Cari
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600 border-collapse">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Peminjam</th>
                    <th class="px-4 py-3">Tgl Kembali</th>
                    <th class="px-4 py-3">Kondisi</th>
                    <th class="px-4 py-3">Denda</th>
                    <th class="px-4 py-3">Petugas</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengembalians as $index => $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $pengembalians->firstItem() + $index }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $item->peminjaman->user->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">{{ $item->kondisi_kembali }}</td>
                        <td class="px-4 py-3 text-red-600 font-semibold">Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">{{ $item->petugas->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('admin.pengembalian.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? Status peminjaman akan dikembalikan menjadi dipinjam.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data pengembalian.</td>
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
@extends('layouts.app') <!-- Sesuaikan dengan nama layout admin kamu jika berbeda -->
@section('title', 'Kelola Alat - Panel Admin')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Alat</h2>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <!-- Form Pencarian -->
        <form action="{{ route('admin.alat.index') }}" method="GET" class="flex w-full sm:w-1/2 mb-4 sm:mb-0">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama alat, kategori..." class="w-full border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-800">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-r-md hover:bg-gray-700">Cari</button>
        </form>

        <!-- Tombol Tambah -->
        <a href="{{ route('admin.alat.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            + Tambah Alat
        </a>
    </div>

    <!-- Tabel Data Alat -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="border border-gray-200 px-4 py-2 text-left text-sm font-bold text-gray-700 uppercase">No</th>
                    <th class="border border-gray-200 px-4 py-2 text-left text-sm font-bold text-gray-700 uppercase">Gambar</th>
                    <th class="border border-gray-200 px-4 py-2 text-left text-sm font-bold text-gray-700 uppercase">Nama Alat</th>
                    <th class="border border-gray-200 px-4 py-2 text-left text-sm font-bold text-gray-700 uppercase">Kategori</th>
                    <th class="border border-gray-200 px-4 py-2 text-center text-sm font-bold text-gray-700 uppercase">Stok</th>
                    <th class="border border-gray-200 px-4 py-2 text-center text-sm font-bold text-gray-700 uppercase">Status</th>
                    <th class="border border-gray-200 px-4 py-2 text-center text-sm font-bold text-gray-700 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alats as $index => $alat)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-200 px-4 py-2 text-center">{{ $alats->firstItem() + $index }}</td>
                        <td class="border border-gray-200 px-4 py-2">
                            @if($alat->gambar)
                                <img src="{{ asset($alat->gambar) }}" alt="{{ $alat->nama_alat }}" class="w-16 h-16 object-cover rounded mx-auto">
                            @else
                                <span class="text-gray-400 text-xs italic">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td class="border border-gray-200 px-4 py-2">{{ $alat->nama_alat }}</td>
                        <td class="border border-gray-200 px-4 py-2">{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                        <td class="border border-gray-200 px-4 py-2 text-center">{{ $alat->stok }}</td>
                        <td class="border border-gray-200 px-4 py-2 text-center">{{ $alat->status_kondisi }}</td>
                        <td class="border border-gray-200 px-4 py-2">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.alat.edit', $alat->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded text-sm">Edit</a>
                                <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data alat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="border border-gray-200 px-4 py-4 text-center text-gray-500">Data alat belum tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $alats->links() }}
    </div>
</div>
@endsection
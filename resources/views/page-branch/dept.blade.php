@extends('../component/master')
@section('title', 'Departemen & Posisi')
@section('content')

    <div class="container mx-auto p-6 lg:p-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="flex flex-col gap-6">

                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-4 border-b">
                        <h2 class="text-lg font-semibold text-gray-800">Buat Departemen Baru</h2>
                    </div>
                    <form action="{{ route('departments.store') }}" method="POST" class="p-6">
                        @csrf
                        <div>
                            <label for="nama_departemen" class="block text-sm font-medium text-gray-700">Nama
                                Departemen</label>
                            <input name="nama_departemen" type="text" id="nama_departemen"
                                class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none"
                                placeholder="Cth: Teknologi">
                        </div>
                        <div class="flex justify-end pt-4 mt-4">
                            <button type="submit"
                                class="bg-[#ffd6a5] hover:bg-[#fccb8a] text-gray-800 font-semibold py-2 px-6 rounded-lg shadow-sm transition-colors">
                                Create
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden" x-data="{ editingId: null }">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Departemen</h2>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" placeholder="Cari departemen"
                                class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-md shadow-sm 
                                       focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                        </div>
                    </div>

                    <div class="divide-y">
                        @foreach ($departments as $dept)
                            <div class="p-4 transition-colors"
                                :class="{
                                    'bg-[#ffd6a5]/10 border-l-4 border-[#ffd6a5]': editingId ==
                                        {{ $dept->id }},
                                    'border-l-4 border-transparent hover:bg-gray-50': editingId !=
                                        {{ $dept->id }}
                                }">

                                <div x-show="editingId !== {{ $dept->id }}"
                                    class="w-full flex justify-between items-center">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $dept['nama_departemen'] }}</h3>
                                    </div>
                                    <div class="flex gap-3 text-sm font-medium">
                                        <a href="#" @click.prevent="editingId = {{ $dept->id }}"
                                            class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('departments.destroy', $dept->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:underline p-0 bg-transparent border-none cursor-pointer">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <form action="{{ route('departments.update', $dept->id) }}" method="POST"
                                    x-show="editingId === {{ $dept->id }}" x-cloak>
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center gap-3">
                                        <input name="nama_departemen" type="text" value="{{ $dept->nama_departemen }}"
                                            class="flex-grow block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                        <button type="submit"
                                            class="bg-[#ffd6a5] hover:bg-[#fccb8a] text-gray-800 font-semibold py-1 px-4 rounded-lg text-sm shadow-sm transition-colors">
                                            Simpan
                                        </button>
                                        <button type="button" @click.prevent="editingId = null"
                                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-1 px-4 rounded-lg text-sm shadow-sm transition-colors">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">

                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-4 border-b">
                        <h2 class="text-lg font-semibold text-gray-800">Buat Posisi Baru</h2>
                    </div>
                    <form action="{{ route('positions.store') }}" method="POST" class="p-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_posisi" class="block text-sm font-medium text-gray-700">Nama Posisi</label>
                                <input name="nama_jabatan" type="text" id="nama_posisi"
                                    class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none"
                                    placeholder="Cth: Senior Engineer">
                            </div>
                            <div>
                                <label for="gaji_pokok" class="block text-sm font-medium text-gray-700">Gaji Pokok</label>
                                <input name="gaji_pokok" type="number" id="gaji_pokok"
                                    class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none"
                                    placeholder="Cth: 15000000">
                            </div>
                        </div>
                        <div class="flex justify-end pt-4 mt-4">
                            <button type="submit"
                                class="bg-[#ffd6a5] hover:bg-[#fccb8a] text-gray-800 font-semibold py-2 px-6 rounded-lg shadow-sm transition-colors">
                                Create
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden" x-data="{ editingId: null }">
                    <div class="p-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Posisi</h2>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" placeholder="Cari posisi"
                                class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-md shadow-sm 
                                       focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                        </div>
                    </div>

                    <div class="divide-y">
                        @foreach ($positions as $pos)
                            <div class="p-4 transition-colors"
                                :class="{
                                    'bg-[#ffd6a5]/10 border-l-4 border-[#ffd6a5]': editingId ==
                                        {{ $pos->id }},
                                    'border-l-4 border-transparent hover:bg-gray-50': editingId !=
                                        {{ $pos->id }}
                                }">

                                <div x-show="editingId !== {{ $pos->id }}"
                                    class="w-full flex justify-between items-center">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $pos['nama_jabatan'] }}</h3>
                                        <p class="text-sm text-gray-500">Rp
                                            {{ number_format($pos->gaji_pokok, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex gap-3 text-sm font-medium">
                                        <a href="#" @click.prevent="editingId = {{ $pos->id }}"
                                            class="text-blue-600 hover:underline">Edit</a>

                                        <form action="{{ route('positions.destroy', $pos->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </div>

                                <form action="{{ route('positions.update', $pos->id) }}" method="POST"
                                    x-show="editingId === {{ $pos->id }}" x-cloak>
                                    @csrf
                                    @method('PATCH')
                                    <div class="grid grid-cols-2 gap-3 mb-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600">Nama Posisi</label>
                                            <input name="nama_jabatan" type="text" value="{{ $pos['nama_jabatan'] }}"
                                                class="mt-1 flex-grow block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600">Gaji Pokok</label>
                                            <input name="gaji_pokok" type="number" value="{{ $pos['gaji_pokok'] }}"
                                                class="mt-1 flex-grow block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                        </div>
                                    </div>
                                    <div class="flex justify-end items-center gap-3">
                                        <button type="submit"
                                            class="bg-[#ffd6a5] hover:bg-[#fccb8a] text-gray-800 font-semibold py-1 px-4 rounded-lg text-sm shadow-sm transition-colors">
                                            Simpan
                                        </button>
                                        <button type="button" @click.prevent="editingId = null"
                                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-1 px-4 rounded-lg text-sm shadow-sm transition-colors">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

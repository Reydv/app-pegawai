@extends('../component/master')

@section('title', 'Daftar Gaji')

@section('content')
    <div class="container mx-auto p-6 lg:p-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-1 flex flex-col gap-6">

                <div class="relative bg-white rounded-lg shadow-md p-4">
                    <label for="filter_bulan" class="block text-sm font-medium text-gray-700">Filter Bulan</label>
                    <input type="month" id="filter_bulan" value="{{ date('Y-m') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" placeholder="Cari karyawan..."
                                class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-md shadow-sm
focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                        </div>
                    </div>

                    <div class="divide-y">
                        @foreach ($salaries as $gaji)
                            <form action="{{ route('salaries.destroy', $gaji->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex justify-between items-center p-4 text-left transition-colors
border-l-4 border-transparent hover:bg-[#ffd6a5]/10 hover:border-[#ffd6a5]">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">
                                            {{ $gaji->employee->nama }}</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $gaji->bulan }} |
                                            <span class="font-medium">Rp
                                                {{ number_format($gaji->total_gaji, 2, ',', '.') }}</span>
                                        </p>
                                    </div>
                                    <div class="flex gap-3 text-sm font-medium">
                                        <a href="{{ route('salaries.edit', $gaji->id) }}"
                                            class="text-blue-600 hover:underline">Edit</a>
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </div>
                                </button>
                            </form>
                        @endforeach

                        <div class="p-4">
                            <div
                                class="border border-dashed border-gray-300 rounded-lg h-14 flex items-center justify-center">
                                <span class="text-gray-400 text-sm">...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 flex flex-col gap-6">

                <div class="bg-white rounded-lg shadow-md" x-data="{ open: true }">
                    <div class="flex justify-between items-center p-4 cursor-pointer" @click="open = !open">
                        <h2 class="text-lg font-semibold text-gray-800">Buat Gaji Karyawan</h2>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-gray-500 transition-transform duration-300" :class="{ 'rotate-180': !open }"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>

                    <div class="overflow-hidden transition-[max-height] duration-500 ease-in-out"
                        :class="open ? 'max-h-screen' : 'max-h-0'">
                        <div class="border-t border-gray-200">

                            <form action="{{ route('salaries.store') }}" method="POST" class="p-6 space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="karyawan_id_buat"
                                            class="block text-sm font-medium text-gray-700">Karyawan</label>
                                        <select name="karyawan_id" id="karyawan_id_buat"
                                            class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                            <option value="">Pilih Karyawan</option>
                                            @foreach ($employees as $karyawan)
                                                <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="bulan_buat"
                                            class="block text-sm font-medium text-gray-700">Bulan</label>
                                        <input type="month" name="bulan" id="bulan_buat" value="{{ date('Y-m') }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                    </div>
                                    <div>
                                        <label for="gaji_pokok_buat" class="block text-sm font-medium text-gray-700">Gaji
                                            Pokok (Rp)</label>
                                        <input type="number" name="gaji_pokok" id="gaji_pokok_buat" placeholder="15000000"
                                            step="0.01"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                    </div>
                                    <div>
                                        <label for="tunjangan_buat"
                                            class="block text-sm font-medium text-gray-700">Tunjangan (Rp)</label>
                                        <input type="number" name="tunjangan" id="tunjangan_buat" placeholder="0"
                                            step="0.01"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="potongan_buat" class="block text-sm font-medium text-gray-700">Potongan
                                            (Rp)</label>
                                        <input type="number" name="potongan" id="potongan_buat" placeholder="0"
                                            step="0.01"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="total_gaji" class="block text-sm font-medium text-gray-700">Total Gaji
                                            (Rp)</label>
                                        <input type="number" name="total_gaji" id="total_gaji" placeholder="0"
                                            step="0.01"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit"
                                        class="bg-[#ffd6a5] hover:bg-[#fccb8a] text-gray-800 font-semibold py-2 px-6 rounded-lg shadow-sm transition-colors">
                                        Create
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                @if (isset($detailGaji))
                    <div class="bg-white p-6 rounded-lg shadow-md" x-data="{ isEditing: false }">

                        <div class="relative h-8 mb-4">
                            <h2 class="text-2xl font-semibold text-gray-800 text-center">
                                {{ $detailGaji->employee->nama }}
                            </h2>
                            <a href="#" @click.prevent="isEditing = !isEditing"
                                class="absolute top-0 right-0 font-semibold py-1 px-4 rounded-lg text-sm shadow-sm transition-colors"
                                :class="isEditing ? 'bg-gray-200 hover:bg-gray-300 text-gray-700' :
                                    'bg-[#ffd6a5] hover:bg-[#fccb8a] text-gray-800'">
                                <span x-show="!isEditing">Edit</span>
                                <span x-show="isEditing" x-cloak>Batal</span>
                            </a>
                        </div>

                        <hr class="mb-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5" x-show="!isEditing">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Bulan</label>
                                <p class="mt-1 text-base text-gray-900">{{ $detailGaji->bulan }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Gaji Pokok</label>
                                <p class="mt-1 text-base text-gray-900">Rp
                                    {{ number_format($detailGaji->gaji_pokok, 2, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Tunjangan</label>
                                <p class="mt-1 text-base text-gray-900">Rp
                                    {{ number_format($detailGaji->tunjangan, 2, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Potongan</label>
                                <p class="mt-1 text-base text-gray-900">Rp
                                    {{ number_format($detailGaji->potongan, 2, ',', '.') }}</p>
                            </div>
                            <div class="md:col-span-2 border-t pt-4">
                                <label class="block text-sm font-medium text-gray-500">Total Gaji</label>
                                <p class="mt-1 text-xl font-semibold text-gray-900">Rp
                                    {{ number_format($detailGaji->total_gaji, 2, ',', '.') }}</p>
                            </div>
                        </div>

                        <form action="{{ route('salaries.update', $detailGaji->id) }}" method="POST" x-show="isEditing"
                            x-cloak>
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                <div>
                                    <label for="karyawan_id_edit"
                                        class="block text-sm font-medium text-gray-700">Karyawan</label>
                                    <select name="karyawan_id" id="karyawan_id_edit"
                                        class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                        @foreach ($employees as $karyawan)
                                            <option value="{{ $karyawan->id }}"
                                                {{ $karyawan->id == $detailGaji->karyawan_id ? 'selected' : '' }}>
                                                {{ $karyawan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="bulan_edit" class="block text-sm font-medium text-gray-700">Bulan</label>
                                    <input type="month" name="bulan" id="bulan_edit"
                                        value="{{ $detailGaji->bulan }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div>
                                    <label for="gaji_pokok_edit" class="block text-sm font-medium text-gray-700">Gaji
                                        Pokok
                                        (Rp)</label>
                                    <input type="number" name="gaji_pokok" id="gaji_pokok_edit"
                                        value="{{ $detailGaji->gaji_pokok }}" step="0.01"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div>
                                    <label for="tunjangan_edit" class="block text-sm font-medium text-gray-700">Tunjangan
                                        (Rp)</label>
                                    <input type="number" name="tunjangan" id="tunjangan_edit"
                                        value="{{ $detailGaji->tunjangan }}" step="0.01"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="potongan_edit" class="block text-sm font-medium text-gray-700">Potongan
                                        (Rp)</label>
                                    <input type="number" name="potongan" id="potongan_edit"
                                        value="{{ $detailGaji->potongan }}" step="0.01"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="total_gaji_edit" class="block text-sm font-medium text-gray-700">Total
                                        Gaji
                                        (Rp)</label>
                                    <input type="number" name="total_gaji" id="total_gaji_edit"
                                        value="{{ $detailGaji->total_gaji }}" step="0.01"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                            </div>

                            <div class="flex justify-end pt-4 mt-6 border-t">
                                <button type="submit"
                                    class="bg-[#ffd6a5] hover:bg-[#fccb8a] text-gray-800 font-semibold py-2 px-6 rounded-lg shadow-sm transition-colors">
                                    Kirim
                                </button>
                            </div>
                        </form>

                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection

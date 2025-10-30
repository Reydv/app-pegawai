@extends('../component/master')
@section('title', 'Daftar Absensi')
@section('content')
    @php
        // Ambil data absensi yang dipilih dari query string
        $selected_id = request('selected_id');
        $selectedAttendance = $selected_id ? $attendances->firstWhere('id', $selected_id) : null;

        // Ambil tanggal filter atau set ke hari ini
        $filterTanggal = request('tanggal', date('Y-m-d'));
    @endphp

    <div class="container mx-auto p-6 lg:p-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KIRI --}}
            <div class="lg:col-span-1 flex flex-col gap-6">

                <form action="{{ route('attendances.index') }}" method="GET">
                    <div class="relative bg-white rounded-lg shadow-md p-4">
                        <label for="filter_tanggal" class="block text-sm font-medium text-gray-700">Filter Tanggal</label>
                        <input type="date" id="filter_tanggal" name="tanggal" value="{{ $filterTanggal }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none"
                            onchange="this.form.submit()">
                    </div>
                </form>

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
                        @forelse ($attendances as $absensi)
                            <div
                                class="w-full flex justify-between items-center p-4 text-left transition-colors 
                                   border-l-4 {{ $selectedAttendance && $selectedAttendance->id == $absensi->id ? 'bg-[#ffd6a5]/10 border-[#ffd6a5]' : 'border-transparent hover:bg-[#ffd6a5]/10 hover:border-[#ffd6a5]' }}">
                                <a href="{{ route('attendances.index', ['selected_id' => $absensi->id, 'tanggal' => $filterTanggal]) }}"
                                    class="flex-1">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">
                                            {{ $absensi->employee->nama_lengkap ?? 'Karyawan Tidak Ditemukan' }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            Status: <span
                                                class="font-medium capitalize">{{ $absensi->status_absensi }}</span>
                                            (Masuk:
                                            {{ $absensi->waktu_masuk ? \Carbon\Carbon::parse($absensi->waktu_masuk)->format('H:i') : 'N/A' }})
                                        </p>
                                    </div>
                                </a>
                                <div class="flex gap-3 text-sm font-medium">
                                    <form action="{{ route('attendances.destroy', $absensi->id) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin ingin menghapus absensi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500">
                                Tidak ada data absensi untuk tanggal ini.
                            </div>
                        @endforelse

                        <div class="p-4">
                            <div
                                class="border border-dashed border-gray-300 rounded-lg h-14 flex items-center justify-center">
                                <span class="text-gray-400 text-sm">...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- KIRI END --}}


            {{-- KANAN --}}
            <div class="lg:col-span-2 flex flex-col gap-6">

                <div class="bg-white rounded-lg shadow-md" x-data="{ open: {{ $selectedAttendance ? 'false' : 'true' }} }">
                    <div class="flex justify-between items-center p-4 cursor-pointer" @click="open = !open">
                        <h2 class="text-lg font-semibold text-gray-800">Buat Absensi</h2>
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
                            <form action="{{ route('attendances.store') }}" method="POST" class="p-6 space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="karyawan_id_buat"
                                            class="block text-sm font-medium text-gray-700">Karyawan</label>
                                        <select id="karyawan_id_buat" name="karyawan_id" required
                                            class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                            <option value="">Pilih Karyawan</option>
                                            @foreach ($employees as $karyawan)
                                                <option value="{{ $karyawan->id }}"
                                                    {{ old('karyawan_id') == $karyawan->id ? 'selected' : '' }}>
                                                    {{ $karyawan->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="tanggal_buat"
                                            class="block text-sm font-medium text-gray-700">Tanggal</label>
                                        <input type="date" id="tanggal_buat" name="tanggal"
                                            value="{{ old('tanggal', $filterTanggal) }}" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                    </div>
                                    <div>
                                        <label for="waktu_masuk_buat" class="block text-sm font-medium text-gray-700">Waktu
                                            Masuk</label>
                                        <input type="time" id="waktu_masuk_buat" name="waktu_masuk"
                                            value="{{ old('waktu_masuk') }}"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                    </div>
                                    <div>
                                        <label for="waktu_keluar_buat" class="block text-sm font-medium text-gray-700">Waktu
                                            Keluar</L>
                                            <input type="time" id="waktu_keluar_buat" name="waktu_keluar"
                                                value="{{ old('waktu_keluar') }}"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="status_absensi_buat"
                                            class="block text-sm font-medium text-gray-700">Status Absensi</label>
                                        <select id="status_absensi_buat" name="status_absensi" required
                                            class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                            <option value="hadir"
                                                {{ old('status_absensi') == 'hadir' ? 'selected' : '' }}>
                                                Hadir</option>
                                            <option value="izin" {{ old('status_absensi') == 'izin' ? 'selected' : '' }}>
                                                Izin</option>
                                            <option value="sakit"
                                                {{ old('status_absensi') == 'sakit' ? 'selected' : '' }}>
                                                Sakit</option>
                                            <option value="alpha"
                                                {{ old('status_absensi') == 'alpha' ? 'selected' : '' }}>
                                                Alpha</option>
                                        </select>
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

                @if ($selectedAttendance)
                    <div class="bg-white p-6 rounded-lg shadow-md" x-data="{ isEditing: false }">

                        <div class="relative h-8 mb-4">
                            <h2 class="text-2xl font-semibold text-gray-800 text-center">
                                {{ $selectedAttendance->employee->nama_lengkap ?? 'N/A' }}
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

                        {{-- TAMPILAN DISPLAY --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5" x-show="!isEditing" x-transition>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Tanggal</label>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ \Carbon\Carbon::parse($selectedAttendance->tanggal)->format('d / m / Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status Absensi</label>
                                <p class="mt-1 text-base text-gray-900 font-medium capitalize">
                                    {{ $selectedAttendance->status_absensi }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Waktu Masuk</label>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ $selectedAttendance->waktu_masuk ? \Carbon\Carbon::parse($selectedAttendance->waktu_masuk)->format('H:i') : 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Waktu Keluar</label>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ $selectedAttendance->waktu_keluar ? \Carbon\Carbon::parse($selectedAttendance->waktu_keluar)->format('H:i') : 'N/A' }}
                                </p>
                            </div>
                        </div>

                        {{-- FORM EDIT --}}
                        <form action="{{ route('attendances.update', $selectedAttendance->id) }}" method="POST"
                            x-show="isEditing" x-cloak x-transition>
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                <div>
                                    <label for="karyawan_id_edit"
                                        class="block text-sm font-medium text-gray-700">Karyawan</label>
                                    <select id="karyawan_id_edit" name="karyawan_id" required
                                        class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                        @foreach ($employees as $karyawan)
                                            <option value="{{ $karyawan->id }}"
                                                {{ $karyawan->id == $selectedAttendance->karyawan_id ? 'selected' : '' }}>
                                                {{ $karyawan->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="tanggal_edit"
                                        class="block text-sm font-medium text-gray-700">Tanggal</label>
                                    <input type="date" id="tanggal_edit" name="tanggal"
                                        value="{{ $selectedAttendance->tanggal }}" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div>
                                    <label for="waktu_masuk_edit" class="block text-sm font-medium text-gray-700">Waktu
                                        Masuk</label>
                                    <input type="time" id="waktu_masuk_edit" name="waktu_masuk"
                                        value="{{ $selectedAttendance->waktu_masuk ? \Carbon\Carbon::parse($selectedAttendance->waktu_masuk)->format('H:i') : '' }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div>
                                    <label for="waktu_keluar_edit" class="block text-sm font-medium text-gray-700">Waktu
                                        Keluar</label>
                                    <input type="time" id="waktu_keluar_edit" name="waktu_keluar"
                                        value="{{ $selectedAttendance->waktu_keluar ? \Carbon\Carbon::parse($selectedAttendance->waktu_keluar)->format('H:i') : '' }}"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="status_absensi_edit"
                                        class="block text-sm font-medium text-gray-700">Status
                                        Absensi</label>
                                    <select id="status_absensi_edit" name="status_absensi" required
                                        class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                        <option value="hadir"
                                            {{ $selectedAttendance->status_absensi == 'hadir' ? 'selected' : '' }}>Hadir
                                        </option>
                                        <option value="izin"
                                            {{ $selectedAttendance->status_absensi == 'izin' ? 'selected' : '' }}>Izin
                                        </option>
                                        <option value="sakit"
                                            {{ $selectedAttendance->status_absensi == 'sakit' ? 'selected' : '' }}>Sakit
                                        </option>
                                        <option value="alpha"
                                            {{ $selectedAttendance->status_absensi == 'alpha' ? 'selected' : '' }}>Alpha
                                        </option>
                                    </select>
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
            {{-- KANAN END --}}

        </div>
    </div>
@endsection

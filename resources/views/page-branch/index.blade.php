@extends('../component/master')
@section('title', 'Daftar Pegawai')
@section('content')

    <div class="container mx-auto p-6 lg:p-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KIRI --}}
            <div class="lg:col-span-1 flex flex-col gap-6">

                <form action="{{ route('employee.index') }}" method="GET">
                    <div class="relative bg-white rounded-lg shadow-md">
                        <select name="departemen_id"
                            class="w-full appearance-none bg-transparent font-semibold text-gray-700 p-4 pr-10 border-0 rounded-lg 
                                    focus:outline-none focus:ring-0"
                            onchange="this.form.submit()">
                            <option value="">Semua Departemen</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ request('departemen_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
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
                            <input type="text" placeholder="Cari karyawan"
                                class="w-full pl-10 pr-4 py-2 border-gray-300 rounded-md shadow-sm 
                                        focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                        </div>
                    </div>

                    <div class="divide-y">

                        @foreach ($employees as $karyawan)
                            <div
                                class="w-full flex justify-between items-center p-4 text-left transition-colors 
                                            border-l-4 {{ $selectedEmployee && $selectedEmployee->id == $karyawan->id ? 'bg-[#ffd6a5]/10 border-[#ffd6a5]' : 'border-transparent hover:bg-[#ffd6a5]/10 hover:border-[#ffd6a5]' }}">
                                <a href="{{ route('employee.index', ['selected_id' => $karyawan->id, 'departemen_id' => request('departemen_id')]) }}"
                                    class="flex-1">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $karyawan->nama_lengkap }}</h3>
                                        <p class="text-sm text-gray-600">
                                            {{ $karyawan->jabatan->nama_jabatan ?? 'N/A' }}
                                            ({{ $karyawan->departemen->nama_departemen ?? 'N/A' }})
                                        </p>
                                    </div>
                                </a>
                                <div class="flex gap-3 text-sm font-medium">
                                    <form action="{{ route('employee.destroy', $karyawan->id) }}" method="POST"
                                        onsubmit="return confirm('Anda yakin ingin menghapus karyawan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </div>
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
            {{-- KIRI END --}}


            {{-- KANAN --}}
            <div class="lg:col-span-2 flex flex-col gap-6">

                <div class="bg-white rounded-lg shadow-md" x-data="{ open: {{ $selectedEmployee ? 'false' : 'true' }} }">
                    <div class="flex justify-between items-center p-4 cursor-pointer" @click="open = !open">

                        <h2 class="text-lg font-semibold text-gray-800">Buat karyawan</h2>

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
                            <form action="{{ route('employee.store') }}" method="POST" class="p-6 space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama
                                            Lengkap</label>
                                        <input name="nama_lengkap" type="text" id="nama_lengkap" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none"
                                            value="{{ old('nama_lengkap') }}">
                                    </div>
                                    <div>
                                        <label for="email_buat"
                                            class="block text-sm font-medium text-gray-700">Email</label>
                                        <input name="email" type="email" id="email_buat" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none"
                                            value="{{ old('email') }}">
                                    </div>
                                    <div>
                                        <label for="telepon_buat" class="block text-sm font-medium text-gray-700">Nomor
                                            Telepon</label>
                                        <input name="nomor_telepon" type="text" id="telepon_buat" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none"
                                            value="{{ old('nomor_telepon') }}">
                                    </div>
                                    <div>
                                        <label for="tgl_lahir_buat" class="block text-sm font-medium text-gray-700">Tanggal
                                            Lahir</label>
                                        <input name="tanggal_lahir" type="date" id="tgl_lahir_buat" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none"
                                            value="{{ old('tanggal_lahir') }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="alamat_buat"
                                            class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <input name="alamat" type="text" id="alamat_buat" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none"
                                            value="{{ old('alamat') }}">
                                    </div>
                                    <div>
                                        <label for="tgl_masuk_buat"
                                            class="block text-sm font-medium text-gray-700">Tanggal
                                            Masuk</label>
                                        <input name="tanggal_masuk" type="date" id="tgl_masuk_buat" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none"
                                            value="{{ old('tanggal_masuk') }}">
                                    </div>
                                    <div>
                                        <label for="jabatan_buat" class="block text-sm font-medium text-gray-700">Jabatan
                                            </Vlabel>
                                            <select name="jabatan_id" id="jabatan_buat" required
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none bg-white">
                                                <option value="">Pilih jabatan</option>
                                                @foreach ($positions as $position)
                                                    <option value="{{ $position->id }}">{{ $position->nama_jabatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="departemen_buat"
                                            class="block text-sm font-medium text-gray-700">Departemen</label>
                                        <select name="departemen_id" id="departemen_buat" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none bg-white">
                                            <option value="">Pilih departemen</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ request('departemen_id') == $department->id ? 'selected' : '' }}>
                                                    {{ $department->nama_departemen }}
                                                </option>
                                            @endforeach
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

                @if ($selectedEmployee)
                    <div class="bg-white p-6 rounded-lg shadow-md" x-data="{ isEditing: false }">

                        <div class="relative h-8 mb-4">
                            <h2 class="text-2xl font-semibold text-gray-800 text-center">
                                {{ $selectedEmployee->nama_lengkap }}
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5" x-show="!isEditing" x-transition>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-base text-gray-900">{{ $selectedEmployee->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nomor Telepon</label>
                                <p class="mt-1 text-base text-gray-900">{{ $selectedEmployee->nomor_telepon }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Tanggal Lahir</label>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ \Carbon\Carbon::parse($selectedEmployee->tanggal_lahir)->format('d / m / Y') }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Tanggal Masuk</label>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ \Carbon\Carbon::parse($selectedEmployee->tanggal_masuk)->format('d / m / Y') }}
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500">Alamat</label>
                                <p class="mt-1 text-base text-gray-900">{{ $selectedEmployee->alamat }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Jabatan</label>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ $selectedEmployee->jabatan->nama_jabatan ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Departemen</label>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ $selectedEmployee->departemen->nama_departemen ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Status</label>
                                <div class="flex gap-6 mt-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="status_display"
                                            class="text-[#ffd6a5] focus:ring-0 focus:ring-offset-0"
                                            {{ $selectedEmployee->status == 'aktif' ? 'checked' : '' }} disabled>
                                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="status_display"
                                            class="text-[#ffd6a5] focus:ring-0 focus:ring-offset-0"
                                            {{ $selectedEmployee->status == 'nonaktif' ? 'checked' : '' }} disabled>
                                        <span class="ml-2 text-sm text-gray-700">NonAktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('employee.update', $selectedEmployee->id) }}" method="POST"
                            x-show="isEditing" x-cloak x-transition>
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                <div>
                                    <label for="nama_lengkap_edit" class="block text-sm font-medium text-gray-700">Nama
                                        Lengkap</label>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap_edit"
                                        value="{{ $selectedEmployee->nama_lengkap }}" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div>
                                    <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="edit_email"
                                        value="{{ $selectedEmployee->email }}" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div>
                                    <label for="edit_telepon" class="block text-sm font-medium text-gray-700">Nomor
                                        Telepon</label>
                                    <input type="text" name="nomor_telepon" id="edit_telepon"
                                        value="{{ $selectedEmployee->nomor_telepon }}" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div>
                                    <label for="edit_tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal
                                        Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="edit_tgl_lahir"
                                        value="{{ $selectedEmployee->tanggal_lahir }}" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div>
                                    <label for="edit_tgl_masuk" class="block text-sm font-medium text-gray-700">Tanggal
                                        Masuk</label>
                                    <input type="date" name="tanggal_masuk" id="edit_tgl_masuk"
                                        value="{{ $selectedEmployee->tanggal_masuk }}" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="edit_alamat"
                                        class="block text-sm font-medium text-gray-700">Alamat</label>
                                    <input type="text" name="alamat" id="edit_alamat"
                                        value="{{ $selectedEmployee->alamat }}" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                </div>
                                <div>
                                    <label for="edit_jabatan"
                                        class="block text-sm font-medium text-gray-700">Jabatan</label>
                                    <select id="edit_jabatan" name="jabatan_id" required
                                        class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                {{ $selectedEmployee->jabatan_id == $position->id ? 'selected' : '' }}>
                                                {{ $position->nama_jabatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="edit_departemen"
                                        class="block text-sm font-medium text-gray-700">Departemen</label>
                                    <select id="edit_departemen" name="departemen_id" required
                                        class="mt-1 block w-full bg-white border-gray-300 rounded-md shadow-sm focus:border-[#ffd6a5] focus:ring-0 focus:outline-none">
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ $selectedEmployee->departemen_id == $department->id ? 'selected' : '' }}>
                                                {{ $department->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <div class="flex gap-6 mt-2">
                                        <label class="flex items-center">
                                            <input type="radio" name="status" value="aktif"
                                                class="text-[#ffd6a5] focus:ring-0 focus:ring-offset-0"
                                                {{ $selectedEmployee->status == 'aktif' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-700">Aktif</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="status" value="nonaktif"
                                                class="text-[#ffd6a5] focus:ring-0 focus:ring-offset-0"
                                                {{ $selectedEmployee->status == 'nonaktif' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-700">NonAktif</span>
                                        </label>
                                    </div>
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

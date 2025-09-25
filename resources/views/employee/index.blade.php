<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="w-screen h-screen border-2 border-black flex flex-col justify-center items-center">
        <h1 class="mb-[50px] text-[50px]">Daftar Pegawai</h1>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th class="border-r-[2px] border-b-[2px] border-black">Nama Lengkap</th>
                    <th class="border-r-[2px] border-b-[2px] border-black">Email</th>
                    <th class="border-r-[2px] border-b-[2px] border-black">Nomor Telepon</th>
                    <th class="border-r-[2px] border-b-[2px] border-black">Tanggal Lahir</th>
                    <th class="border-r-[2px] border-b-[2px] border-black">Alamat</th>
                    <th class="border-r-[2px] border-b-[2px] border-black">Tanggal Masuk</th>
                    <th class="border-r-[2px] border-b-[2px] border-black">Status</th>
                    <th class=" border-b-[2px] border-black">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td class="border-r-[1px] border-black">{{ $employee->nama_lengkap }}</td>
                        <td class="border-r-[1px] border-black">{{ $employee->email }}</td>
                        <td class="border-r-[1px] border-black">{{ $employee->nomor_telepon }}</td>
                        <td class="border-r-[1px] border-black">{{ $employee->tanggal_lahir }}</td>
                        <td class="border-r-[1px] border-black">{{ $employee->alamat }}</td>
                        <td class="border-r-[1px] border-black">{{ $employee->tanggal_masuk }}</td>
                        <td>{{ $employee->status }}</td>
                        <td>
                            <a href="{{ route('employee.show', $employee->id) }}">Detail</a> |
                            <a href="{{ route('employee.edit', $employee->id) }}">Edit</a> |
                            <form action="{{ route('employee.destroy', $employee->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

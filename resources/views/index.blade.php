<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen bg-[#fcfaf8] ">

    <div class="h-screen w-screen flex justify-center items-center">
        <div class="flex space-x-8">

            <main
                class="w-[500px] min-h-[300px] bg-white border border-gray-300 rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-300">

                <div class="flex justify-center items-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-[25px]">
                        Informasi Akun
                    </h2>
                </div>

                <div class="text-gray-600">
                    <table class="w-full">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="flex py-2">
                                <td class="w-1/3 font-medium text-gray-900">Metode Login</td>
                                <td class="w-2/3">Google</td>
                            </tr>
                            <tr class="flex py-2">
                                <td class="w-1/3 font-medium text-gray-900">Nama</td>
                                <td class="w-2/3">Reyhan Putra Ariutama</td>
                            </tr>
                            <tr class="flex py-2">
                                <td class="w-1/3 font-medium text-gray-900">Department</td>
                                <td class="w-2/3">Dept. Technologi C4</td>
                            </tr>
                            <tr class="flex py-2">
                                <td class="w-1/3 font-medium text-gray-900">Authority</td>
                                <td class="w-2/3">HR</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-auto pt-6 flex justify-end ">
                    <form method="POST" action="#">
                        <button type="submit"
                            class="w-[100px] py-2 px-4 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>

            </main>

            <nav class="w-64 flex-shrink-0">
                <div class="flex flex-col space-y-4">

                    <a href="{{ route('employee.index') }}"
                        class="block p-4 bg-white border-x-[11px] border-[#ffd6a5] rounded-lg shadow-md text-gray-700 text-center font-medium 
          transition-all transform hover:-translate-y-1 hover:shadow-lg">
                        Employee
                    </a>
                    <a href="{{ route('salaries.index') }}"
                        class="block p-4 bg-white border-x-[11px] border-[#FFD700] rounded-lg shadow-md text-gray-700 text-center font-medium 
          transition-all transform hover:-translate-y-1 hover:shadow-lg">
                        Salaries
                    </a>
                    <a href="{{ route('departments.index') }}"
                        class="block p-4 bg-white border-x-[11px] border-[#800020] rounded-lg shadow-md text-gray-700 text-center font-medium 
          transition-all transform hover:-translate-y-1 hover:shadow-lg">
                        Department & Position
                    </a>
                    <a href="{{ route('attendances.index') }}"
                        class="block p-4 bg-white border-x-[11px] border-blue-500 rounded-lg shadow-md text-gray-700 text-center font-medium 
          transition-all transform hover:-translate-y-1 hover:shadow-lg">
                        Attendance
                    </a>
                    <a href="{{ route('employee.index') }}"
                        class="block p-4 bg-white border-x-[11px] border-[#36454F] rounded-lg shadow-md text-gray-700 text-center font-medium 
          transition-all transform hover:-translate-y-1 hover:shadow-lg">
                        Park
                    </a>

                </div>
            </nav>

        </div>
    </div>
</body>

</html>

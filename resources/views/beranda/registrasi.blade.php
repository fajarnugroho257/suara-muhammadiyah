@include('beranda.header')
<div class="bg-white py-5 md:py-10 px-10 md:px-[175px]">
    <div class="mb-0 md:mb-6">
        <div class="font-poppins text-xs md:text-base text-colorSealBrown">
            <a href="{{ route('beranda') }}"><i class="fa fa-home"></i> Home</a>
            {{-- <a href="{{ route('daftar-produk', ['semua-produk']) }}"><i class="fa fa-chevron-right"></i> Produk</a> --}}
            <a class="font-semibold" href="javascript:;"><i class="fa fa-chevron-right"></i> Form Registrasi</a>
        </div>
    </div>
    <div class="flex items-center">
        <div class="w-5 h-9 md:w-7 md:h-11 bg-royalBule rounded-md mr-3"></div>
        <h4 class=" text-center font-poppins text-royalBule text-xl font-normal md:text-3xl md:font-semibold">
            Form Registrasi
        </h4>
    </div>
    @if ($errors->any())
        <div class="bg-red-100 border border-blueColor text-red-700 px-4 py-3 rounded relative mt-6" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-blueColor text-red-700 px-4 py-3 rounded relative mt-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    <div class="block mt-7 md:mt-9 gap-6">
        <div class="border-2 md:border-2 border-colorSealBrown p-5 w-full">
            <div class="w-full h-auto font-poppins">
                <h2 class="text-xs md:text-xl text-center">Form Registrasi</h2>
                <form action="{{ route('prosesRegistrasi') }}" method="POST" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="md:grid md:grid-cols-2 gap-5 mt-5">
                        <div class="mb-0">
                            <label for="username" class="block text-gray-700 mb-1">Nama lengkap</label>
                            <input type="text" value="{{ old('user_nama_lengkap') }}" name="user_nama_lengkap"
                                placeholder="Nama lengkap" class="w-full px-3 py-2 border border-gray-300 rounded"
                                required>
                        </div>
                        <div class="mb-0">
                            <label for="username" class="block text-gray-700 mb-1">Alamat</label>
                            <input type="text" value="{{ old('user_alamat') }}" name="user_alamat"
                                placeholder="Alamat" class="w-full px-3 py-2 border border-gray-300 rounded" required>
                        </div>
                        <div class="mb-0">
                            <label for="username" class="block text-gray-700 mb-1">Telp / WA</label>
                            <input type="text" value="{{ old('user_telp') }}" name="user_telp"
                                placeholder="Telp / WA" class="w-full px-3 py-2 border border-gray-300 rounded"
                                required>
                        </div>
                        <div class="mb-0">
                            <label for="username" class="block text-gray-700 mb-1">Foto Profil</label>
                            <input type="file" value="{{ old('image') }}" name="image" placeholder="Foto Profil"
                                class="w-full px-3 py-2 border border-gray-300 rounded" required>
                        </div>
                        <div class="mb-0">
                            <label for="username" class="block text-gray-700 mb-1">Tanggal Lahir</label>
                            <input type="date" value="{{ old('user_tgl_lahir') }}" name="user_tgl_lahir"
                                placeholder="Tanggal Lahir" class="w-full px-3 py-2 border border-gray-300 rounded"
                                required>
                        </div>
                        <div class="mb-0">
                            <label for="username" class="block text-gray-700 mb-1">Gender</label>
                            <select name="user_jk" id=""
                                class="w-full px-3 py-2 border border-gray-300 rounded">
                                <option value="">Pilih Gender</option>
                                <option value="L" @selected(old('user_jk') == 'L')>LAKI - LAKI</option>
                                <option value="P" @selected(old('user_jk') == 'P')>PEREMPUAN</option>
                            </select>
                        </div>
                        <div class="mb-0">
                            <label for="nik" class="block text-gray-700 mb-1">Nik</label>
                            <input type="number" id="nik" name="nik"
                                placeholder="Nomor Induk Kewarganegaraan" value="{{ old('nik') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded" required>
                        </div>
                        <div class="mb-0">
                            <label for="password" class="block text-gray-700 mb-1">Password</label>
                            <input type="password" id="password" name="password" placeholder="Password"
                                class="w-full px-3 py-2 border border-gray-300 rounded" required>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-32 mt-4 bg-royalBule text-white py-2 rounded hover:bg-blueColor">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@include('beranda.footer')

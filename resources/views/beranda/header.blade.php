<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- @vite('resources/css/app.css') --}}
    <link rel="stylesheet" href="{{ asset('dist/css/build.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    {{-- fancy --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
</head>

<body>
    <nav class="bg-royalBule text-white px-8 py-3 flex justify-between items-center md:px-48 font-poppins">
        <a href="{{ route('beranda') }}" class="text-right md:w-[20%]">
            <h1 class="text-md">SUARA</h1>
            <h1 class="text-lg">MUHAMMADIYAH</h1>
            <h1 class="text-sm">Online Store <span class="border-b-2 mt-[2px] border-white">Cabang Kasihan</span></h1>
        </a>
        <div class="hidden md:block w-[35%]">
            {{-- <input type="text" class="border rounded-xl w-full text-black py-1 px-2"> --}}
            <form action="{{ route('searchProses') }}" method="POST">
                @method('POST')
                @csrf
                <div class="relative">
                    <input name="keyword" value="{{ $keyword ?? $headerData['keyword'] }}"
                        class="pl-3 w-full pr-10 py-1 text-black font-poppins rounded-md" type="text"
                        placeholder="Pencarian">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2"><i
                            class="fa fa-search text-royalBule text-lg"></i></button>
                </div>
            </form>
        </div>
        <div class="hidden md:block">
            <p>Hubungi Kami</p>
            <p>{{ $headerData['nomor_wa'] }}</p>
        </div>
        <div class="md:flex gap-5 items-center font-poppins">
            <div class="w-full md:hidden">
                <form action="{{ route('searchProses') }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="relative w-3/4 text-sm ml-auto">
                        <input name="keyword" value="{{ $keyword ?? $headerData['keyword'] }}"
                            class="pl-3 w-full pr-10 py-1 text-black font-poppins rounded-md" type="text"
                            placeholder="Pencarian">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2"><i
                                class="fa fa-search text-royalBule text-lg"></i></button>
                    </div>
                </form>
            </div>
            <div class="flex gap-3 justify-end mt-3 items-center">
                <div class="relative text-right">
                    <a href="{{ route('keranjang') }}"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>
                    @auth
                        @if ($headerData['keranjang'] > 0)
                            <div
                                class="absolute -top-1 -right-2 w-4 h-4 rounded-full bg-white text-black flex items-center justify-center">
                                <p class="font-poppins text-xs" id="keranjang">{{ $headerData['keranjang'] ?? '' }}</p>
                            </div>
                        @endif
                    @endauth
                </div>
                @auth
                    <div class="h-10 w-10 relative group cursor-pointer">
                        <img class="rounded-full h-full w-full shadow-lg"
                            src="{{ asset('image/profil/' . Auth::user()->users_data->image) }}" alt="">
                        <div
                            class="hidden group-hover:block bg-gray-100 text-black font-poppins text-sm w-52 absolute right-0 rounded-sm z-50">
                            <ul class="px-3 py-2">
                                <li class="border-b border-black py-1">
                                    <p class="">{{ $user->users_data->user_nama_lengkap ?? '' }}</p>
                                </li>
                                {{-- <li class="border-b border-black py-1 hover:text-royalBule"><a href="">Profil</a></li> --}}
                                <li class="border-b border-black py-1 hover:text-royalBule"><a
                                        onclick="return confirm('Apakah anda yakin akan keluar ?')"
                                        href="{{ route('logOut') }}">Keluar</a></li>
                            </ul>
                        </div>
                    </div>
                @endauth
                @guest
                    <div class="login cursor-pointer text-right">
                        <i title="Masuk" class="fa fa-sign-in-alt"></i> Masuk
                    </div>
                @endguest
            </div>

        </div>
    </nav>

@include('beranda.header')
<div class="px-8 py-3">
    <div class="md:gap-10 md:px-48">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-6"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-blueColor text-red-700 px-4 py-3 rounded relative mt-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
    </div>
    <div class=" md:flex md:gap-10 md:px-48">
        <div class="md:w-[25%]">
            <div class="flex gap-1 md:gap-2 items-center mt-2">
                <div class="h-5 w-2 md:h-7 md:w-4 bg-royalBule rounded-sm"></div>
                <h1 class="font-semibold text-md md:text-xl font-poppins text-royalBule">Kategori</h1>
            </div>
            <ul class="font-poppins text-xs md:text-md mt-4">
                <li
                    class="border my-1 py-1 px-3 hover:bg-blueColor hover:text-white @if ($kategori_slug == 'all-product') active @endif">
                    <a href="{{ route('index-beranda', ['slug' => 'all-product']) }}">Semua Produk</a>
                </li>
                @foreach ($rs_kategori as $kategori)
                    <li
                        class="border my-1 py-1 px-3 hover:bg-blueColor hover:text-white  @if ($kategori_slug == $kategori->slug) active @endif">
                        <a
                            href="{{ route('index-beranda', ['slug' => $kategori->slug]) }}">{{ $kategori->kategori_nama }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="md:w-[75%]">
            <div class="flex gap-1 md:gap-2 items-center mt-2 mb-4">
                <div class="h-5 w-2 md:h-7 md:w-4 bg-royalBule rounded-sm"></div>
                <h1 class="font-semibold text-md md:text-xl font-poppins text-royalBule">Produk Kami</h1>
            </div>
            <div class="grid grid-cols-2 mt-4 gap-4 md:grid-cols-3 md:w-full md:gap-10 md:mt-0 font-poppins">
                @foreach ($rs_produk as $produk)
                    <a href="{{ route('detail', ['slug' => $produk->slug]) }}"
                        class="box cursor-pointer hover:bg-slate-100 h-fit">
                        <div class="w-full h-36 md:h-56">
                            <img class="w-full h-full" src="{{ asset('image/produk/' . $produk->produk_image) }}"
                                alt="">
                        </div>
                        <div class="text-center py-3 border-b-2 border-l-2 border-r-2">
                            <div>
                                @for ($i = 0; $i < $produk->produk_rating; $i++)
                                    <i class="fa fa-star text-xs text-yellow-400"></i>
                                @endfor
                            </div>
                            <p class="text-sm font-medium text-royalBule">{{ $produk->produk_nama }}</p>
                            <p class="text-xs">Rp {{ number_format($produk->produk_harga, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@include('beranda.footer')

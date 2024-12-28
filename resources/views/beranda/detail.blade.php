@include('beranda.header')
<div class="bg-white py-5 md:py-10 px-10 md:px-[175px]">
    <div class="mb-4 md:mb-6">
        <div class="font-poppins text-xs md:text-base text-colorSealBrown">
            <a href="{{ route('beranda') }}"><i class="fa fa-home"></i> Home</a>
            {{-- <a href="{{ route('daftar-produk', ['semua-produk']) }}"><i class="fa fa-chevron-right"></i> Produk</a> --}}
            <a class="font-semibold" href="javascript:;"><i class="fa fa-chevron-right"></i>
                {{ $detail->produk_nama }}</a>
        </div>
    </div>
    <div class="flex items-center">
        <div class="w-5 h-9 md:w-7 md:h-11 bg-royalBule rounded-md mr-3"></div>
        <h4 class=" text-center font-poppins text-royalBule text-xl font-normal md:text-3xl md:font-semibold">
            Detail Produk
        </h4>
    </div>
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
    <div class="block lg:flex md:justify-between mt-7 md:mt-9 gap-6">
        <div class="border-2 md:border-2 border-colorSealBrown p-5 w-full lg:w-1/2">
            <div class="w-full h-56 md:h-72">
                <img class="w-full h-full" src="{{ asset('image/produk/' . $detail->produk_image) }}" alt="">
            </div>
            <div class="pt-4 ">
                <div class="swiper detailProduk">
                    <div class="swiper-wrapper grid grid-cols-4 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach ($rs_img as $img)
                            <div class="swiper-slide">
                                <div
                                    class="w-10 h-10 md:w-20 md:h-20 rounded-md overflow-hidden border-2 border-colorSealBrown">
                                    <a href="{{ asset('image/produk/detail/' . $img->data_image) }}"
                                        data-fancybox="gallery" data-caption="{{ $img->data_image }}">
                                        <img class="w-full h-full"
                                            src="{{ asset('image/produk/detail/' . $img->data_image) }}"
                                            alt="{{ $img->data_image }}">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 lg:mt-0 border-2 md:border-2 border-colorSealBrown p-5 w-full lg:w-1/2">
            <div class="flex justify-between gap-3">
                <div class="">
                    <h4 class="font-semibold font-poppins md:text-lg text-base text-colorSealBrown">Kategori :
                        <br /><span class=" text-royalBule">- {{ $detail->kategori->kategori_nama }}</span>
                    </h4>
                    <h4 class="font-semibold font-poppins md:text-lg text-base text-colorSealBrown mt-1.5">Nama Produk :
                        <br /><span class="text-royalBule">- {{ $detail->produk_nama }}</span>
                    </h4>
                </div>
                <div class="">
                    <h4 class="font-semibold font-poppins md:text-lg text-base text-colorSealBrown">Harga
                    </h4>
                    <h4 class="mt-3 font-normal font-Instrument md:text-lg text-base text-royalBule">
                        Rp {{ number_format($detail->produk_harga, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
            <h4 class="mt-4 font-semibold font-poppins md:text-lg text-base text-colorSealBrown"><span
                    class="border-b-2 border-colorSealBrown">Deskripsi</span></h4>
            <p class="mt-3 font-Instrument text-colorSealBrown text-sm text-justify md:text-base">
                {{ $detail->produk_deskripsi }}</p>
            <h4 class="mt-4 font-semibold font-poppins md:text-lg text-base text-colorSealBrown"><span
                    class="border-b-2 border-colorSealBrown">Atur Jumlah </span></h4>
            <div class="flex mt-4">
                <div id="minus"
                    class="bg-colorSealBrown hover:bg-colorWood px-2 py-1 border-colotext-colorSealBrown rounded-tl-lg rounded-bl-lg font-poppins text-xl text-white cursor-pointer">
                    -</div>
                <div id="result"
                    class="border-t border-b border-colotext-colorSealBrown px-2 py-1 font-poppins text-lg text-colorSealBrown">
                    {{ $draft->data_jlh ?? '0' }}</div>
                <div id="plus"
                    class="bg-colorSealBrown hover:bg-colorWood px-2 py-1 border-colotext-colorSealBrown rounded-tr-lg rounded-br-lg font-poppins text-xl text-white cursor-pointer">
                    +
                </div>
            </div>
            <div class="md:grid md:grid-cols-2 md:gap-3">
                <a href="javascript:;" id="cart" data-slug="{{ $detail->slug }}"
                    class="md:mt-5 mt-2 bg-royalBule hover:bg-blueColor flex gap-3 text-white
                        font-poppins items-center justify-center p-2 md:py-3 rounded-md">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <p class="text-sm md:text-lg">Masukkan Keranjang</p>
                </a>
                <a href="{{ route('keranjang') }}"
                    class="md:mt-5 mt-2 bg-blue-500 hover:bg-blue-400 flex gap-3 text-white
                        font-poppins items-center justify-center p-2 md:py-3 rounded-md">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    <p class="text-sm md:text-lg">Lihat Keranjang Anda</p>
                </a>
            </div>

        </div>
    </div>
</div>
@include('beranda.footer')

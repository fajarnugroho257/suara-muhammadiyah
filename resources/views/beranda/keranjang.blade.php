@include('beranda.header')

<div class="bg-white py-5 md:py-10 px-10 md:px-[175px]">
    <div class="mb-4 md:mb-6">
        <div class="font-poppins text-xs md:text-base text-colorSealBrown">
            <a href="{{ route('beranda') }}"><i class="fa fa-home"></i> Home</a>
            {{-- <a href="{{ route('daftar-produk', ['semua-produk']) }}"><i class="fa fa-chevron-right"></i> Produk</a> --}}
            <a class="font-semibold" href="javascript:;"><i class="fa fa-chevron-right"></i> Keranjang</a>
        </div>
    </div>
    <div class="flex items-center mb-5">
        <div class="w-5 h-9 md:w-7 md:h-11 bg-royalBule rounded-md mr-3"></div>
        <h4 class=" text-center font-poppins text-royalBule text-xl font-normal md:text-3xl md:font-semibold">
            Keranjang
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
    <div class="md:flex md:gap-3">
        <form action="{{ route('updateKeranjang') }}" method="POST" class="w-full gap-4 md:flex">
            @method('POST')
            @csrf
            <div class="md:w-[72%]">
                @foreach ($rs_cart as $item)
                    <input type="hidden" name="data_id[]" value="{{ $item->data_id }}">
                    <div class="flex w-full border-2 my-3 item">
                        <div class="w-[30%] md:w-[25%] h-auto md:h-60">
                            <img class="w-full h-full" src="{{ asset('image/produk/' . $item->produk->produk_image) }}"
                                alt="">
                        </div>
                        <div class="produk w-[70%] md:w-[75%] h-fit md:h-60 flex flex-col justify-between p-3">
                            <div class="detail-produk">
                                <div class="flex justify-between mb-1">
                                    <h1 class="font-semibold text-sm md:text-lg font-poppins text-royalBule">
                                        {{ $item->produk->produk_nama }}</h1>
                                    <h1 class="harga font-semibold text-sm md:text-lg font-poppins text-royalBule">
                                        Rp {{ number_format($item->produk->produk_harga, 0, ',', '.') }}</h1>
                                </div>
                                <p class="text-[10px] md:text-base font-poppins">{{ $item->produk->produk_deskripsi }}
                                </p>
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <h4
                                        class="mt-4 font-semibold font-poppins md:text-lg text-[10px] text-colorSealBrown">
                                        <span class="border-b-2 border-colorSealBrown">Atur Jumlah </span>
                                    </h4>
                                    <div class="flex md:mt-4 mt-2">
                                        <div
                                            class="minus bg-colorSealBrown hover:bg-colorWood px-2 py-1 border-colotext-colorSealBrown rounded-tl-lg rounded-bl-lg font-poppins text-[12px] md:text-xl text-white cursor-pointer">
                                            -</div>
                                        <div class="nilai">
                                            <input type="text" name="jumlah[]"
                                                class="w-7 text-center result_nilai border-t border-b border-colotext-colorSealBrown px-2 py-1 font-poppins text-[12px] md:text-lg text-colorSealBrown"
                                                value="{{ $item->data_jlh ?? '0' }}">
                                        </div>
                                        <div
                                            class="plus bg-colorSealBrown hover:bg-colorWood px-2 py-1 border-colotext-colorSealBrown rounded-tr-lg rounded-br-lg font-poppins text-[12px] md:text-xl text-white cursor-pointer">
                                            +
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a href="javascript:;" class="delete" data-data_id="{{ $item->data_id }}"><i
                                            class="fa fa-trash text-red-500"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="md:w-[28%] border-2 p-3 my-3 h-fit">
                <button type="submit"
                    class="bg-royalBule hover:bg-blueColor flex gap-3 text-white
                    font-poppins items-center justify-center p-2 md:py-3 rounded-md w-full">
                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                    <p class="">Checkout</p>
                </button>
            </div>
        </form>
    </div>

    @include('beranda.footer')

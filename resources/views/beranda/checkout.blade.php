@include('beranda.header')

<div class="bg-white py-5 md:py-10 px-10 md:px-[175px]">
    <div class="mb-4 md:mb-6">
        <div class="font-poppins text-xs md:text-base text-colorSealBrown">
            <a href="{{ route('beranda') }}"><i class="fa fa-home"></i> Home</a>
            {{-- <a href="{{ route('daftar-produk', ['semua-produk']) }}"><i class="fa fa-chevron-right"></i> Produk</a> --}}
            <a class="font-semibold" href="javascript:;"><i class="fa fa-chevron-right"></i> Checkout</a>
        </div>
    </div>
    <div class="flex items-center mb-5">
        <div class="w-5 h-9 md:w-7 md:h-11 bg-royalBule rounded-md mr-3"></div>
        <h4 class=" text-center font-poppins text-royalBule text-xl font-normal md:text-3xl md:font-semibold">
            Checkout
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
    <div class="flex gap-4 items-start border-t border-b border-royalBule py-3">
        <i class="fa fa-map-signs text-royalBule"></i>
        <div class="font-poppins text-[12px] md:text-base">
            <table>
                <tr>
                    <td class="w-32 md:w-52">Alamat Pengiriman</td>
                    <td class="px-1 md:px-3">:</td>
                    <td>{{ $user->users_data->user_alamat }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td class="px-1 md:px-3">:</td>
                    <td>{{ $user->users_data->user_nama_lengkap }}</td>
                </tr>
                <tr>
                    <td>Telp/Wa</td>
                    <td class="px-1 md:px-3">:</td>
                    <td>{{ $user->users_data->user_telp }}</td>
                </tr>
            </table>
        </div>
    </div>
    @php
        $grand_total = 0;
    @endphp
    <div class="w-full md:flex gap-8">
        <div class="md:w-[70%]">
            @foreach ($rs_cart as $item)
                @php
                    $total = $item->produk->produk_harga * $item->data_jlh;
                    $grand_total += $total;
                @endphp
                <div class="my-3">
                    <div class="flex w-full border-2 item">
                        <div class="w-[30%] md:w-[30%] h-auto md:h-44">
                            <img class="w-full h-full" src="{{ asset('image/produk/' . $item->produk->produk_image) }}"
                                alt="">
                        </div>
                        <div class="produk w-[70%] md:w-[70%] h-fit md:h-auto flex flex-col justify-between p-2 md:p-3">
                            <div class="detail-produk">
                                <div class="flex justify-between">
                                    <h1 class="font-semibold text-sm md:text-lg font-poppins">
                                        {{ $item->produk->produk_nama }}</h1>
                                </div>
                                <p class="text-[12px] md:text-base font-poppins">
                                    {{ $item->produk->kategori->kategori_nama }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <h1 class="harga font-semibold text-[12px] md:text-lg font-poppins">
                                    Rp {{ number_format($item->produk->produk_harga, 0, ',', '.') }}</h1>
                                <h1 class="harga font-semibold text-[12px] md:text-lg font-poppins">
                                    x{{ $item->data_jlh }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="border-2 border-t-0 p-2 font-poppins flex justify-between">
                        <p class="text-[12px]">Total pesanan ({{ $item->data_jlh }} Produk)</p>
                        <p class="text-[12px] font-semibold text-royalBule">Rp
                            {{ number_format($total, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8 md:w-[30%] md:mt-3">
            <div class="font-poppins">
                <div class="flex gap-3 items-center">
                    <i class="fa fa-book text-royalBule"></i>
                    <h1 class="text-md font-semibold">Rincian Pesanan</h1>
                </div>
                <table class="w-full text-[14px] my-2">
                    <tr>
                        <td class="text-left">Subtotal untuk Produk</td>
                        <td class="text-right">Rp. {{ number_format($grand_total, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">Subtotal Pengiriman</td>
                        <td class="text-right">-</td>
                    </tr>
                    <tr class="">
                        <td class="text-left text-base font-semibold border-t border-black py-2">Total Pembayaran</td>
                        <td class="text-right text-base border-t border-black">Rp.
                            {{ number_format($grand_total, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            <div class="">
                <a href="{{ route('whatsapp', ['pesanan_id' => $detail->pesanan_id ?? '']) }}" target="blank"
                    class="md:mt-5 mt-2 bg-green-500 hover:bg-green-400 flex gap-1 text-white
                        font-poppins items-center justify-center p-2 md:py-3 rounded-md w-full">
                    <img class="w-5" src="{{ asset('image/wa.png') }}" alt="">
                    <p class="text-sm md:text-md">Lanjutkan ke Whatsapp</p>
                </a>
            </div>
        </div>
    </div>

    @include('beranda.footer')

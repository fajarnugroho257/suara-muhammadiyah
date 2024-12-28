<!-- Modal Background -->
<div id="loginModal"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 ease-out z-50">
    <!-- Modal Content -->
    <div
        class="font-poppins bg-white rounded-lg w-full md:w-1/3 p-8 shadow-lg relative transform scale-95 transition-transform duration-300">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
        <h2 class="text-lg md:text-2xl font-bold mb-4 text-center">Silahkan login terlebih dahulu</h2>
        <form action="{{ route('loginProsesPelanggan') }}" method="post" id="loginForm">
            @csrf
            @method('post')
            <div class="mb-4">
                <label for="nik" class="block text-gray-700">Nik</label>
                <input type="text" id="nik" name="nik" placeholder="Nomor Induk Kewarganegaraan"
                    class="w-full px-3 py-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="Password"
                    class="w-full px-3 py-2 border border-gray-300 rounded" required>
            </div>
            <button type="submit" class="w-full bg-royalBule text-white py-2 rounded hover:bg-blueColor">Login</button>
            <a href="{{ route('registrasi') }}"
                class="w-full block bg-green-400 text-white py-2 rounded hover:bg-green-500 mt-3 text-center">Registrasi</a>
        </form>
    </div>
</div>
{{--  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
<script>
    $(document).ready(function() {
        $('#cart').on('click', function() {
            const slug = $(this).data('slug');
            $.ajax({
                url: "{{ route('cart') }}",
                type: 'POST', // Atur metode HTTP sesuai kebutuhan (POST, GET, dll.)
                data: {
                    _token: '{{ csrf_token() }}', // CSRF Token untuk keamanan
                    slug: slug, // Kirim data yang ingin dikirim ke server
                    quantity: $('#result').html()
                },
                success: function(response) {
                    if (response.success) {
                        if (response.login) {
                            // Tindakan jika permintaan berhasil
                            alert(response.message);
                            console.log(response);
                        } else {
                            // alert(response.message);
                            $('#loginModal').removeClass('opacity-0 pointer-events-none')
                                .addClass('opacity-100 scale-100');
                        }
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Tindakan jika permintaan gagal
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    console.log(error);
                }
            });
        });
        $('.login').on('click', function() {
            $('#loginModal').removeClass('opacity-0 pointer-events-none')
                .addClass('opacity-100 scale-100');
        });
        // Tutup modal saat tombol close diklik
        $('#closeModal').on('click', function() {
            $('#loginModal').removeClass('opacity-100 scale-100').addClass(
                'opacity-0 pointer-events-none');
        });
    });
</script>
<script>
    $("#plus").on("click", function() {
        let number = $('#result').html();
        let resNumber = parseInt(number);
        resNumber = resNumber + 1;
        $('#result').html(resNumber);
    });
    $("#minus").on("click", function() {
        let number = $('#result').html();
        if (number <= 0) {
            return;
        }
        let resNumber = parseInt(number);
        resNumber = resNumber - 1;
        $('#result').html(resNumber);
    });
</script>
<script></script>
<script>
    $(".plus").on("click", function() {
        // alert('aa');
        let numberElement = $(this).parent().children('.nilai');
        // console.log();
        let input = numberElement.find('.result_nilai').val();
        let number = parseInt(input);
        // console.log(number);
        numberElement.find('.result_nilai').val(number + 1);
        // numberElement.find('.result_nilai').val(number + 1);
        // Mengambil elemen .produk induk dari tombol .plus yang diklik
        // var $produk = $(this).closest('.produk'); // Mengambil elemen induk yang sesuai
        // // Mengambil nilai dari elemen .harga
        // var harga = $produk.find('.harga').text().replace('Rp', '').replace(/\./g, '')
        //     .trim(); // Menghapus 'Rp' dan titik
        // harga = parseInt(harga); // Mengubah harga ke angka
        // // total
        // var total = (number + 1) * harga;
        // console.log(total);
    });
    $(".minus").on("click", function() {
        // alert('aa');
        let numberElement = $(this).parent().children('.nilai');
        // console.log();
        let input = numberElement.find('.result_nilai').val();
        let number = parseInt(input);
        // console.log(number);
        numberElement.find('.result_nilai').val(number - 1);
        // Mengambil elemen .produk induk dari tombol .plus yang diklik
        // var $produk = $(this).closest('.produk'); // Mengambil elemen induk yang sesuai
        // // Mengambil nilai dari elemen .harga
        // var harga = $produk.find('.harga').text().replace('Rp', '').replace(/\./g, '')
        //     .trim(); // Menghapus 'Rp' dan titik
        // harga = parseInt(harga); // Mengubah harga ke angka
        // // total
        // var total = (number - 1) * harga;
        // console.log(total);
    });
</script>
<script>
    $(document).ready(function() {
        $('.delete').on('click', function() {
            let $this = $(this);
            const st = confirm('Apakah anda yakin akan menghapus item ini ..?');
            if (st) {
                const data_id = $(this).data('data_id');
                // ajax request
                $.ajax({
                    url: "{{ route('deleteItem') }}",
                    type: 'POST', // Atur metode HTTP sesuai kebutuhan (POST, GET, dll.)
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF Token untuk keamanan
                        data_id: data_id, // Kirim data yang ingin dikirim ke server
                    },
                    success: function(response) {
                        if (response.success) {
                            // Tindakan jika permintaan berhasil
                            alert(response.message);
                            // console.log($this);
                            $this.closest('.item').remove();

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Tindakan jika permintaan gagal
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                        console.log(error);
                    }
                });
            } else {
                return;
            }
        });
    });
</script>
</body>

</html>

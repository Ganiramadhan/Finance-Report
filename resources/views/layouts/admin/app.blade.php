<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('icon.ico') }}" type="image/x-icon">


    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>


    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

    <!-- Tambahkan link ke file CSS Alertify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css" />

    <!-- Jika menggunakan script CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs/build/alertify.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs/build/css/alertify.min.css" />


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>



    <!-- Tambahkan link ke file CSS Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- Tambahkan skrip JavaScript Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="../js/Chart.js"></script>


    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <!-- Navbar -->
            @include('layouts.admin.partials.navbar')

            <!-- Sidebar -->
            @include('layouts.admin.partials.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    {{-- <div class="section-header">
                        <h1>Dashboard</h1>
                    </div> --}}

                    <div class="section-body">
                        @yield('content')
                    </div>
                </section>
            </div>
            @include('layouts.admin.partials.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>




    <script>
        // Saat dokumen telah dimuat
        document.addEventListener('DOMContentLoaded', function() {
            var productSelect = document.getElementById('product_id');
            var hargaInput = document.getElementById('hrg_jual');
            var hargaHiddenInput = document.getElementById('hrg_jual_hidden');

            // Saat nilai elemen select berubah
            productSelect.addEventListener('change', function() {
                // Ambil harga dari atribut data-hrg-jual yang ada di opsi yang dipilih
                var selectedOption = productSelect.options[productSelect.selectedIndex];
                var harga = selectedOption.getAttribute('data-hrg-jual');

                // Setel nilai input harga yang bisa dilihat
                hargaInput.value = harga;

                // Setel nilai input harga yang tersembunyi
                hargaHiddenInput.value = harga;
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            var productSelect = document.getElementById('product_id');
            var hargaInput = document.getElementById('hrg_jual');

            function setHarga() {
                var selectedOption = productSelect.options[productSelect.selectedIndex];
                var harga = selectedOption.getAttribute('data-hrg-jual');
                hargaInput.value = harga;
            }

            setHarga();
            productSelect.addEventListener('change', setHarga);
        });



        // Saat dokumen telah dimuat
        document.addEventListener('DOMContentLoaded', function() {
            var productSelect = document.getElementById('product_id');
            var hargaInput = document.getElementById('hrg_jual');
            var jumlahInput = document.getElementById('jumlah');
            var totalHargaInput = document.getElementById('total');

            // Fungsi untuk mengupdate harga berdasarkan pilihan produk
            function updateHarga() {
                var selectedOption = productSelect.options[productSelect.selectedIndex];
                var harga = parseFloat(selectedOption.getAttribute('data-hrg-jual'));
                hargaInput.value = harga;
                hitungTotalHarga();
            }

            // Fungsi untuk menghitung total harga berdasarkan harga dan jumlah
            function hitungTotalHarga() {
                var harga = parseFloat(hargaInput.value);
                var jumlah = parseInt(jumlahInput.value);
                var totalHarga = harga * jumlah;
                totalHargaInput.value = totalHarga.toFixed(2); // Mengatur jumlah desimal
            }

            // Panggil fungsi updateHarga saat dokumen dimuat
            updateHarga();

            // Tambahkan event listener untuk pilihan produk
            productSelect.addEventListener('change', updateHarga);

            // Tambahkan event listener untuk input jumlah
            jumlahInput.addEventListener('input', hitungTotalHarga);
        });


        // Saat dokumen telah dimuat
        document.addEventListener('DOMContentLoaded', function() {
            var productSelect = document.getElementById('product_id');
            var hargaInput = document.getElementById('hrg_jual');
            var jumlahInput = document.getElementById('jumlah');
            var totalHargaInput = document.getElementById('total');
            var editButton = document.getElementById('editButton'); // Ganti dengan ID tombol "Edit" yang sesuai

            // Fungsi untuk mengupdate total harga
            function updateTotalHarga() {
                var harga = parseFloat(hargaInput.value);
                var jumlah = parseInt(jumlahInput.value);
                var totalHarga = harga * jumlah;
                totalHargaInput.value = totalHarga.toFixed(2); // Mengatur jumlah desimal
            }

            // Panggil fungsi updateTotalHarga saat dokumen dimuat
            updateTotalHarga();

            // Tambahkan event listener ke tombol "Edit"
            editButton.addEventListener('click', function() {
                // Panggil kembali fungsi updateTotalHarga saat tombol "Edit" diklik
                updateTotalHarga();
            });
        });

        // toastr.options = {
        //     "closeButton": false,
        //     "debug": false,
        //     "newestOnTop": false,
        //     "progressBar": false,
        //     "positionClass": "toast-top-right",
        //     "preventDuplicates": false,
        //     "onclick": null,
        //     "showDuration": "300",
        //     "hideDuration": "1000",
        //     "timeOut": "5000",
        //     "extendedTimeOut": "1000",
        //     "showEasing": "swing",
        //     "hideEasing": "linear",
        //     "showMethod": "fadeIn",
        //     "hideMethod": "fadeOut"
        // }

        $(document).ready(function() {
            // Cek apakah ada pesan sukses dalam variabel JavaScript
            var successMessage = "{{ Session::get('success') }}";

            if (successMessage) {

                $(document).ready(function() {
                    // Check if there is a success message in the JavaScript variable
                    var successMessage = "{{ Session::get('success') }}";

                    if (successMessage) {
                        // Display the success message using Alertify
                        alertify.alert('Success', successMessage, function() {}).setHeader('Pesan');
                    }
                });

            }
        });

        $(document).ready(function() {
            // Cek apakah ada pesan kesalahan dalam variabel JavaScript
            var errorMessage = "{{ Session::get('error') }}";

            if (errorMessage) {
                alertify.alert('Success', errorMessage, function() {

                }).setHeader('Pesan');
            }
        });
    </script>


</body>

</html>

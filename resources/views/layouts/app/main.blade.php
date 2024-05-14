<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LSP Polindra :: @yield('title')</title>
    @include('layouts.app.style')
</head>
<body class="sidebar-noneoverflow">
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    @include('layouts.app.header')
    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
        @include('layouts.app.sidebar')
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                @yield('content')
            </div>
            @include('layouts.app.footer')
        </div>
    </div>
    @include('layouts.app.script')
    @stack('datatable')
    <script>
        function handleDelete(element) {
            const dataRoute = element.getAttribute('data-route');
            swal({
                title: 'Apakah Kamu yakin?',
                text: "Data yang terhapus permanen tidak dapat di kembalikan lagi",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                padding: '2em'
                }).then(function(result) {
                    if (result.value) {
                        deleteData(dataRoute);
                    }
                });
        }

        function deleteData(route) {
            $.ajax({
                url: route,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    swal(
                        'Terhapus!',
                        'Data terpilih berhasil dihapus permanen',
                        'success'
                        )
                    getData();
                },
                error: function(xhr, status, error) {
                    swal(
                    'Gagal Terhapus!',
                    'Data terpilih gagal terhapus',
                    'error'
                    )
                }
            });
        }
    </script>
</body>
</html>

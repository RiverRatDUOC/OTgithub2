<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Personal</title>

    <!-- Estilos de Bootstrap y Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/components/comp-navbar.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/components/comp-sidebar.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/components/comp-buttons.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/pages/global.css') }}">

    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
</head>

<body>
    <!-- Navbar -->
    @include('layouts.navbar.header')

    <div class="d-flex">
        <!-- Sidebar -->
        @include('layouts.sidebar.dashboard')

        <!-- Contenido -->
        <div class="content flex-grow-1">
            @yield('content')
        </div>
    </div>

    <!-- Scripts de jQuery y Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <!-- Scripts de DataTables -->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

    <!-- Script de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts personalizados -->
    <script>
        $(document).ready(function() {
            // Inicializar DataTables
            $('#example').DataTable({
                responsive: true
            });

            // JavaScript para ocultar/mostrar el sidebar
            $('#toggleSidebarButton').on('click', function() {
                $('#sidebar').toggleClass('hidden');
                $('.content').toggleClass('expanded');
            });
        });
    </script>
</body>

</html>

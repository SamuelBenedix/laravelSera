<!DOCTYPE html>
<html lang="en">

<head>
    @stack('before-meta')
    @include('includes.meta')
    @stack('after-meta')
    <title>@yield('title') | Preciosa Florist</title>

    @stack('before-style')
    @include('includes.style')
    @stack('after-style')
</head>

<body id="page-top">
    <div id="wrapper">
        @include('includes.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('includes.topbar')
                @yield('content')
                @include('includes.footer')
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button-->

    <!-- Logout Modal-->
    @include('includes.scroll')
    @include('includes.logout')

    @stack('before-script')
    @include('includes.script')
    @stack('after-script')

    <script>
        $(document).ready(function() {
            // var table = $('#dataTable').DataTable();
            $('#myTable').DataTable({
                responsive: true
            });
        });
    </script>
</body>

</html>

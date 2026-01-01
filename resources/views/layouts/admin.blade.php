<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/clients/img/logotachnen.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Trị Hệ Thống - BinhXuTuDong</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/admin/css/admin_style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/user_list.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/receipt_detail.css')}}">
</head>
<script>
    document.querySelectorAll('.toggle-next').forEach(item => {
        item.addEventListener('click', function() {
            const subMenu = this.nextElementSibling;
            if (subMenu.style.display === 'block') {
                subMenu.style.display = 'none';
            } else {
                subMenu.style.display = 'block';
            }
        });
    });
</script>

<body>
    @include('admin.partials.header')
    <main>
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{asset('assets/admin/js/admin_script.js')}}"></script>
    <script src="{{ asset('assets/admin/js/add_category.js') }}"></script>
    <script src="{{ asset('assets/admin/js/cashflow.js') }}"></script>
    <script src="{{ asset('assets/admin/js/add_funds.js') }}"></script>
    <script src="{{ asset('assets/admin/js/add_product.js') }}"></script>
    <script src="{{ asset('assets/admin/js/cashflow.js') }}"></script>
    <script src="{{ asset('assets/admin/js/category_list.js') }}"></script>
    <script src="{{ asset('assets/admin/js/order_detail.js') }}"></script>
    <script src="{{ asset('assets/admin/js/orders.js') }}"></script>
    <script src="{{ asset('assets/admin/js/product_list.js') }}"></script>
    <script src="{{ asset('assets/admin/js/receipt_detail.js') }}"></script>
    <script src="{{ asset('assets/admin/js/user_list.js') }}"></script>

    <script src="{{ asset('assets/admin/js/sidebar.js') }}"></script>
    @stack('scripts')

</body>

</html>
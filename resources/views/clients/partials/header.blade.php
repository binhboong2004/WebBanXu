    <div class="sidebar">
        <div class="logo-area">
            <img src="{{ asset('assets/clients/img/logo.png') }}" alt="Logo" class="img-fluid">
        </div>
        <nav class="nav flex-column">
            <a href="{{ route('home') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}"><i class="fas fa-home me-2"></i> Trang Chủ</a>
            <a href="{{ route('mua_tai_khoan') }}" class="nav-link {{ request()->is('mua_tai_khoan') ? 'active' : '' }}"><i class="fas fa-shopping-cart me-2"></i> Mua Tài Khoản</a>
            <a href="{{ route('lich_su_mua') }}" class="nav-link {{ request()->is('lich_su_mua') ? 'active' : '' }}"><i class="fas fa-history me-2"></i> Lịch Sử Mua Hàng</a>

            <div class="menu-title">Nạp Tiền</div>
            <a href="{{ route('nap_ngan_hang') }}" class="nav-link {{ request()->is('nap_ngan_hang') ? 'active' : '' }}"><i class="fas fa-university me-2"></i> Ngân Hàng</a>
            <a href="{{ route('nap_momo') }}" class="nav-link {{ request()->is('nap_momo') ? 'active' : '' }}"><i class="fas fa-credit-card me-2"></i> Nạp Momo</a>

            <div class="menu-title">Khác</div>
            <a href="{{ route('lien_he') }}" class="nav-link {{ request()->is('lien_he') ? 'active' : '' }}"><i class="fas fa-book me-2"></i> Liên Hệ</a>

            <div class="menu-title">Tiện Ích</div>
            <a href="{{ route('cong_cu') }}" class="nav-link {{ request()->is('cong_cu') ? 'active' : '' }}"><i class="fa-solid fa-screwdriver-wrench me-2"></i> Công Cụ Miễn Phí</a>
            <a href="{{ route('huong_dan') }}" class="nav-link {{ request()->is('huong_dan') ? 'active' : '' }}"><i class="fa-solid fa-book me-2"></i> Hướng Dẫn</a>
        </nav>
    </div>
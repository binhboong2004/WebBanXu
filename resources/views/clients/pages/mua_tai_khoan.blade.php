@extends('layouts.client')

@section('title', 'Mua Tài Khoản')

@section('content')
<div class="main-content">
    <div class="top-navbar border-bottom d-flex align-items-center px-3">
        <div class="d-flex align-items-center">
            @if(Auth::check())
            <button class="btn btn-sm btn-light border me-3">
                <i class="fas fa-wallet text-primary"></i> Ví: {{ number_format($user->balance) }}đ
            </button>
            @endif
        </div>

        <div class="ms-auto">
            @if(Auth::check())
            <div class="user-info d-flex align-items-center dropdown">
                <div class="d-flex align-items-center cursor-pointer" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('storage/'. $user->avatar) }}" class="rounded-circle me-2" style="width: 30px; height:30px; object-fit: cover;">
                    <strong class="me-1">{{ $user->username }}</strong>
                    <i class="fas fa-caret-down small"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                    <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="fas fa-user-circle me-2"></i> Trang cá nhân</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('password.change') }}"><i class="fas fa-key me-2"></i> Đổi mật khẩu</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a></li>
                </ul>
            </div>
            @endif
        </div>
    </div>

    <div class="content-wrapper mt-4">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <div class="d-flex justify-content-center gap-2 overflow-auto pb-2" id="filter-buttons">
                    <button class="btn btn-dark btn-sm px-4 fw-bold" onclick="filterProduct('all', this)">TẤT CẢ</button>
                    @foreach($categories as $cat)
                    <button class="btn btn-outline-dark btn-sm px-4 fw-bold text-uppercase" onclick="filterProduct('cat-{{ $cat->id }}', this)">
                        {{ $cat->name }}
                    </button>
                    @endforeach
                </div>
                <div class="d-flex align-items-center ms-2">
                    <select class="form-select form-select-sm fw-bold border-dark" id="sort-select" onchange="sortProducts()" style="width: 200px;">
                        <option value="default">-- SẮP XẾP --</option>
                        <option value="price-asc">Giá: Thấp đến Cao</option>
                        <option value="price-desc">Giá: Cao đến Thấp</option>
                        <option value="xu-asc">Xu: Thấp đến Cao</option>
                        <option value="xu-desc">Xu: Cao đến Thấp</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-uppercase text-primary">
                    <i class="fas fa-shopping-basket me-2"></i> Danh Sách Tài Khoản Đang Bán
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 35%;" class="ps-4">Loại Tài Khoản</th>
                            <th class="text-center">Kho hàng</th>
                            <th class="text-center" style="width: 15%;">Số lượng mua</th>
                            <th class="text-center">Giá bán</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        @foreach($accountGroups as $index => $group)
                        <tr class="product-item" data-category="cat-{{ $group->category_id }}">
                            <td class="ps-4">
                                <div class="fw-bold text-dark">
                                    {{ $group->category->name }} - <span class="text-primary">{{ number_format($group->xu_amount) }} Xu</span>
                                </div>
                                <small class="text-muted"><i class="fas fa-check-circle me-1 text-success"></i>Định dạng: TK | MK</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                    Còn: {{ number_format($group->total) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control form-control-sm mx-auto text-center"
                                    id="qty_{{ $index }}" value="1" min="1" max="{{ $group->total }}"
                                    style="width: 70px;">
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-danger fs-5">{{ number_format($group->price) }}đ</span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm px-3 fw-bold shadow-sm"
                                    onclick="openBuyModal('{{ $group->category->name }}', '{{ $group->price }}', 'qty_{{ $index }}', '{{ $group->category_id }}', '{{ $group->xu_amount }}')">
                                    <i class="fas fa-shopping-cart me-1"></i> MUA NGAY
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmBuyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning py-3">
                <h5 class="modal-title fw-bold text-uppercase"><i class="fas fa-check-circle me-2"></i>Xác nhận đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="text-muted mb-1 small text-uppercase">Bạn đang thực hiện mua sản phẩm:</p>
                <h5 id="modalProdName" class="fw-bold text-primary mb-4">...</h5>
                <div class="bg-light p-3 rounded-3 border mb-3 text-start">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tổng thanh toán:</span>
                        <strong id="modalProdPrice" class="text-danger fs-5">0đ</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Hình thức:</span>
                        <strong class="text-dark italic">Ví tài khoản</strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-3">
                <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">HỦY</button>
                <button type="button" class="btn btn-warning fw-bold px-4 shadow-sm" onclick="submitPurchase()">XÁC NHẬN MUA</button>
            </div>
        </div>
    </div>
</div>
@endsection
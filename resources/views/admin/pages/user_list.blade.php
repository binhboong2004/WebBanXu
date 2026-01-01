@extends('layouts.admin')

@section('title', 'Danh sách người dùng')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Tìm kiếm người dùng...">
        </div>
        <div class="header-right">
            <div class="user-pill">
                <img src="{{ asset('storage/'. $user->avatar) }}" alt="Admin">
                <span class="fw-bold small d-none d-md-inline">{{ $user->username }}</span>
            </div>
        </div>
    </header>

    <div class="content-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0">Danh sách người dùng</h4>
            <span class="badge bg-primary">Tổng cộng: {{ $users->total() }} thành viên</span>
        </div>

        <div class="row g-4" id="userContainer">
            @foreach($users as $item)
            <div class="col-xl-3 col-lg-4 col-md-6 user-card-item">
                <div class="user-card">
                    <div class="user-avatar-wrap">
                        <img src="{{ $item->avatar ? asset('storage/' . $item->avatar) : asset('assets/admin/img/default-user.png') }}" class="user-avatar" alt="Avatar">
                    </div>
                    <div class="user-name text-truncate" title="{{ $item->username }}">{{ $item->username }}</div>
                    <span class="user-email text-truncate">{{ $item->email }}</span>

                    <span class="role-badge {{ $item->role === 'admin' ? 'role-admin' : 'role-user' }}">
                        {{ strtoupper($item->role) }}
                    </span>

                    <div class="user-footer">
                        <div class="verify-status">
                            {{-- Giả định status = 1 là đã xác thực email --}}
                            <span class="status-dot {{ $item->status == 1 ? 'dot-green' : 'dot-red' }}"></span>
                            <span class="text-muted small">
                                {{ $item->status == 1 ? 'Đã xác thực mail' : 'Chưa xác thực mail' }}
                            </span>
                        </div>

                        <div class="dropup">
                            <div class="more-btn" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </div>
                            <div class="dropdown-menu dropdown-menu-end animated fadeIn">
                                @if($item->role !== 'admin')
                                <form action="{{ route('admin.set_admin', $item->id) }}" method="POST" onsubmit="return confirm('Xác nhận cấp quyền Quản trị viên cho người dùng này?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="dropdown-item small text-secondary">
                                        <i class="fas fa-user-shield me-2 text-info"></i> Phân quyền Admin
                                    </button>
                                </form>
                                @else
                                <button class="dropdown-item small text-muted" disabled>
                                    <i class="fas fa-check-circle me-2 text-success"></i> Đã là Admin
                                </button>
                                @endif
                                <a class="dropdown-item small text-secondary" href="{{ route('admin.finance.add_funds') }}?user_id={{ $item->id }}">
                                    <i class="fas fa-plus-circle me-2 text-success"></i> Cộng tiền
                                </a>
                                <div class="dropdown-divider"></div>
                                {{-- Tìm đoạn form xóa trong file blade của bạn --}}
                                <form action="{{ route('admin.user_delete', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                    @csrf
                                    @method('DELETE') {{-- Giả lập phương thức DELETE --}}
                                    <button type="submit" class="dropdown-item small text-danger">
                                        <i class="fas fa-trash-alt me-2"></i> Xóa tài khoản
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Hiển thị thanh phân trang --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $users->links() }}
        </div>
    </div>
</main>
@endsection
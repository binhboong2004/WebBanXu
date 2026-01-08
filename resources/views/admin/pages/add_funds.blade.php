@extends('layouts.admin')

@section('title', 'Cộng tiền thành viên')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Tìm kiếm nhanh...">
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
            <h4 class="fw-bold mb-0">Cộng tiền thành viên</h4>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card p-4 border-0 shadow-sm rounded-4">
                    {{-- QUAN TRỌNG: Thêm ID cho Form và đảm bảo chỉ có 1 thẻ form duy nhất --}}
                    <form id="addFundsForm" action="{{ route('admin.finance.process_add_funds') }}" method="POST">
                        @csrf 

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">User ID khách hàng</label>
                            <input type="number" name="user_id" id="user_id"
                                value="{{ $target_user_id ?? old('user_id') }}"
                                class="form-control form-control-lg bg-light border-0 shadow-none fs-6 @error('user_id') is-invalid @enderror"
                                placeholder="Nhập ID người dùng (VD: 2)" required>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Số tiền nạp (VNĐ)</label>
                            <div class="input-group">
                                <input type="number" name="amount" id="amount" value="{{ old('amount') }}"
                                    class="form-control form-control-lg bg-light border-0 shadow-none fs-6 @error('amount') is-invalid @enderror"
                                    placeholder="50000" required>
                                <span class="input-group-text bg-light border-0 fw-bold">₫</span>
                            </div>
                            @error('amount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted text-uppercase">Ngân hàng / Phương thức</label>
                            <select name="method" id="method" class="form-select form-select-lg bg-light border-0 shadow-none fs-6">
                                <option value="MbBank" {{ old('method') == 'MbBank' ? 'selected' : '' }}>MbBank</option>
                                <option value="Vietcombank" {{ old('method') == 'Vietcombank' ? 'selected' : '' }}>Vietcombank</option>
                                <option value="Vietinbank" {{ old('method') == 'Vietinbank' ? 'selected' : '' }}>Vietinbank</option>
                                <option value="Momo" {{ old('method') == 'Momo' ? 'selected' : '' }}>Ví Momo</option>
                                <option value="Admin" {{ old('method') == 'Admin' || !old('method') ? 'selected' : '' }}>Cộng tay (Admin)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Ghi chú giao dịch</label>
                            <textarea name="note" id="note" class="form-control bg-light border-0 shadow-none fs-6"
                                rows="3" placeholder="Lý do cộng tiền...">{{ old('note') }}</textarea>
                        </div>

                        {{-- Nút xác nhận có ID để JavaScript điều khiển --}}
                        <button type="submit" id="submitBtnFunds" class="btn btn-primary w-100 py-3 fw-bold rounded-pill">
                            Xác nhận nạp tiền <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
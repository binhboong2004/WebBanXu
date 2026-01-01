@extends('layouts.client')

@section('title', 'Lịch sử nạp tiền')

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
        </div>

    <div class="content-wrapper mt-4">
        <h5 class="fw-bold mb-3 text-uppercase"><i class="fas fa-history me-2 text-success"></i>Lịch sử nạp tiền</h5>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">STT</th>
                            <th>Mã GD</th>
                            <th>Số tiền</th>
                            <th class="text-center">Phương thức</th>
                            <th class="text-center">Nội dung</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recharges as $index => $recharge)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td><span class="text-muted">#{{ $recharge->id }}</span></td>
                            <td>
                                <span class="fw-bold text-success">+{{ number_format($recharge->amount) }}đ</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info-subtle text-info border">{{ $recharge->method }}</span>
                            </td>
                            <td class="text-center small">
                                {{ $recharge->transaction_note ?? 'Nạp tiền qua hệ thống' }}
                            </td>
                            <td class="text-center">
                                @if($recharge->status == 1)
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Thành công</span>
                                @elseif($recharge->status == 0)
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Chờ xử lý</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Thất bại</span>
                                @endif
                            </td>
                            <td class="text-center text-muted small">
                                {{ $recharge->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" style="width: 50px; opacity: 0.5" class="mb-2"><br>
                                Bạn chưa có giao dịch nạp tiền nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
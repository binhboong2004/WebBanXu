@extends('layouts.admin')

@section('title', 'Biến động số dư')

@section('content')
<main class="main-content">
    <header class="top-header">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="cashflowSearch" placeholder="Tìm tên khách hoặc nội dung...">
        </div>
        <div class="header-right">
            <div class="user-pill">
                <img src="{{ $admin->avatar ? asset('storage/'.$admin->avatar) : asset('assets/admin/img/avt.jpg') }}" alt="Admin">
                <span class="fw-bold small">{{ $admin->username }}</span>
            </div>
        </div>
    </header>

    <div class="content-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Biến động số dư</h4>
            <div class="d-flex gap-3">
                <div class="badge bg-success-soft text-success rounded-pill px-3 py-2 border border-success">
                    <i class="fas fa-arrow-down me-1"></i> Tổng nạp: {{ number_format($totalIn) }}đ
                </div>
                <div class="badge bg-danger-soft text-danger rounded-pill px-3 py-2 border border-danger">
                    <i class="fas fa-arrow-up me-1"></i> Tổng chi: {{ number_format($totalOut) }}đ
                </div>
            </div>
        </div>

        <div class="row g-3" id="cashflowContainer">
            @forelse($cashflows as $item)
            <div class="col-12 cashflow-item">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="rounded-circle d-flex align-items-center justify-content-center {{ $item->type == 'in' ? 'bg-success text-white' : 'bg-danger text-white' }}" style="width: 45px; height: 45px;">
                                <i class="fas {{ $item->type == 'in' ? 'fa-plus' : 'fa-minus' }}"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold mb-0">{{ $item->username }}</h6>
                            <small class="text-muted">{{ $item->note }}</small>
                        </div>
                        <div class="col-auto text-end">
                            <div class="fw-bold {{ $item->type == 'in' ? 'text-success' : 'text-danger' }}">
                                {{ $item->type == 'in' ? '+' : '-' }} {{ number_format($item->amount) }}đ
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <img src="{{ asset('assets/admin/img/empty-wallet.png') }}" style="width: 100px; opacity: 0.5;">
                <p class="text-muted mt-3">Chưa có giao dịch nào được thực hiện.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $cashflows->links() }}
        </div>
    </div>
</main>
<script>
document.getElementById('cashflowSearch')?.addEventListener('input', function(e) {
    const keyword = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.cashflow-item');
    
    items.forEach(item => {
        const text = item.innerText.toLowerCase();
        item.style.display = text.includes(keyword) ? "block" : "none";
    });
});
</script>
@endsection
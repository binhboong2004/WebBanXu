@extends('layouts.admin')

@section('title', 'Biên lai giao dịch')

@section('content')
<main class="main-content">
    <div class="content-body">
        <div class="text-center mb-4 btn-print">
            <button class="btn btn-light shadow-sm px-4" onclick="window.print()">
                <i class="fas fa-print me-2"></i> In biên lai
            </button>
        </div>

        <div class="receipt-container" id="receiptContent">
            <div class="text-center p-5">Đang tải dữ liệu...</div>
        </div>
    </div>
</main>
@endsection
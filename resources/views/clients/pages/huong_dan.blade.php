@extends('layouts.client')

@section('title', 'Hướng dẫn sử dụng')

@section('content')
<div class="main-content">
    <div class="top-navbar border-bottom d-flex align-items-center px-3">
        <div class="d-flex align-items-center">
            <h6 class="mb-0 fw-bold text-uppercase"><i class="fas fa-book me-2 text-primary"></i>Hướng dẫn kiếm xu</h6>
        </div>
        <div class="ms-auto">
             <button class="btn btn-sm btn-outline-danger fw-bold shadow-sm" style="border-radius: 30px;">
                <i class="fas fa-question-circle me-1"></i> TRỢ GIÚP
             </button>
        </div>
    </div>

    <div class="content-wrapper mt-4">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <h6 class="fw-bold text-primary text-uppercase">1. Cách chạy TraoDoiSub</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="bg-light p-3 rounded-3 border-start border-primary border-4 mb-3">
                            <p class="small mb-1"><strong>Bước 1:</strong> Đăng nhập TDS, vào mục <strong>Cấu hình</strong>.</p>
                            <p class="small mb-1"><strong>Bước 2:</strong> Nhập ID Facebook từ tài khoản bạn đã mua trên Shop.</p>
                            <p class="small mb-0"><strong>Bước 3:</strong> Tiến hành kiếm xu tại mục "Kiếm xu" (Like/Sub/Follow).</p>
                        </div>
                        <p class="text-muted small italic mb-0">* Lưu ý: Nên mua tài khoản có sẵn 2FA để tránh bị checkpoint.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                        <h6 class="fw-bold text-success text-uppercase">2. Cách chạy TuongTacCheo</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="bg-light p-3 rounded-3 border-start border-success border-4 mb-3">
                            <p class="small mb-1"><strong>Bước 1:</strong> Thêm tài khoản Facebook/TikTok vào cấu hình TTC.</p>
                            <p class="small mb-1"><strong>Bước 2:</strong> Bật trình duyệt hoặc Tool để bắt đầu làm nhiệm vụ.</p>
                            <p class="small mb-0"><strong>Bước 3:</strong> Dùng xu tích lũy để tăng tương tác bài viết cá nhân.</p>
                        </div>
                        <p class="text-muted small italic mb-0">* Mẹo: Sử dụng 4G để đổi IP liên tục giúp nick sống lâu hơn.</p>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-danger text-center mb-4 text-uppercase">
                            <i class="fab fa-youtube me-2"></i>Video hướng dẫn chi tiết
                        </h6>
                        <div class="ratio ratio-16x9 shadow-sm" style="max-width: 900px; margin: 0 auto; border-radius: 15px; overflow: hidden; border: 5px solid #f8f9fa;">
                            <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="Guide Video" allowfullscreen></iframe>
                        </div>
                        <div class="text-center mt-4">
                            <p class="text-muted small">Nếu gặp khó khăn trong quá trình sử dụng, vui lòng liên hệ Admin qua Zalo ở trang chủ.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
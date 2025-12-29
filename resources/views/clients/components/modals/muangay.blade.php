            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning py-3">
                    <h5 class="modal-title fw-bold text-uppercase"><i class="fas fa-check-circle me-2"></i>Xác nhận đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <p class="text-muted mb-1 small">Bạn đang mua sản phẩm:</p>
                    <h5 id="modalProdName" class="fw-bold text-primary mb-4">Tên sản phẩm</h5>
                    <div class="bg-light p-3 rounded-3 border mb-3 text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Đơn giá:</span>
                            <strong id="modalProdPrice" class="text-danger">0đ</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Thanh toán:</span>
                            <strong class="text-dark">Số dư tài khoản</strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-3">
                    <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">HỦY BỎ</button>
                    <button type="button" class="btn btn-warning fw-bold px-4 shadow-sm" onclick="submitPurchase()">XÁC NHẬN MUA</button>
                </div>
            </div>
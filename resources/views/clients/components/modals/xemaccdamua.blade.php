            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalLabel"><i class="fas fa-key me-2"></i>THÔNG TIN TÀI KHOẢN</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">ĐỊNH DẠNG: USERNAME | PASSWORD</label>
                        <div class="input-group">
                            <input type="text" id="accContent" class="form-control fw-bold text-danger bg-light" value="" readonly>
                            <button class="btn btn-dark" type="button" onclick="copyToClipboard()">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                    <div class="alert alert-warning py-2 mb-0 small">
                        <i class="fas fa-exclamation-triangle me-1"></i> 
                        <strong>Lưu ý:</strong> Hãy đổi mật khẩu ngay sau khi nhận tài khoản để tránh mất mát dữ liệu!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">ĐÓNG</button>
                </div>
            </div>
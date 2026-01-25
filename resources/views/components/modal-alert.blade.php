@php
    $showSuccess = session('success') && !str_contains(session('success'), 'logged in') && !str_contains(session('success'), 'logged out');
@endphp

@if($errors->any())
    <div class="modal fade" id="errorsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header py-3" style="background-color: #fef2f2; border-bottom: 1px solid #fee2e2;">
                    <h5 class="modal-title d-flex align-items-center fw-700" style="color: #991b1b; font-size: 16px;">
                        <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 18px;"></i> Validation Error
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px;"></button>
                </div>
                <div class="modal-body p-4">
                    <ul class="mb-0 ps-3 fw-500" style="color: #b91c1c; font-size: 13.5px; line-height: 1.6;">
                        @foreach($errors->all() as $error)
                            <li class="mb-1">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer border-0 pt-0 pb-3 pe-3">
                    <button type="button" class="btn px-4 py-2 fw-700" data-bs-dismiss="modal" style="background-color: #dc2626; color: #fff; border-radius: 8px; font-size: 13px;">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new bootstrap.Modal(document.getElementById('errorsModal')).show();
        });
    </script>
@endif

@if(session('error'))
    <div class="modal fade" id="errorGeneralModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width: 400px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header py-3" style="background-color: #fef2f2; border-bottom: 1px solid #fee2e2;">
                    <h5 class="modal-title d-flex align-items-center fw-700" style="color: #991b1b; font-size: 16px;">
                        <i class="bi bi-exclamation-circle-fill me-2" style="font-size: 18px;"></i> Error
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px;"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-0 fw-500" style="color: #b91c1c; font-size: 14px;">{{ session('error') }}</p>
                </div>
                <div class="modal-footer border-0 pt-0 pb-3 pe-3">
                    <button type="button" class="btn px-4 py-2 fw-700" data-bs-dismiss="modal" style="background-color: #dc2626; color: #fff; border-radius: 8px; font-size: 13px;">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new bootstrap.Modal(document.getElementById('errorGeneralModal')).show();
        });
    </script>
@endif

@if($showSuccess)
    <div class="modal fade" id="successGeneralModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width: 400px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header py-3" style="background-color: #f0fdf4; border-bottom: 1px solid #dcfce7;">
                    <h5 class="modal-title d-flex align-items-center fw-700" style="color: #166534; font-size: 16px;">
                        <i class="bi bi-check-circle-fill me-2" style="font-size: 18px;"></i> Success
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px;"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-0 fw-500" style="color: #15803d; font-size: 14px;">{{ session('success') }}</p>
                </div>
                <div class="modal-footer border-0 pt-0 pb-3 pe-3">
                    <button type="button" class="btn px-4 py-2 fw-700" data-bs-dismiss="modal" style="background-color: #16a34a; color: #fff; border-radius: 8px; font-size: 13px;">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new bootstrap.Modal(document.getElementById('successGeneralModal')).show();
        });
    </script>
@endif

@if(session('info'))
    <div class="modal fade" id="infoGeneralModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width: 400px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header py-3" style="background-color: #eff6ff; border-bottom: 1px solid #dbeafe;">
                    <h5 class="modal-title d-flex align-items-center fw-700" style="color: #1e40af; font-size: 16px;">
                        <i class="bi bi-info-circle-fill me-2" style="font-size: 18px;"></i> Information
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 10px;"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-0 fw-500" style="color: #1d4ed8; font-size: 14px;">{{ session('info') }}</p>
                </div>
                <div class="modal-footer border-0 pt-0 pb-3 pe-3">
                    <button type="button" class="btn px-4 py-2 fw-700" data-bs-dismiss="modal" style="background-color: #2563eb; color: #fff; border-radius: 8px; font-size: 13px;">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new bootstrap.Modal(document.getElementById('infoGeneralModal')).show();
        });
    </script>
@endif

<style>
.fw-700 { font-weight: 700; }
.fw-500 { font-weight: 500; }
</style>

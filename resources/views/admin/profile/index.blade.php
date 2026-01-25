@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="mb-4">
    <h1 class="page-title-new mb-1">
        <i class="bi bi-person-circle text-primary"></i> My Profile
    </h1>
    <p class="text-muted small">Manage your account settings and profile information</p>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card recent-sales-card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <h6 class="fw-700 color-navy mb-4">Account Details</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label-new">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" placeholder="Your full name" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-new">Email Address</label>
                            <input type="email" class="form-control bg-light opacity-75" value="{{ $user->email }}" disabled>
                            <p class="text-muted mt-1" style="font-size: 11px;">Email cannot be changed contact admin.</p>
                        </div>
                    </div>

                    <h6 class="fw-700 color-navy mb-4">Security</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label-new">New Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password">
                            <p class="text-muted mt-1" style="font-size: 11px;">Leave blank to keep current password.</p>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label-new">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password">
                        </div>
                    </div>

                    <h6 class="fw-700 color-navy mb-4">Profile Picture</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center gap-4">
                                <div class="profile-preview">
                                    @if($user->profile_picture)
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" id="img-preview">
                                    @else
                                        <div class="profile-placeholder" id="placeholder-preview">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <label for="profile_picture" class="form-label-new">Upload Photo</label>
                                    <input type="file" name="profile_picture" id="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" onchange="previewImage(this)">
                                    <p class="text-muted mt-1" style="font-size: 11px;">JPG, PNG. Max size 2MB.</p>
                                    @error('profile_picture') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-save-new px-4 py-2">
                            <i class="bi bi-check-circle-fill me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card recent-sales-card border-0 shadow-sm mb-4">
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    <div class="profile-preview large mx-auto">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile">
                        @else
                            <div class="profile-placeholder">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <h5 class="fw-800 color-navy mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-3">{{ ucfirst($user->role) }}</p>
                <div class="badge bg-light-blue text-primary px-3 py-2 fw-600" style="border-radius: 10px; font-size: 11px;">
                    Member since {{ $user->created_at->format('M Y') }}
                </div>
                
                <div class="mt-4 text-start pt-4 border-top">
                    <h6 class="fw-700 color-navy mb-3" style="font-size: 13px;">Security Tips</h6>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="text-success" style="font-size: 16px;"><i class="bi bi-shield-check"></i></div>
                        <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.4;">Use a strong password with at least 8 characters.</p>
                    </div>
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="text-warning" style="font-size: 16px;"><i class="bi bi-clock-history"></i></div>
                        <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.4;">We recommend changing your password regularly.</p>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-primary" style="font-size: 16px;"><i class="bi bi-key-fill"></i></div>
                        <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.4;">Enable two-factor authentication for extra security.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card recent-sales-card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="fw-700 color-navy mb-4" style="font-size: 13px;">Recent Activity</h6>
                
                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-4 mb-3">
                    <div class="activity-icon bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">
                        <i class="bi bi-person-check-fill" style="font-size: 14px;"></i>
                    </div>
                    <div>
                        <p class="fw-700 color-navy mb-0" style="font-size: 12px;">Last login</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">2 hours ago</p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-4">
                    <div class="activity-icon bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">
                        <i class="bi bi-person-fill-up" style="font-size: 14px;"></i>
                    </div>
                    <div>
                        <p class="fw-700 color-navy mb-0" style="font-size: 12px;">Profile updated</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">1 week ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-label-new { font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 8px; display: block; }
.form-control { border-radius: 10px; border-color: #e2e8f0; padding: 10px 14px; font-size: 14px; }
.form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08); }

.btn-save-new { background-color: #3b82f6; color: #fff; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; transition: all 0.2s; font-size: 14px; }
.btn-save-new:hover { background-color: #2563eb; color: #fff; transform: translateY(-1px); }

.profile-preview {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    overflow: hidden;
    background: #f1f5f9;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
.profile-preview img { width: 100%; height: 100%; object-fit: cover; }
.profile-preview.large { width: 90px; height: 90px; border-radius: 18px; }

.profile-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #94a3b8;
}
.profile-preview.large .profile-placeholder { font-size: 42px; }

.bg-light-blue { background-color: #f0f7ff; }
.color-navy { color: #1e293b; }
.fw-600 { font-weight: 600; }
.fw-700 { font-weight: 700; }
.fw-800 { font-weight: 800; }
.rounded-4 { border-radius: 14px !important; }
</style>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('img-preview');
            var placeholder = document.getElementById('placeholder-preview');
            if (preview) {
                preview.src = e.target.result;
            } else if (placeholder) {
                const parent = placeholder.parentElement;
                const img = document.createElement('img');
                img.id = 'img-preview';
                img.src = e.target.result;
                parent.innerHTML = '';
                parent.appendChild(img);
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection

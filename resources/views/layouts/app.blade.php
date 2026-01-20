<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory & Sales Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
/* RESET */
* {
    box-sizing: border-box;
    font-family: "Segoe UI", Tahoma, sans-serif;
    margin: 0;
    padding: 0;
}

body {
    margin: 0;
    padding: 0;
}

body.auth-page {
    overflow: hidden;
}

/* MAIN CONTAINER */
.auth-container {
    display: flex;
    width: 100vw;
    height: 100vh;
}

/* LEFT SIDE */
.auth-left {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    padding: 40px 20px;
}

.auth-form {
    width: 100%;
    max-width: 450px;
}

.auth-header h2 {
    text-align: center;
    margin-top: 50px;
    color: #1a1a1a;
    font-size: 15px;
}

.login-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 40px;
    color: #1a1a1a;
    text-align: center;
}

/* INPUTS */
.field {
    margin-bottom: 24px;
    position: relative;
}

.form-input {
    width: 100%;
    padding: 15px 20px;
    border-radius: 50px;
    border: none;
    font-size: 14px;
    background: #f0f0f0;
    color: #333;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-input::placeholder {
    color: #999;
}

.form-input:focus {
    outline: none;
    background: #e8e8e8;
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
}

/* FORM FOOTER */
.form-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    font-size: 13px;
}

.link-text {
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
}

.link-text:hover {
    color: #333;
}

/* BUTTON */
.btn-login {
    width: 100%;
    padding: 15px;
    background: #5b4b8a;
    color: #fff;
    border: none;
    border-radius: 50px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    letter-spacing: 1px;
}

.btn-login:hover {
    background: #4a3a70;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(91, 75, 138, 0.3);
}

/* RIGHT SIDE */
.auth-right {
    width: 100%;
    background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
    background-size: 400% 400%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    animation: gradient 15s ease infinite;
}

@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

/* Floating shapes */
.auth-right::before,
.auth-right::after {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    opacity: 0.1;
}

.auth-right::before {
    background: #ffffff;
    top: -150px;
    right: -150px;
    animation: float 8s ease-in-out infinite;
}

.auth-right::after {
    background: #ffffff;
    bottom: -150px;
    left: -150px;
    animation: float 10s ease-in-out infinite reverse;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px) translateX(0px);
    }
    50% {
        transform: translateY(-30px) translateX(20px);
    }
}

/* LOGO AREA */
.logo-area {
    text-align: center;
    position: relative;
    z-index: 10;
    animation: fadeInScale 1s ease-out;
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* LAPTOP LOGO */
.laptop {
    width: 260px;
    animation: laptopFloat 4s ease-in-out infinite;
}

@keyframes laptopFloat {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

.screen {
    height: 140px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    box-shadow: 0 10px 40px rgba(13, 110, 253, 0.4);
    position: relative;
    overflow: hidden;
}

.screen::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% {
        transform: translate(-100%, -100%);
    }
    100% {
        transform: translate(100%, 100%);
    }
}

.base {
    width: 80%;
    height: 10px;
    background: #0b5ed7;
    margin: 6px auto 0;
    border-radius: 6px;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .auth-right {
        display: none;
    }

    .auth-left {
        width: 100%;
    }
}


/* ---------------- ROLE BADGE ---------------- */
/* .role-badge {
    margin-top: 15px;
    padding: 6px;
    border-radius: 20px;
    font-size: 12px;
}

.role-badge.admin {
    background: #ff9800;
    color: #000;
}

.role-badge.staff {
    background: #4caf50;
    color: #000;
}

footer {
    margin-top: 20px;
    font-size: 12px;
    opacity: 0.7;
} */


        :root {
            --sidebar-width: 250px;
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
        }

        .main-container {
            display: flex;
            min-height: 100vh;
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-color);
            color: white;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            overflow-y: auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 18px;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-item {
            margin: 0;
        }

        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: var(--secondary-color);
        }

        .nav-link.active {
            background: var(--secondary-color);
            color: white;
            border-left-color: #f39c12;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        /* SIDEBAR LOGO STYLING */
        .sidebar-logo {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px 0;
        }

        .laptop-mini {
            width: 80px;
            animation: laptopFloatMini 4s ease-in-out infinite;
        }

        @keyframes laptopFloatMini {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        .screen-mini {
            height: 50px;
            border-radius: 8px;
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 11px;
            box-shadow: 0 5px 20px rgba(13, 110, 253, 0.3);
            position: relative;
            overflow: hidden;
            padding: 5px;
            text-align: center;
            line-height: 1.2;
        }

        .screen-mini::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            animation: shimmerMini 3s infinite;
        }

        @keyframes shimmerMini {
            0% {
                transform: translate(-100%, -100%);
            }
            100% {
                transform: translate(100%, 100%);
            }
        }

        .base-mini {
            width: 80%;
            height: 5px;
            background: #0b5ed7;
            margin: 3px auto 0;
            border-radius: 3px;
        }

        .sidebar-tagline {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 8px;
            line-height: 1.3;
        }

        .nav-section-title {
            padding: 15px 20px 8px;
            font-size: 11px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
            font-weight: 600;
            margin-top: 10px;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-brand {
            font-weight: 600;
            color: var(--primary-color);
        }

        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .metric-card {
            padding: 20px;
            border-left: 4px solid var(--secondary-color);
        }

        .metric-card .metric-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .metric-card .metric-label {
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .metric-card.danger {
            border-left-color: #e74c3c;
        }

        .metric-card.danger .metric-value {
            color: #e74c3c;
        }

        .metric-card.success {
            border-left-color: #27ae60;
        }

        .metric-card.success .metric-value {
            color: #27ae60;
        }

        .metric-card.warning {
            border-left-color: #f39c12;
        }

        .metric-card.warning .metric-value {
            color: #f39c12;
        }

        .btn-primary {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-primary:hover {
            background: #2980b9;
            border-color: #2980b9;
        }

        .badge {
            font-size: 11px;
            padding: 5px 10px;
        }

        .table {
            font-size: 13px;
        }

        .table thead {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .table thead th {
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
        }

        .alert {
            border-radius: 6px;
            border: none;
        }

        .page-title {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        @media (max-width: 768px) {
            :root {
                --sidebar-width: 0;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1000;
                width: 250px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content {
                padding: 15px;
            }
        }
    </style>
    @yield('extra-css')
</head>
<body @if(Route::current()->getName() === 'login') class="auth-page" @endif>
    @if(auth()->check())
        <div class="main-container">
            <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <div class="laptop-mini">
                        <div class="screen-mini">
                            Control C-Technology
                        </div>
                        <div class="base-mini"></div>
                    </div>
                </div>
                <small class="sidebar-tagline">INVENTORY & SALES MANAGEMENT SYSTEM</small>
            </div>
            <nav class="sidebar-nav">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    <div class="nav-section-title">Inventory</div>
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i>
                        <span>Categories</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Products</span>
                    </a>

                    <div class="nav-section-title">Management</div>
                    <a href="{{ route('admin.staff.index') }}" class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Staff</span>
                    </a>

                    <div class="nav-section-title">Sales</div>
                    <a href="{{ route('admin.sales.create') }}" class="nav-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle"></i>
                        <span>Record Sales</span>
                    </a>

                    <div class="nav-section-title">Reports</div>
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="bi bi-graph-up"></i>
                        <span>Sales Reports</span>
                    </a>
                    <a href="{{ route('admin.reports.daily') }}" class="nav-link {{ request()->routeIs('admin.reports.daily') ? 'active' : '' }}">
                        <i class="bi bi-calendar-day"></i>
                        <span>Daily</span>
                    </a>
                    <a href="{{ route('admin.reports.weekly') }}" class="nav-link {{ request()->routeIs('admin.reports.weekly') ? 'active' : '' }}">
                        <i class="bi bi-calendar-week"></i>
                        <span>Weekly</span>
                    </a>
                    <a href="{{ route('admin.reports.monthly') }}" class="nav-link {{ request()->routeIs('admin.reports.monthly') ? 'active' : '' }}">
                        <i class="bi bi-calendar-month"></i>
                        <span>Monthly</span>
                    </a>
                @else
                    <a href="{{ route('staff.dashboard') }}" class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>

                    <div class="nav-section-title">Sales</div>
                    <a href="{{ route('staff.sales.create') }}" class="nav-link {{ request()->routeIs('staff.sales.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-square"></i>
                        <span>New Sale</span>
                    </a>
                    <a href="{{ route('staff.sales.history') }}" class="nav-link {{ request()->routeIs('staff.sales.history') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i>
                        <span>Sales History</span>
                    </a>
                @endif
            </nav>
        </div>

        <div class="main-content">
            <div class="topbar">
                <div class="topbar-brand">
                    Inventory & Sales Management System
                </div>
                <div>
                    <span class="me-3">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->name }}
                        <span class="badge bg-secondary ms-2">{{ ucfirst(auth()->user()->role) }}</span>
                    </span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <div class="content">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Errors:</strong>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            </div>
        </div>
    @else
        <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 100vh; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
            @yield('content')
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('extra-js')

    <script>
/* ---------------- DARK / LIGHT MODE ---------------- */
// const body = document.body;
// const toggle = document.getElementById('modeToggle');

// const savedMode = localStorage.getItem('mode') || 'dark';
// body.classList.add(savedMode);
// toggle.textContent = savedMode === 'dark' ? '🌙' : '☀️';

// toggle.onclick = () => {
//     const mode = body.classList.contains('dark') ? 'light' : 'dark';
//     body.className = mode;
//     localStorage.setItem('mode', mode);
//     toggle.textContent = mode === 'dark' ? '🌙' : '☀️';
// };

/* ---------------- PASSWORD VISIBILITY ---------------- */
// function togglePassword() {
//     const input = document.getElementById('password');
//     input.type = input.type === 'password' ? 'text' : 'password';
// }

/* Password Toggle */
function togglePassword() {
    const p = document.getElementById('password');
    p.type = p.type === 'password' ? 'text' : 'password';
}

/* Typing Animation */
const text = "Control C-Technology";
let i = 0;
const target = document.getElementById("typed-text");

function typeEffect() {
    if (i < text.length) {
        target.textContent += text.charAt(i);
        i++;
        setTimeout(typeEffect, 80);
    }
}
typeEffect();


/* ---------------- TYPING LOGO ANIMATION ---------------- */
// const text = "Control C-Technology";
// let index = 0;
// const target = document.getElementById('typed-text');

// function typeText() {
//     if (index < text.length) {
//         target.textContent += text.charAt(index);
//         index++;
//         setTimeout(typeText, 80);
//     }
// }
// typeText();
</script>

</body>
</html>

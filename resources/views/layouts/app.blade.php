<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Inventory & Sales Management System')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --primary: #3b82f6;
    --dark-bg: #0e172a;
    --sidebar-bg: #f1f5f9;
    --text-navy: #1e293b;
    --sidebar-width: 250px;
}

* { box-sizing: border-box; margin: 0; padding: 0; }
body { 
    background-color: var(--dark-bg); 
    font-family: 'Inter', sans-serif;
    color: var(--text-navy);
    height: 100vh;
    overflow: hidden;
}

/* MAIN STRUCTURE */
.app-container {
    display: flex;
    padding: 15px;
    gap: 15px;
    height: 100vh;
}

/* SIDEBAR */
.sidebar {
    width: var(--sidebar-width);
    background-color: #f8fafc;
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

.sidebar-logo-box {
    margin: 15px;
    padding: 25px 15px;
    border-radius: 12px;
    text-align: center;
}

.sidebar-logo-box img {
    max-width: 140px;
    height: auto;
}

.sidebar-nav {
    list-style: none;
    padding: 10px 15px;
    flex: 1;
}

.nav-section-title {
    color: #151c25ff;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 25px 5px 10px;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 15px;
    color: #000000ff;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    border-radius: 10px;
    margin-bottom: 2px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.nav-link i { font-size: 16px; }

.nav-link:hover {
    background-color: rgba(0,0,0,0.03);
    color: var(--text-navy);
}

.nav-link.active {
    background-color: #3b82f6;
    color: #fff;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
}

/* MAIN CONTENT AREA */
.main-wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* TOPBAR */
.topbar {
    background: #fff;
    padding: 12px 25px;
    border-radius: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.topbar-title {
    font-size: 14px;
    font-weight: 700;
    color: #334155;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-name {
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-logout-new {
    background-color: transparent;
    border: 1px solid #fee2e2;
    color: #ef4444;
    font-size: 11px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}

.btn-logout-new:hover {
    background-color: #fef2f2;
    border-color: #fecaca;
}

.logout-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    color: #ef4444;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    border-radius: 10px;
    border: none;
    background: #fef2f2;
    transition: all 0.2s;
}

.logout-link:hover {
    background-color: #fee2e2;
    color: #dc2626;
}

/* CONTENT CARD */
.content-area {
    background: #ffffffff;
    border-radius: 20px;
    flex: 1;
    padding: 30px;
    overflow-y: auto;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.01);
}

/* Scrollbar styling */
.content-area::-webkit-scrollbar { width: 6px; }
.content-area::-webkit-scrollbar-track { background: transparent; }
.content-area::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
.content-area::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

</style>
</head>
<body>

<div class="app-container">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-logo-box">
            <img src="{{ asset('images/logo.png') }}" alt="Inventory Management">
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Dashboard</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> Overview
            </a>
            <a href="{{ route('admin.profile.edit') }}" class="nav-link {{ request()->routeIs('admin.profile.edit') ? 'active' : '' }}">
                <i class="bi bi-person-fill-gear"></i> My Profile
            </a>

            <div class="nav-section-title" style="margin-top: 20px;">Inventory</div>
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i> Categories
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-archive-fill"></i> Products
            </a>

            <div class="nav-section-title" style="margin-top: 20px;">Sales</div>
            <a href="{{ route('admin.sales.create') }}" class="nav-link {{ request()->routeIs('admin.sales.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle-fill"></i> New Sale
            </a>
            <a href="{{ route('admin.sales.history') }}" class="nav-link {{ request()->routeIs('admin.sales.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> History
            </a>

            <div class="nav-section-title" style="margin-top: 20px;">Reports</div>
            <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i> Sales Reports
            </a>
            <!-- <a href="{{ route('admin.reports.daily') }}" class="nav-link {{ request()->routeIs('admin.reports.daily') ? 'active' : '' }}">
                <i class="bi bi-calendar-event-fill"></i> Daily Report
            </a> -->
        </nav>

        <div class="sidebar-footer p-3 mt-auto">
            @auth
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="logout-link w-100">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            @endauth
        </div>
    </aside>

    {{-- MAIN CONTENT AREA --}}
    <main class="main-wrapper">
        <header class="topbar">
            <div class="topbar-title">Inventory & Sales Management</div>
            <div class="user-info">
                @auth
                    <div class="user-name">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Avatar" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle text-primary" style="font-size: 16px;"></i>
                        @endif
                        {{ auth()->user()->name }}
                    </div>
                @endauth
            </div>
        </header>

        <section class="content-area">
            @yield('content')
        </section>
    </main>

</div>

<!-- Modal Alerts -->
@include('components.modal-alert')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

@php
    $userRole = Auth::user()->getRoleNames()->first() ?? 'User';
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ $userRole }}</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('superadmin') ? 'active' : '' }}">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard {{ $userRole }}</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        fitur
    </div>

    <!-- Nav Item - Roles & Permissions Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAccess" aria-expanded="true" aria-controls="collapseAccess">
            <i class="fas fa-fw fa-user-shield"></i>
            <span>fitur</span>
        </a>
        <div id="collapseAccess" class="collapse" aria-labelledby="headingAccess" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Access Control:</h6>
                <a class="collapse-item" href="">fitur</a>
                <a class="collapse-item" href="">fitur</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Users
    </div>

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-users"></i>
            <span>fitur</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-arrow-right-to-bracket"></i>
            <span>fitur</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Optional Addons -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Productivity -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Productivity</span>
        </a>
    </li>

    <!-- Log Activity -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Log Activity</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

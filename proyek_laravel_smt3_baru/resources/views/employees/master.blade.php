<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'App Pegawai')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: #ffffff;
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.08);
            transition: width 0.3s ease, transform 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            will-change: transform;
            border-right: 1px solid rgba(102, 126, 234, 0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .nav-link {
            padding: 12px;
            justify-content: center;
        }

        .sidebar.collapsed .nav-link:hover,
        .sidebar.collapsed .nav-link.active {
            padding: 12px;
        }

        .sidebar-header {
            padding: 24px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.2);
        }

        .sidebar-logo {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-align: center;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar.collapsed .sidebar-logo {
            font-size: 0;
        }

        .toggle-btn {
            position: fixed;
            left: 20px;
            bottom: 30px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            z-index: 1001;
        }

        .sidebar.collapsed~.toggle-btn {
            left: 20px;
        }

        .toggle-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }

        .toggle-btn:active {
            transform: scale(0.95);
        }

        .sidebar-nav {
            padding: 30px 0 100px 0;
        }

        .nav-section {
            margin-bottom: 35px;
        }

        .nav-section-title {
            padding: 0 24px 12px 24px;
            margin: 0 0 8px 0;
            color: #9ca3af;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .nav-section-title {
            opacity: 0;
            height: 0;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }

        .nav-item {
            margin: 0 0 4px 0;
            padding: 0 16px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 16px;
            color: #6b7280;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.25s ease;
            font-weight: 500;
            font-size: 0.94rem;
            position: relative;
            cursor: pointer;
            background: transparent;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 0;
            background: linear-gradient(180deg, #667eea, #764ba2);
            border-radius: 0 4px 4px 0;
            transition: height 0.25s ease;
        }

        .nav-link:hover {
            background: rgba(102, 126, 234, 0.08);
            color: #667eea;
            padding-left: 20px;
        }

        .nav-link:hover::before {
            height: 60%;
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(118, 75, 162, 0.1));
            color: #667eea;
            font-weight: 600;
            padding-left: 20px;
        }

        .nav-link.active::before {
            height: 70%;
        }

        .nav-link i {
            font-size: 1.1rem;
            width: 24px;
            min-width: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            flex-shrink: 0;
        }

        .nav-link:hover i {
            transform: translateX(2px);
        }

        .nav-link.active i {
            color: #667eea;
        }

        .nav-link span {
            white-space: nowrap;
            transition: opacity 0.2s ease;
        }

        .sidebar.collapsed .nav-link span {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 15px 12px;
        }

        .sidebar.collapsed .nav-link:hover {
            transform: translateX(0) scale(1.05);
        }

        /* Badge */
        .nav-badge {
            margin-left: auto;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 700;
            transition: all 0.25s ease;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
            z-index: 1;
            line-height: 1;
        }

        .sidebar.collapsed .nav-badge {
            opacity: 0;
            width: 0;
            padding: 0;
            transform: scale(0);
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 50%;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            cursor: pointer;
            z-index: 999;
            font-size: 1.5rem;
            transition: transform 0.2s ease;
        }

        .mobile-toggle:hover {
            transform: scale(1.1);
        }

        .mobile-toggle:active {
            transform: scale(0.95);
        }

        /* Tooltip for collapsed state - Simple version */
        .sidebar.collapsed .nav-link:hover {
            position: relative;
        }

        .sidebar.collapsed .nav-link[data-tooltip]:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 10px;
            background: #1f2937;
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            white-space: nowrap;
            z-index: 1001;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 0 0 0 rgba(0, 0, 0, 0);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
                box-shadow: 4px 0 30px rgba(0, 0, 0, 0.2);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .mobile-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .sidebar.collapsed {
                width: 280px;
            }

            .nav-section-title {
                opacity: 1 !important;
                padding: 12px 28px !important;
                height: auto !important;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 260px;
            }

            .mobile-toggle {
                width: 55px;
                height: 55px;
                bottom: 20px;
                right: 20px;
            }
        }

        /* Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <span>System App Pegawai</span>
            </div>
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Main Menu</div>
                <div class="nav-item">
                    <a href="{{ route('employees.index') }}"
                        class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" data-tooltip="Pegawai">
                        <i class="fas fa-users"></i>
                        <span>Pegawai</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('departments.index') }}"
                        class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}"
                        data-tooltip="Department">
                        <i class="fas fa-building"></i>
                        <span>Department</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('positions.index') }}"
                        class="nav-link {{ request()->routeIs('positions.*') ? 'active' : '' }}"
                        data-tooltip="Positions">
                        <i class="fas fa-briefcase"></i>
                        <span>Positions</span>
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Operations</div>
                <div class="nav-item">
                    <a href="{{ route('attendance.index') }}"
                        class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}"
                        data-tooltip="Attendance">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Attendance</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('leave.index') }}"
                        class="nav-link {{ request()->routeIs('leave.*') ? 'active' : '' }}" data-tooltip="Leave">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Leave</span>
                        @php
                            try {
                                $pendingCount = \App\Models\Leave::where('status', 'pending')->count();
                                if ($pendingCount > 0) {
                                    echo '<span class="nav-badge">' . $pendingCount . '</span>';
                                }
                            } catch (\Exception $e) {
                                // Silently fail if table doesn't exist
                            }
                        @endphp
                    </a>
                </div>
                <div class="nav-item">
                    <a href="{{ route('payroll.index') }}"
                        class="nav-link {{ request()->routeIs('payroll.*') ? 'active' : '' }}" data-tooltip="Payroll">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Payroll</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle" onclick="toggleMobileSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @yield('content')
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');

            // Save state
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }

        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        }

        // Restore sidebar state
        window.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                document.getElementById('sidebar').classList.add('collapsed');
                document.getElementById('mainContent').classList.add('expanded');
            }
        });

        // Close mobile sidebar on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 968) {
                closeMobileSidebar();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

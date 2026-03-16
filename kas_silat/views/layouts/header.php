<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title><?= isset($title) ? $title . ' - ' . APP_NAME : APP_NAME ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #17a2b8;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --header-height: 70px;
            --border-radius: 16px;
            --box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            --box-shadow-hover: 0 15px 40px rgba(0,0,0,0.1);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            --gradient-danger: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            --gradient-warning: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            --gradient-info: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            min-height: 100vh;
            overflow-x: hidden;
            color: #2d3748;
        }
        
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }
        
        /* Premium Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            background: var(--gradient-primary);
            color: #fff;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 5px 0 30px rgba(102, 126, 234, 0.3);
            backdrop-filter: blur(10px);
        }
        
        #sidebar::-webkit-scrollbar {
            width: 5px;
        }
        
        #sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        
        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }
        
        #sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
        
        #sidebar .sidebar-header {
            padding: 25px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            overflow: hidden;
        }
        
        #sidebar .sidebar-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        
        #sidebar .sidebar-header h3 {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            position: relative;
            text-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        #sidebar .sidebar-header p {
            margin: 8px 0 0;
            font-size: 0.85rem;
            opacity: 0.9;
            position: relative;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        #sidebar .sidebar-header p i {
            font-size: 0.8rem;
            opacity: 0.7;
        }
        
        #sidebar ul.components {
            padding: 20px 0;
            list-style: none;
        }
        
        #sidebar ul li {
            position: relative;
        }
        
        #sidebar ul li a {
            padding: 14px 25px;
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }
        
        #sidebar ul li a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }
        
        #sidebar ul li a:hover::before {
            left: 100%;
        }
        
        #sidebar ul li a:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border-left-color: #fff;
            transform: translateX(5px);
        }
        
        #sidebar ul li.active a {
            background: rgba(255,255,255,0.2);
            color: #fff;
            border-left-color: #fff;
            box-shadow: inset 0 2px 10px rgba(0,0,0,0.1);
        }
        
        #sidebar ul li a i {
            width: 30px;
            font-size: 1.2rem;
            margin-right: 12px;
            text-align: center;
            filter: drop-shadow(0 2px 3px rgba(0,0,0,0.2));
        }
        
        /* Sidebar Collapsed */
        #sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        #sidebar.collapsed .sidebar-header h3,
        #sidebar.collapsed .sidebar-header p,
        #sidebar.collapsed ul li a span {
            display: none;
        }
        
        #sidebar.collapsed ul li a {
            padding: 14px 0;
            justify-content: center;
        }
        
        #sidebar.collapsed ul li a i {
            margin-right: 0;
            font-size: 1.3rem;
        }
        
        #sidebar.collapsed ul li a .badge {
            position: absolute;
            top: 5px;
            right: 5px;
            padding: 3px 6px;
            font-size: 0.6rem;
        }
        
        /* Main Content */
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        #content.expanded {
            width: calc(100% - var(--sidebar-collapsed-width));
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Premium Navbar */
        .navbar {
            padding: 0 30px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.03);
            height: var(--header-height);
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .navbar .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.3rem;
            letter-spacing: -0.5px;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -moz-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            -moz-text-fill-color: transparent;
            color: transparent;
        }
        
        .navbar .nav-link {
            color: #4a5568;
            font-weight: 500;
            padding: 0.7rem 1rem !important;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .navbar .nav-link:hover {
            background: rgba(102, 126, 234, 0.1);
            color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .navbar .nav-link i {
            font-size: 1.2rem;
        }
        
        .navbar .dropdown-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border-radius: 16px;
            padding: 10px;
            min-width: 220px;
            border: 1px solid rgba(0,0,0,0.05);
            margin-top: 10px;
        }
        
        .navbar .dropdown-item {
            padding: 10px 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #4a5568;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar .dropdown-item i {
            width: 20px;
            font-size: 1rem;
            color: var(--secondary-color);
        }
        
        .navbar .dropdown-item:hover {
            background: rgba(102, 126, 234, 0.1);
            color: var(--secondary-color);
            transform: translateX(5px);
        }
        
        .navbar .dropdown-divider {
            margin: 8px 0;
            opacity: 0.1;
        }
        
        /* Avatar Dropdown */
        .avatar-dropdown {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .avatar-dropdown:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            border-color: rgba(255,255,255,0.5);
        }
        
        /* Toggle Sidebar Button */
        #sidebarCollapse {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: white;
            border: 1px solid rgba(0,0,0,0.05);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
        
        #sidebarCollapse:hover {
            background: var(--gradient-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        /* Main Content Area */
        .main-content {
            padding: 30px;
            flex: 1;
        }
        
        /* Premium Cards */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 25px;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-hover);
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 20px 25px;
            font-weight: 600;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            color: #2d3748;
            font-size: 1.1rem;
            letter-spacing: -0.3px;
        }
        
        .card-header i {
            color: var(--secondary-color);
            margin-right: 8px;
        }
        
        .card-body {
            padding: 25px;
        }
        
        /* Premium Stats Cards */
        .stats-card {
            background: var(--gradient-primary);
            color: #fff;
            padding: 25px;
            border-radius: var(--border-radius);
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.2);
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        
        .stats-card .stats-icon {
            font-size: 3.5rem;
            opacity: 0.2;
            position: absolute;
            right: 20px;
            top: 20px;
            transform: rotate(-10deg);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover .stats-icon {
            transform: rotate(0deg) scale(1.1);
            opacity: 0.3;
        }
        
        .stats-card .stats-label {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .stats-card .stats-value {
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 5px;
        }
        
        .stats-card .stats-change {
            font-size: 0.85rem;
            opacity: 0.8;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .stats-card .stats-change i {
            font-size: 0.8rem;
        }
        
        /* Premium Tables */
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #4a5568;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 15px 12px;
            background: rgba(102, 126, 234, 0.02);
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
        }
        
        .table td {
            padding: 15px 12px;
            vertical-align: middle;
            color: #2d3748;
            font-size: 0.9rem;
            border-bottom: 1px solid rgba(0,0,0,0.03);
        }
        
        .table-hover tbody tr:hover {
            background: rgba(102, 126, 234, 0.02);
            transition: all 0.3s ease;
        }
        
        /* Premium Buttons */
        .btn {
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-success {
            background: var(--gradient-success);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }
        
        .btn-danger {
            background: var(--gradient-danger);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }
        
        .btn-warning {
            background: var(--gradient-warning);
            color: white;
            box-shadow: 0 5px 15px rgba(243, 156, 18, 0.3);
        }
        
        .btn-info {
            background: var(--gradient-info);
            color: white;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--secondary-color);
            color: var(--secondary-color);
        }
        
        .btn-outline-primary:hover {
            background: var(--gradient-primary);
            border-color: transparent;
            color: white;
        }
        
        .btn-sm {
            padding: 6px 15px;
            font-size: 0.85rem;
        }
        
        .btn-lg {
            padding: 12px 30px;
            font-size: 1rem;
        }
        
        .btn-action {
            padding: 6px 12px;
            margin: 0 3px;
            border-radius: 10px;
            font-size: 0.85rem;
        }
        
        /* Premium Footer */
        .footer {
            padding: 20px 30px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(0,0,0,0.05);
            margin-top: auto;
            color: #718096;
            font-size: 0.9rem;
        }
        
        .footer a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .footer a:hover {
            color: var(--primary-color);
        }
        
        /* Responsive Breakpoints */
        @media (max-width: 1200px) {
            :root {
                --sidebar-width: 240px;
            }
        }
        
        @media (max-width: 992px) {
            :root {
                --sidebar-width: 220px;
            }
            
            .main-content {
                padding: 25px;
            }
            
            .card-header {
                padding: 18px 22px;
            }
            
            .card-body {
                padding: 22px;
            }
        }
        
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(var(--sidebar-width) * -1);
                box-shadow: none;
            }
            
            #sidebar.active {
                margin-left: 0;
                box-shadow: 5px 0 30px rgba(0,0,0,0.2);
            }
            
            #content {
                width: 100%;
                margin-left: 0;
            }
            
            #content.active {
                width: 100%;
                margin-left: 0;
            }
            
            #sidebar.collapsed {
                width: var(--sidebar-width);
            }
            
            #sidebar.collapsed.active {
                margin-left: 0;
            }
            
            #sidebar.collapsed .sidebar-header h3,
            #sidebar.collapsed .sidebar-header p,
            #sidebar.collapsed ul li a span {
                display: block;
            }
            
            #sidebar.collapsed ul li a {
                padding: 14px 25px;
                justify-content: flex-start;
            }
            
            #sidebar.collapsed ul li a i {
                margin-right: 12px;
            }
            
            .navbar {
                padding: 0 20px;
            }
            
            .navbar .navbar-brand {
                font-size: 1.1rem;
            }
            
            .main-content {
                padding: 20px;
            }
            
            .card-header {
                padding: 15px 20px;
                font-size: 1rem;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .stats-card {
                padding: 20px;
            }
            
            .stats-card .stats-value {
                font-size: 1.8rem;
            }
            
            .table th, .table td {
                padding: 12px 10px;
                font-size: 0.85rem;
            }
            
            .btn {
                padding: 7px 16px;
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 576px) {
            .navbar {
                padding: 0 15px;
            }
            
            .navbar .navbar-brand {
                font-size: 1rem;
            }
            
            .navbar .nav-link {
                padding: 0.5rem !important;
            }
            
            .navbar .nav-link span {
                display: none;
            }
            
            .avatar-dropdown {
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }
            
            .main-content {
                padding: 15px;
            }
            
            .card-header {
                padding: 12px 15px;
                font-size: 0.95rem;
            }
            
            .card-body {
                padding: 15px;
            }
            
            .stats-card {
                padding: 15px;
            }
            
            .stats-card .stats-icon {
                font-size: 2.5rem;
                right: 15px;
                top: 15px;
            }
            
            .stats-card .stats-label {
                font-size: 0.8rem;
            }
            
            .stats-card .stats-value {
                font-size: 1.5rem;
            }
            
            .table th, .table td {
                padding: 10px 8px;
                font-size: 0.8rem;
            }
            
            .table th {
                font-size: 0.7rem;
            }
            
            .btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
            
            .btn-action {
                padding: 4px 8px;
                font-size: 0.75rem;
            }
            
            .footer {
                padding: 15px 20px;
                font-size: 0.8rem;
                text-align: center;
            }
            
            .dropdown-menu {
                min-width: 200px;
            }
            
            .dropdown-item {
                padding: 8px 12px;
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 375px) {
            .main-content {
                padding: 12px;
            }
            
            .card-header {
                padding: 10px 12px;
                font-size: 0.9rem;
            }
            
            .card-body {
                padding: 12px;
            }
            
            .stats-card .stats-value {
                font-size: 1.3rem;
            }
            
            .table th, .table td {
                padding: 8px 5px;
                font-size: 0.75rem;
            }
            
            .btn {
                padding: 5px 10px;
                font-size: 0.75rem;
            }
        }
        
        /* Landscape Mode */
        @media (max-height: 500px) and (orientation: landscape) {
            #sidebar {
                overflow-y: auto;
            }
            
            .navbar {
                height: 60px;
            }
            
            .main-content {
                padding: 15px;
            }
            
            .stats-card {
                padding: 15px;
            }
            
            .stats-card .stats-value {
                font-size: 1.5rem;
            }
        }
        
        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            body {
                background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
                color: #e2e8f0;
            }
            
            .navbar {
                background: rgba(26, 32, 44, 0.9);
                border-bottom: 1px solid rgba(255,255,255,0.05);
            }
            
            .navbar .navbar-brand {
                color: white;
            }
            
            .navbar .nav-link {
                color: #a0aec0;
            }
            
            .navbar .nav-link:hover {
                color: white;
            }
            
            .card {
                background: rgba(45, 55, 72, 0.9);
                border: 1px solid rgba(255,255,255,0.05);
            }
            
            .card-header {
                color: #e2e8f0;
                border-bottom: 1px solid rgba(255,255,255,0.05);
            }
            
            .table th {
                color: #a0aec0;
                background: rgba(255,255,255,0.02);
                border-bottom: 2px solid rgba(255,255,255,0.1);
            }
            
            .table td {
                color: #e2e8f0;
                border-bottom: 1px solid rgba(255,255,255,0.03);
            }
            
            .table-hover tbody tr:hover {
                background: rgba(255,255,255,0.02);
            }
            
            .dropdown-menu {
                background: #2d3748;
                border: 1px solid rgba(255,255,255,0.1);
            }
            
            .dropdown-item {
                color: #e2e8f0;
            }
            
            .dropdown-item:hover {
                background: rgba(102, 126, 234, 0.2);
                color: white;
            }
            
            .footer {
                background: rgba(26, 32, 44, 0.9);
                color: #a0aec0;
                border-top: 1px solid rgba(255,255,255,0.05);
            }
            
            .btn-outline-secondary {
                border-color: #4a5568;
                color: #a0aec0;
            }
            
            .btn-outline-secondary:hover {
                background: #4a5568;
                color: white;
            }
        }
        
        /* Print Styles */
        @media print {
            #sidebar, .navbar, .btn, .footer {
                display: none !important;
            }
            
            #content {
                margin-left: 0 !important;
                width: 100% !important;
            }
            
            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
        
        /* Loading Animation */
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(102, 126, 234, 0.1);
            border-top-color: var(--secondary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
        }
    </style>
</head>
<body>
    <div class="wrapper">
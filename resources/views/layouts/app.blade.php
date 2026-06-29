<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIMASPIRASI IMIGRASI</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    
    <style>
        :root {
            --color-primary: #003366;
            --color-secondary: #0066cc;
            --sidebar-width: 240px; /* Menentukan lebar pasti sidebar */
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar-custom {
            background-color: var(--color-primary);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        /* Pembungkus layout utama di bawah navbar */
        .main-layout {
            display: flex;
            flex: 1;
            width: 100%;
        }
        
        .sidebar-custom {
            background-color: var(--color-primary);
            width: var(--sidebar-width);
            flex-shrink: 0; /* Mengunci agar sidebar tidak menyusut */
            padding-top: 20px;
            position: sticky;
            top: 56px; /* Menempel tepat di bawah navbar */
            height: calc(100vh - 56px);
            overflow-y: auto;
        }
        
        .sidebar-custom .nav-link {
            color: #fff;
            padding: 12px 15px;
            border-left: 4px solid transparent;
        }
        
        .sidebar-custom .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            border-left-color: #0099ff;
        }
        
        .sidebar-custom .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            border-left-color: #0099ff;
        }
        
        .main-content-area {
            background-color: #f5f5f5;
            padding: 20px;
            flex: 1;
            min-width: 0;
            overflow-x: auto;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        
        .card-header-custom {
            background-color: var(--color-primary);
            color: white;
            font-weight: 600;
        }
        
        .btn-primary-custom {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
        }
        
        .btn-primary-custom:hover {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }
        
        .stat-card {
            padding: 20px;
            border-radius: 8px;
            color: white;
            margin-bottom: 15px;
        }
        
        .stat-card.today {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .stat-card.week {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .stat-card.month {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .stat-card.year {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .stat-card h5 {
            margin: 0 0 5px 0;
            font-size: 14px;
            opacity: 0.9;
        }
        
        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
        }
    </style>
    
    @stack('css')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand text-white font-weight-bold" href="#">
                <i class="fas fa-file-alt"></i> SIMASPIRASI IMIGRASI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->nama }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>  
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-layout">
        
        <!-- Sidebar (Kiri) -->
        <nav class="sidebar-custom">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('aspirasi.*') ? 'active' : '' }}" href="{{ route('aspirasi.index') }}">
                        <i class="fas fa-list"></i> Data Aspirasi
                    </a>
                </li>
                
                @if(Auth::user()->isAdmin())
                    <hr class="my-3 border-light">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                            <i class="fas fa-users"></i> Kelola Petugas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.activity-logs') ? 'active' : '' }}" href="{{ route('admin.activity-logs') }}">
                            <i class="fas fa-history"></i> Activity Log
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

        <!-- Main Content (Kanan) -->
        <main class="main-content-area">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Validasi Error!</strong>
                    <ul class="mb-0 ms-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Konten halaman index tabel disuntikkan di sini -->
            @yield('content')
        </main>

    </div> <!-- Penutup .main-layout -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/admin心理.min.js"></script>
    
    @stack('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cari semua alert (sukses, error, maupun validasi) yang muncul di main content
            const alerts = document.querySelectorAll('.main-content-area .alert');
            
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    // Trigger bawaan Bootstrap 5 untuk menutup alert dengan efek animasi close
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    if (bsAlert) {
                        bsAlert.close();
                    }
                }, 3000); // 3000 milidetik = 3 detik
            });
        });
    </script>
</body>
</html>

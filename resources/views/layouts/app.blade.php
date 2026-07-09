<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - YANKOMAS</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo_imigrasi_Bandung.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
            background: linear-gradient(135deg, #0e3b75ff 40%, #1c2d42 40%, #0c33c2ff 100%);
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
        
        .stat-card.today,
        .stat-card.week,
        .stat-card.month, 
        .stat-card.year {
            background: linear-gradient(135deg, #1c2d42 40%, #1c2d42 40%, #1041f2ff 100%);
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
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
                <img src="{{ asset('assets/img/logo_imigrasi_RI.png') }}" 
                     style="width: 32px; height: 32px; object-fit: contain; flex-shrink: 0;"
                     class="me-2">
                <img src="{{ asset('assets/img/logo_imigrasi_Bandung.png') }}" 
                     style="width: 32px; height: 32px; object-fit: contain; flex-shrink: 0;"
                     class="me-2">
                <span class="navbar-brand text-white font-weight-bold mb-0">
                    YANKOMAS
                </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            @if(Auth::user()->foto)
                                <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="rounded-circle me-2" style="width: 28px; height: 28px; object-fit: cover; border: 1px solid rgba(255,255,255,0.5);">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(substr(Auth::user()->nama, 0, 1)) }}&background=0066cc&color=fff&size=28&bold=true" class="rounded-circle me-2" style="width: 28px; height: 28px; object-fit: cover;">
                            @endif
                            {{ Auth::user()->nama }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Profil</a></li>
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
                    <hr class="my-3 border-light opacity-25">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                            <i class="fas fa-users"></i> Kelola Petugas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.activity-logs') ? 'active' : '' }}" href="{{ route('admin.activity-logs') }}">
                            <i class="fas fa-history"></i> Log Aktivitas
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

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

            @yield('content')
        </main>

    </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
    
    @stack('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.main-content-area .alert');
            
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    if (bsAlert) {
                        bsAlert.close();
                    }
                }, 3000);
            });
        });
    </script>
</body>
</html>
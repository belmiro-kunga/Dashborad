<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1a174d;
            --accent: #00bfff;
            --sidebar-bg: #181532;
            --sidebar-active: #23205a;
            --card-bg: #fff;
            --card-shadow: 0 4px 24px rgba(0,0,0,0.07);
            --border-radius: 18px;
            --text: #222;
            --muted: #6c757d;
        }
        body {
            background: linear-gradient(135deg, #e1e8ed 0%, #f4f6fa 100%);
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            color: var(--text);
            min-height: 100vh;
        }
        .sidebar {
            background: var(--sidebar-bg);
            color: #fff;
            min-height: 100vh;
            padding-top: 32px;
            box-shadow: 2px 0 16px rgba(24,21,50,0.05);
        }
        .sidebar .nav-link {
            color: #fff;
            margin-bottom: 8px;
            border-radius: 8px;
            font-size: 1.05rem;
            padding: 10px 18px;
            transition: background 0.15s, color 0.15s;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: var(--sidebar-active);
            color: var(--accent);
        }
        .profile-img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .main-content {
            padding: 36px 32px;
            min-height: 90vh;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            margin-top: 32px;
            box-shadow: var(--card-shadow);
        }
        .card-stat {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            background: linear-gradient(120deg, #e6f6fd 0%, #fff 100%);
            color: var(--primary);
            margin-bottom: 28px;
            transition: box-shadow 0.18s;
        }
        .card-stat:hover {
            box-shadow: 0 4px 24px rgba(0,191,255,0.13);
        }
        .card-stat .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-stat .icon {
            font-size: 2.6rem;
            color: var(--accent);
        }
        .muted {
            color: var(--muted);
        }
        .header-fixed {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }
        @media (max-width: 991px) {
            .main-content {
                padding: 18px 4px;
                margin-top: 10px;
            }
            .sidebar {
                padding-top: 10px;
            }
        }
        @media (max-width: 767px) {
            .main-content {
                padding: 10px 0px;
                margin-top: 5px;
            }
            .sidebar {
                min-height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar py-4">
                <div class="text-center mb-4">
                    <h4>Acme</h4>
                </div>
                <ul class="nav flex-column mb-4">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-people"></i> Usuários</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-shield-lock"></i> Permissões</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-clock-history"></i> Logs</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('configuracoes') }}"><i class="bi bi-gear"></i> Configurações</a></li>
                </ul>
            </nav>
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="header-fixed d-flex justify-content-between align-items-center px-4 py-3 mb-4">
                    <span class="fs-4 fw-bold text-primary"><i class="bi bi-speedometer2"></i> Dashboard</span>
                    <div class="d-flex align-items-center gap-3">
                        <span class="fw-semibold text-dark">@auth {{ Auth::user()->name }} @endauth</span>
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" class="profile-img border">
                    </div>
                </div>
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

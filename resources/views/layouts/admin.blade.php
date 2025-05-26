<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            display: flex;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            overflow-x: hidden;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(145deg, #2c3e50, #34495e);
            color: #fff;
            padding-top: 30px;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
            font-weight: bold;
            color: #ecf0f1;
        }

        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: #1abc9c;
            padding-left: 30px;
        }

        .sidebar form {
            margin-top: 20px;
            padding: 0 20px;
        }

        #logout {
            width: 100%;
            background-color: #e74c3c;
            border: none;
            color: #fff;
            padding: 10px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s ease;
        }

        #logout:hover {
            background-color: #c0392b;
        }

        .content {
            margin-left: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        nav.navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 15px 30px;
            background: #fff;
        }

        nav h6 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
        }

        main {
            flex: 1;
            padding: 30px;
            animation: fadeIn 0.4s ease-in-out;
        }

        footer.footer {
            background: #ffffff;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            border-top: 1px solid #e0e0e0;
            color: #777;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 200px;
            }

            nav h6 {
                font-size: 16px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                position: absolute;
                width: 100%;
                height: auto;
                z-index: 1050;
            }

            .content {
                margin-left: 0;
                padding: 15px;
            }

            nav.navbar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
    
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center">Admin Panel</h3>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('categories.list') }}">Categories</a>
        <a href="{{ route('post.index') }}">Website</a>
        <a href="{{ route('order.list') }}">Orders</a>
        <a href="{{ route('transactions') }}">Transactions</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="">
            @csrf
            <button  id="logout" name="logout">Logout</button>
        </form>

        
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Header -->
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <span class="navbar-brand"><h6>@yield('title')</h6></span>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="mt-3">
            @yield('content')
            
        </main>

        <!-- Footer -->
        <footer class="footer mt-auto">
            &copy; {{ date('Y') }} Admin Panel. All Rights Reserved.
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

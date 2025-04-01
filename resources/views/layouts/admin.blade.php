<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    @yield('styles')
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding-top: 20px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            margin-left: 250px; /* Prevent overlap */
            width: calc(100% - 250px);
            padding: 20px;
        }

        .footer {
            background: #f8f9fa;
            padding: 10px;
            text-align: center;
        }
    </style>
    
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center">Admin Panel</h3>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('categories.list') }}">Categories</a>
        <a href="{{ route('post.index') }}">Post</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="">
            @csrf
            <button  id="logout" name="logout">Logout</button>
        </form>

        
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <span class="navbar-brand">@yield('title')</span>
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

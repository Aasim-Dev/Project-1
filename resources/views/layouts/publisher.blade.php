<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Publisher dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/publisher.css') }}">
    @yield('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            display: flex;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(145deg, #2c3e50, #34495e);
            color: white;
            padding: 30px 0;
            position: fixed;
            height: 100%;
            left: 0;
            top: 0;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 22px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }

        .sidebar ul li a:hover {
            background: #1abc9c;
            padding-left: 30px;
            border-radius: 5px;
        }

        .sidebar ul li h5 {
            text-align: center;
            margin-top: 5px;
            color: #bdc3c7;
        }

        #logout-form {
            padding: 0 20px;
            margin-top: 20px;
        }

        #logout {
            width: 100%;
            background: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        #logout:hover {
            background: #c0392b;
        }

        .content {
            margin-left: 250px;
            flex: 1;
            padding: 30px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background: #fff;
            padding: 15px 25px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #2c3e50;
        }

        .dashboard-cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
            flex: 1;
            min-width: 250px;
            transition: transform 0.2s ease-in-out;
            text-align: center;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin: 0;
            font-size: 18px;
            color: #2c3e50;
        }

        .card p {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .footer {
            margin-top: auto;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 200px;
                padding: 20px;
            }

            .dashboard-cards {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .content {
                margin-left: 0;
                padding: 15px;
            }

            .header h1 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Publisher Panel</h2>
        <ul>
            <li><a href="{{ route('publisher.dashboard') }}" class="text-center ms-logo-img-link mt-2"> ${{$totalBalance ?? 0}}</a>
            <h5 class="text-center text-white mt-2">Balance</h5></li>
            <li><a href="{{ route('publisher.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('website.list') }}">Websites</a></li>
            <li><a href="{{route('orders')}}">Orders</a></li>
            <li><form id="logout-form" action="{{ route('logout') }}" method="POST" style="">
                    @csrf
                    <button  id="logout" name="logout">Logout</button>
                </form>
            </li> 
        </ul>
    </div>
    <div class="content">
        <header>
            <!-- <h1>Publisher Dashboard</h1> -->
        </header>
        <main>
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/publisher.js') }}"></script>
    @yield('scripts')
</body>
</html>


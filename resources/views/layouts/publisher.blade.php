<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Publisher dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/publisher.css') }}">
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

        .sidebar h2 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px 20px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            transition: 0.3s;
        }

        .sidebar ul li a:hover {
            background: #34495e;
            border-radius: 5px;
        }

        .content {
            margin-left: 250px; /* Prevent overlap */
            width: calc(100% - 250px);
            padding: 20px;
        }
    
        .header {
            background: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #2c3e50;
        }

        #logout-form{
            color: red;
            display: REM absolute;
            padding: 0px 0px;
            cursor: pointer;
            font-size: 6px;
        }

        .logout {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }

        .logout:hover {
            background: #c0392b;
        }

        .footer {
            background: #f8f9fa;
            padding: 10px;
            text-align: center;
        }
        .dashboard-cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 250px;
            text-align: center;
        }

        .card h3 {
            margin: 0;
            font-size: 18px;
            color: #2c3e50;
        }

        .card p {
            font-size: 14px;
            color: #7f8c8d;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 210px;
            }

            .dashboard-cards {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Publisher Panel</h2>
        <ul>
            <li><a href="{{ route('publisher.dashboard') }}" class="text-center ms-logo-img-link mt-2"> $</a>
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


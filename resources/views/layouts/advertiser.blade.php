<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Advertiser Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
    <style>
        /* Reset default margins and paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            height: 100vh;
            margin: 0;
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar styles */
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
            background: #495057;
            border-radius: 5px;
        }

        /* Main content area */
        .content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 20px;
            background-color: #f4f6f8;
            min-height: 100vh;
        }

        /* Header inside main content */
        .header {
            display: flex;
            justify-content: space-between; /* Push children to edges */
            align-items: center;
            background-color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Title on the left */
        .page-title {
            font-size: 22px;
            color: #2c3e50;
            margin: 0;
        }

        /* Cart button on the right */
        .cart-button {
            background-color: #3498db;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            transition: background-color 0.3s ease;
        }

        .cart-button:hover {
            background-color: #2980b9;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #2c3e50;
        }

        /* Logout button */
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

        /* Dashboard cards */
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

        /* Footer */
        .footer {
            background: #f8f9fa;
            padding: 10px;
            text-align: center;
            margin-top: 30px;
            border-radius: 8px;
        }

        /* Responsive tweaks */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }

            .dashboard-cards {
                flex-direction: column;
            }
        }

    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Advertiser</h2>
        <ul>
            <li><a href="{{ route('advertiser.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('orders.list') }}">My Orders</a></li>
            <li><a href="{{ route('website.lists') }}">Websites</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout">Logout</button>
                </form>
            </li>
        </ul>
    </div>

    <div class="content">
        <div class="header">
            <h1>@yield('title', 'Advertiser Dashboard')</h1>
            <form id="cartRedirectForm" method="GET" action="{{ route('cart.cartItems') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; font-size: 16px; cursor: pointer;">
                    🛒 Cart (<span id="cart-count">{{ \App\Models\Cart::where('advertiser_id', Auth::id())->count() }}</span>)
                </button>
            </form>
        </div>

        <div class="dashboard-cards">
            <!-- Example Cards -->
        </div>

        @yield('content')

        <div class="footer">
            &copy; {{ date('Y') }} Advertiser Dashboard
        </div>
    </div>
    @yield('scripts')
</body>
</html>


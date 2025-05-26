<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Advertiser Panel - @yield('title')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @yield('styles')
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* ANIMATIONS */
        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideInFromTop {
            0% {
                transform: translateY(-100%);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #34495e;
            padding: 0.75rem 1.5rem;
            color: white;
            animation: slideInFromTop 0.5s ease;
            z-index: 10;
        }

        .navbar-left, .navbar-middle, .navbar-right {
            display: flex;
            align-items: center;
        }

        .balance-box {
            background-color: #2d4c8273;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            animation: pulse 3s infinite ease-in-out;
        }

        .balance-box .balance {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .add-funds {
            margin-top: 0.2rem;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: color 0.3s;
        }

        .add-funds:hover {
            color:rgba(162, 242, 34, 0.94);
        }

        .navbar-middle {
            flex-grow: 1;
            justify-content: center;
            gap: 1rem;
        }

        .nav-link {
            color: white;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-link:hover {
            background-color: #fff;
            color: #45364b;
        }

        .icon-button {
            position: relative;
            margin-right: 1rem;
            cursor: pointer;
        }

        .icon-button i {
            font-size: 1.2rem;
            color: white;
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background: #22abf2;
            color: white;
            font-size: 0.7rem;
            border-radius: 50%;
            padding: 2px 6px;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-button {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .profile-pic {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            min-width: 140px;
            padding: 10px;
            z-index: 100;
            animation: fadeInScale 0.3s ease;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-menu button {
            background: none;
            border: none;
            width: 100%;
            padding: 8px 10px;
            text-align: left;
            color: #333;
            font-size: 0.95rem;
            border-radius: 4px;
        }

        .dropdown-menu button:hover {
            background-color: #f9f9f9;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            max-width: 500px;
            width: 100%;
            animation: fadeInScale 0.3s ease-in-out;
        }

        .modal h2 {
            margin-bottom: 1rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
        }

        label {
            margin-top: 1rem;
            font-weight: 600;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 0.6rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-top: 0.3rem;
            font-size: 1rem;
        }

        button#rzp-button {
            margin-top: 1.5rem;
            padding: 0.75rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%;
            transition: background-color 0.3s;
        }

        button#rzp-button:hover {
            background-color: #0056b3;
        }

        .footer {
            text-align: center;
            color: #aaa;
            padding: 1rem;
        }

        @media screen and (max-width: 768px) {
            .navbar-middle,
            .navbar-right {
                display: none;
            }
        }
    </style>


</head>
<body>
    <!-- Main Content -->
    <div class="content">
        <!-- Header -->
        <nav class="top-navbar">
            <div class="navbar-left">
                <div class="balance-box">
                    <span class="balance">${{$totalBalance}}</span>
                    <a href="#" class="add-funds">
                        <i class="fas fa-plus-circle"></i> ADD FUNDS 
                    </a>
                    <div class="overlay">
                        <div class="modal">
                            <h2>Add Funds</h2>
                            <form id="fundForm" action="{{ route('add-funds') }}" method="POST">
                                <input type="hidden" name="user_id" value="1">
                                @csrf
                                <label>Amount (USD):</label>
                                <select name="amount" id="amount">
                                    <option value="null">select</option>
                                    <option value="10">$10</option>
                                    <option value="50">$50</option>
                                    <option value="100">$100</option>
                                    <option value="200">$200</option>
                                    <option value="300">$300</option>
                                    <option value="400">$400</option>
                                    <option value="500">$500</option>
                                    <option value="1000">$1000</option>
                                </select>

                                <label>Payment Method:</label>
                                <select id="paymentMethod" name="paymentMethod" required>
                                    <option value="razorpay">Razorpay</option>
                                    <option value="paypal">PayPal</option>
                                </select>

                                <div id="payButtons" style="margin-top: 20px;">
                                    <button type="button" id="rzp-button" class="btn btn-primary">Add Funds</button>
                                    <div id="paypal-button-container" style="margin-top: 10px;"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="navbar-middle">
                <!-- <i class="fas fa-bars menu-icon"></i> -->
                <!-- <span class="brand-name">Lowprice <i class="fas fa-caret-down"></i></span> -->
                <a href="{{route('advertiser.dashboard')}}" class="nav-link">Dashboard</a>
                <a href="{{route('website.lists')}}" class="nav-link">Marketplace</a>
                <a href="{{route('orders.list')}}" class="nav-link">My Orders</a>
                <a href="{{route('urlChecker')}}" class="nav-link">Backlink Checker</a>
                @if(Auth::user()->register_from === 'partner')
                <a href="{{route('api')}}" class="nav-link">API</a>
                @endif
                 <!--<a href="#" class="nav-link">Content Purchase</a>
                <a href="#" class="nav-link">Free SEO Tools</a> -->
            </div>

            <div class="navbar-right">
                <div class="icon-button">
                    <a href=""><i class="fas fa-heart">
                    <span id="wishlist-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                        0
                    </span>
                    </i></a>
                </div>
                <div class="icon-button">
                    <a href="{{route('cart.cartItems')}}"><i class="fas fa-shopping-cart">
                    <span id="cart-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                        {{ \App\Models\Cart::where('advertiser_id', Auth::id())->count() }}
                    </span>
                    </i></a>
                </div>
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="profile-button" >
                        <img src="https://via.placeholder.com/30" class="profile-pic" alt="Profile">
                        <span>Profile <i class="arrow-down-icon"></i></span>
                    </div>

                    <div class="dropdown-menu" id="dropdownMenu">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>


        <!-- Page Content -->
        <main class="mt-3">
            @yield('content')
            <div></div>
        </main>

        <!-- Footer -->
        <footer class="footer mt-auto">
            &copy; {{ date('Y') }} 
        </footer>
    </div>
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @yield('scripts')
            @if(Session::has('message'))
                <script>
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "timeOut": "5000"
                    };
                    toastr.warning("{{ Session::get('message') }}");
                </script>
            @endif
    <script>
        $(document).ready(function(){
            $('#profileDropdown').on('click', function() {
                $('#dropdownMenu').toggleClass('active');
            });
            $(document).on('click', '.add-funds', function(){
                $('.overlay').css({ display: 'flex' }).animate({ opacity: 1 }, 300).css('visibility', 'visible');
                $('.overlay').show();
            });
            $(".overlay").click(function(e){
                if(e.target.classList.contains("overlay")){
                    $(".overlay").animate({ opacity: 0 }, 300, function(){
                        $(this).css({ display: 'none', visibility: 'hidden' });
                    });
                }
            });
            $('#rzp-button').on('click', function () {
                let method = $('#paymentMethod').val();
                let amount = $('#amount').val();

                if (amount === "null" || amount === "") {
                    alert("Please select a valid amount.");
                    return;
                }

                if (method === 'paypal') {
                    let form = $('<form>', {
                        method: 'POST',
                        action: '{{ route("wallet.paypal") }}'
                    });

                    form.append($('<input>', {
                        type: 'hidden',
                        name: '_token',
                        value: '{{ csrf_token() }}'
                    }));

                    form.append($('<input>', {
                        type: 'hidden',
                        name: 'amount',
                        value: amount
                    }));

                    $('body').append(form);
                    form.submit();
                } else {
                    alert('Razorpay not integrated yet!');
                }
            });
        });
    </script>
</body>
</html>


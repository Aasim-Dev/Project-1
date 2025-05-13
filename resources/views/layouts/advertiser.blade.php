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
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
         body {
            background-color: #ffffff;
         }
         .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal {
            background: #ffffff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 500px;
            animation: fadeInScale 0.3s ease-in-out;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal h2 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
            color: #333;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 1rem;
            margin-bottom: 0.3rem;
            font-weight: 600;
            color: #444;
        }

        input[type="text"],
        select {
            padding: 0.6rem 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        button#submit {
            margin-top: 1.5rem;
            padding: 0.75rem;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button#submit:hover {
            background-color: #0056b3;
        }
        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #45364b;
            padding: 0.75rem 1.5rem;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar-left,
        .navbar-middle,
        .navbar-right {
            display: flex;
            align-items: center;
        }

        .logo i {
            font-size: 1.5rem;
            background: #45364b;
            padding: 0.5rem;
            border-radius: 50%;
        }

        .balance-box {
            background-color: #f26522;
            padding: 0.25rem 1rem;
            margin-left: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .balance-box .balance {
            font-size: 1.2rem;
            font-weight: bold;
            display: block;
        }

        .add-funds {
            font-size: 0.85rem;
            color: white;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .navbar-middle {
            flex-grow: 1;
            justify-content: center;
            gap: 1rem;
        }

        .navbar-middle .brand-name {
            font-weight: bold;
            margin-right: 1rem;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
            position: relative;
            padding: 5px 8px;
        }

        .nav-link:hover{
            color: #f26522;
        }

        .menu-icon {
            margin-right: 1rem;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .navbar-right {
            gap: 1rem;
        }

        .icon-button {
            position: relative;
            cursor: pointer;
        }

        .icon-button i {
            font-size: 1.2rem;
        }

        .badge {
            position: absolute;
            top: -6px;
            right: -10px;
            background-color: #f266f222;
            color: white;
            font-size: 0.7rem;
            border-radius: 50%;
            padding: 2px 5px;
        }

        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-button {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .profile-pic {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 10px;
            z-index: 100;
            border-radius: 8px;
            min-width: 120px;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-menu button {
            background: none;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            color: #333;
            width: 100%;
            text-align: left;
        }

        .dropdown-menu button:hover {
            background-color: #f0f0f0;
        }

        .footer{
            color: white;
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
                    <span class="balance">$0</span>
                    <a href="#" class="add-funds">
                        <i class="fas fa-plus-circle"></i> ADD FUNDS 
                    </a>
                    <div class="overlay">
                        <div class="modal">
                            <h2>Add Funds</h2>
                            <form id="fundForm" action="" method="POST">
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
                <i class="fas fa-bars menu-icon"></i>
                <!-- <span class="brand-name">Lowprice <i class="fas fa-caret-down"></i></span> -->
                <a href="{{route('advertiser.dashboard')}}" class="nav-link">Dashboard</a>
                <a href="{{route('website.lists')}}" class="nav-link">Marketplace</a>
                <a href="{{route('orders.list')}}" class="nav-link">My Orders</a>
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
                $('.overlay').show();
            });
            $(".overlay").click(function(e){
                if(e.target.classList.contains("overlay")){
                    $(".overlay").fadeOut();
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
                        action: ''
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


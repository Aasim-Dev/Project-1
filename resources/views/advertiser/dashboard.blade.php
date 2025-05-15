@extends('layouts.advertiser')

@section('title', 'Dashboard')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            padding: 30px;
        }

        .container > div {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 30px;
            width: 200px;
            text-align: left;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container > div:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .container h2 {
            font-size: 36px;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .container p {
            font-size: 16px;
            color: #718096;
            margin: 0;
        }

        h3 {
            font-size: 24px;
            color: #1a202c;
            margin: 20px;
        }
        /* .icon-inline {
            color: #4a5568;
            margin-bottom: 10px; 
        } */
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
    </style>

@endsection

@section('content')
<h3>Hello {{ $user->name }},</h3>
    <div class="container">
        <div class="TotalOrder"> 
            <h2>{{ count($orders) }}</h2>
            <p><i class="fas fa-box  icon-inline"></i>Total Orders</p>
        </div>
        <div class="totalContent">      
            <h2>NA</h2>
            <p><i class="fas fa-pen-nib  icon-inline"></i>Total Content Writing</p>
        </div>
        <div class="total fund Added">    
            <h2>{{ $totalCredit }}</h2>
            <p><i class="fas fa-wallet  icon-inline"></i>Total Fund Added</p>
        </div>
    </div>
<h3>Your Projects</h3>
@endsection

@section('scripts')
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
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
                        action: '{{ route('wallet.paypal') }}'
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
@endsection
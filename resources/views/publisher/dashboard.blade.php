@extends('layouts.publisher')

@section('title', 'Publisher Dashboard')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }

        h3 {
            text-align: left;
            color: #2d3748;
            font-size: 24px;
            margin-top: 30px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            padding: 40px 20px;
        }

        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
            padding: 15px;
            text-align: left;
            width: 260px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            font-size: 36px;
            color: #1a202c;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
            color: #4a5568;
            margin: 0;
        }

        .icon-inline {
            font-size: 16px;
            color: #4299e1;
            margin-right: 8px;
            vertical-align: middle;
        }

    </style>
@endsection

@section('content')

<h3>Hello {{ $user->name }},</h3>
    <div class="container">
        <div class="card totalWebsites">      
            <p><i class="fas fa-globe icon-inline"></i></p>
            <p><h5>Total Websites Added</h5></p>
            <h2>{{ $websites }}</h2>
        </div>
        <div class="card TotalOrder"> 
            <p><i class="fas fa-shopping-cart icon-inline"></i></p>
            <p><h5>Total Orders</h5></p>
            <h2>{{ count($orders) }}</h2>
        </div>
        <div class="card totalFundAdded">    
            <p><i class="fas fa-wallet icon-inline"></i></p>
            <p><h5>Total Fund Credited</h5></p>
            <h2>{{ $wallets }}</h2>
        </div>
    </div>

@endsection

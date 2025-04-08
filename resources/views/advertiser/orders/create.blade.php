@extends('layouts.advertiser')

@section ('title', 'Create Order')

@section('styles')
<style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        thead {
            background-color: #f8f9fa;
        }

        th, td {
            padding: 12px 16px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #343a40;
            color: #ffffff;
            font-weight: 600;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        button[type="submit"] {
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        td[colspan="7"] {
            text-align: center;
            font-style: italic;
            color: #6c757d;
        }
    </style>
@endsection

@section('content')
    <h2>Place Your Order</h2>
    @foreach($carts as $cart)
    <div class="order">
        <form id="myForm" action="{{route('order.store')}}" method="POST">
            @csrf
            <input type=hidden id="id" name="id">
            <input type="hidden" name="publisher_id" value="{{ $cart->post->user_id }}">
            <input type="hidden" name="website_id" value="{{ $cart->website_id }}">
            <Label>Website Url:</Label>
            <input type="hidden" name="purpose" value="{{ $cart->post->website_url}}">
            <span ><strong>{{ $cart->post->website_url }}</strong></span><br>
            <Label>Price:</Label>
            <input type="hidden" name="price" value="{{(($cart->post->normal_gp ?? 0) + ($cart->post->normal_li ?? 0) + ($cart->post->other_gp ?? 0) + ($cart->post->other_li ?? 0)) * 1.3}}">
            <span name="price"><strong>Normal GP:{{ $cart->post->normal_gp }}</strong></span><br>
            <span name="price"><strong>Normal LI:{{ $cart->post->normal_li }}</strong></span><br>
            <span name="price"><strong>Other GP:{{ $cart->post->other_gp }}</strong></span><br>
            <span name="price"><strong>Other LI:{{ $cart->post->other_li }}</strong></span><br>
            <Label>Total:</Label>
            <span><strong>₹{{(($cart->post->normal_gp ?? 0) + ($cart->post->normal_li ?? 0) + ($cart->post->other_gp ?? 0) + ($cart->post->other_li ?? 0)) * 1.3}}</strong></span><br>  
                <input name="status" type="hidden" value="pending"><br>
            <button type="submit">Place Order</button><br>
        </form>
    </div>
    @endforeach
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
           
        })
    </script>

@endsection
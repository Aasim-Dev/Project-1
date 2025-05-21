@extends('layouts.advertiser')

@section('title', 'API page')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f8f9fa;
        }

        h2, h3 {
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        h2 {
            font-size: 1.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f0f0f0;
        }

        p {
            margin-bottom: 1rem;
        }

        a {
            color: #0d6efd;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0a58ca;
            text-decoration: underline;
        }

        /* Containers and Layout */
        .container {
            max-width: 1200px;
            padding: 0 1rem;
        }

        .tabs {
            margin-bottom: 2rem;
        }

        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .nav-tabs .nav-item {
            margin-bottom: -1px;
        }

        .nav-tabs .nav-link {
            color: #555;
            font-weight: 500;
            border: 1px solid transparent;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            background-color: #f9f9f9;
            margin-right: 0.5rem;
            padding: 0.75rem 1.25rem;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            background-color: #e5e7eb;
            color: #111;
            border-color: #e9ecef;
        }

        .nav-tabs .nav-link.active {
            background-color: #ffffff;
            border-color: #dee2e6;
            color: #0d6efd;
            font-weight: 600;
        }

        /* Tab Content */
        .tab-content {
            padding: 1rem;
            background-color: #fff;
            border-radius: 0 0 0.5rem 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .tab1, .tab2, .tab3, .tab4 {
            padding: 1.5rem;
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        /* Token Box and Warnings */
        .api-token-box {
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 0.5rem;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
        }

        .api-warning {
            font-size: 1.25rem;
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .add-funds {
            color: #0d6efd;
            font-weight: bold;
            cursor: pointer;
            text-decoration: underline;
        }

        .add-funds:hover {
            color: #0a58ca;
        }

        /* Token Containers */
        .api-container,
        .api-token-container,
        .api-token-container-note {
            margin: 1.5rem 0;
            padding: 1.25rem;
            border-radius: 0.5rem;
            position: relative;
            border-left-width: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .api-container {
            background-color: #fef2f2;
            border-left-color: #dc2626;
        }

        .api-token-container {
            background-color: #f0fdf4;
            border-left-color: #16a34a;
        }

        .api-token-container-note {
            background-color: #e0f2fe;
            border-left-color: #3b82f6;
        }

        .api-token-container-note h2 {
            color: #1e40af;
            font-size: 1.25rem;
            border-bottom: none;
            margin-bottom: 1rem;
        }

        .api_token {
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            border: 1px solid #e9ecef;
            color: #555;
            margin: 1rem 0;
        }

        .api_token span {
            font-weight: 600;
            color: #444;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
        }

        .copy-b {
            cursor: pointer;
            color: #6c757d;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            padding: 0.25rem;
            border-radius: 0.25rem;
        }

        .copy-b:hover {
            color: #16a34a;
            background-color: #f0fdf4;
        }

        /* Form Styles */
        form {
            margin: 1.5rem auto;
            padding: 1.75rem;
            max-width: 550px;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #444;
        }

        input.form {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            font-size: 1rem;
            transition: border-color 0.2s ease;
            margin-bottom: 1rem;
        }

        input.form:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        button {
            display: block;
            width: 100%;
            margin-top: 1rem;
            padding: 0.75rem 1rem;
            border: none;
            background-color: #2563eb;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        button:active {
            transform: translateY(1px);
        }

        /* Price Update */
        #guest-post-price,
        #link-insertion-price {
            text-align: center;
            color: #555;
            padding: 0.75rem;
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            margin: 0.5rem 0;
            font-weight: 500;
        }

        /* Error Message */
        #error, .error {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            text-align: center;
            padding: 0.5rem;
            background-color: #fef2f2;
            border-radius: 0.375rem;
            border: 1px solid #fee2e2;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 4px;
            z-index: 1000;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .nav-tabs .nav-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.9rem;
            }
            
            form {
                padding: 1.25rem;
            }
            
            .api_token {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .api_token span {
                word-break: break-all;
                display: block;
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        /* Tooltip */
        [data-toggle="tooltip"] {
            position: relative;
        }

        [data-toggle="tooltip"]:after {
            content: attr(title);
            position: absolute;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
        }

        [data-toggle="tooltip"]:hover:after {
            opacity: 1;
            visibility: visible;
        }

        /* No Copy Cursor */
        .no-copy {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            cursor: default;
        }

        /* Modal Styles */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid #eee;
            padding: 1.25rem 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            color: #333;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #eee;
            padding: 1rem 1.5rem;
        }

    </style>
@endsection

@section('content')
@if($totalBalance > 0 && $totalBalance != null)
<div class="tabs">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">API Token</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Commssion Structure</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="priceUpdate-tab" data-bs-toggle="tab" data-bs-target="#priceUpdate" type="button" role="tab" aria-controls="priceUpdate" aria-selected="false">Price Update</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="documentation-tab" data-bs-toggle="tab" data-bs-target="#documentation" type="button" role="tab" aria-controls="documentation" aria-selected="false">Documentation</button>
        </li>
    </ul>
</div>
@endif
<div class="tab1">
    @if($totalBalance == 0 || $totalBalance == null)
        <div class="api-token-box p-4 my-3 border rounded bg-light">
            <h2 class="mb-3">API Token</h2>
            <div class="api-container">
                <h3 class="api-warning text-danger fw-semibold">
                    To Generate API Token Please 
                    <a href="#" class="add-funds text-primary fw-bold text-decoration-underline">Add Funds</a>.
                </h3>
            </div>
        </div>
    @elseif($totalBalance <= 500 && $totalBalance != null)
        <h2>API Token</h2>
        <div class="api-token-container-note">
            <h2>Note: Please Maintain minimum amount of $500</h2>
            <h3 class="api_token no-copy" style="color:gray">
                Token: <span id="token-value">{{ $token }}</span>
                <i id="copy-btn" class="fas fa-copy copy-b"></i>
            </h3>
            <p><a href="https://lp-latest.elsnerdev.com/open-api/documentation" style="color:blue" target="_blank">Click Here to Test The APIs</a></p>
        </div>
    @elseif($totalBalance > 500 && $totalBalance != null)
        <h2>API Token</h2>
        <div class="api-token-container">
            <h3 class="api_token" style="color:gray">
                Token: <span id="token-value"> {{ $token }} </span>
                <i id="copy-btn" class="fas fa-copy copy-b"></i> 
            </h3>
            <p><a href="https://lp-latest.elsnerdev.com/open-api/documentation" style="color:blue" target="_blank">Click Here to Test The APIs</a></p>
        </div>
    @endif
</div>
@if($totalBalance > 0 || $totalBalance != null)
<div class="tab2">
    <h2>Commission Structure</h2>
    <div>
        <form action="" method="" id="commission-form">
            <label for="">Commission Price</label>
            <input type="text" id="commission" name="commission" class="form">
            <button class="com-sub" id="com-sub">Submit</button>
        </form>
    </div>
</div>
<div class="tab3">
    <h2>Price Update</h2>
    <div>
        <form id="priceUpdate-form">
            @csrf
            <label for="">Price Update URL</label>
            <input type="text" id="priceUpdate" name="priceUpdate" class="form">
            <button class="price-sub" id="price-sub">Submit</button>
        </form>
        <h4><p id="guest-post-price" style="text-align:center; color:gray;" >Guest Post Price: </p></h4>
        <h4><p id="link-insertion-price" style="text-align:center; color:gray;" >Link Insertion Price: </p></h4>
        <h6><p id="error" style="text-align:center; color:red;"></p></h6>
    </div>
</div>
<div class="tab4">
        <h2>Documentation</h2>
</div>
@endif
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function(){
            $.validator.addMethod("urlcheck", function(value, element){
                return this.optional(element) || /^[a-zA-Z]+\.[a-zA-Z]+$/.test(value) || /https?:\/\/[a-zA-Z0-9.-]+\.[a-zA-Z]+$/.test(value);
            }, "Please Enter Valid URL.");
            $('.tab1').show();
            $('.tab2').hide();
            $('.tab3').hide();
            $('.tab4').hide();
            $(document).on('click', '#home-tab', function(){
                $('.tab1').show();
                $('.tab2').hide();
                $('.tab3').hide();
                $('.tab4').hide();
                $('#priceUpdate-form').trigger("reset");
                $('#commission-form').trigger("reset");
            });
            $(document).on('click', '#profile-tab', function(){
                $('.tab1').hide();
                $('.tab2').show();
                $('.tab3').hide();
                $('.tab4').hide();
                $('#priceUpdate-form').trigger("reset");
            });
            $(document).on('click', '#priceUpdate-tab', function(){
                $('.tab1').hide();
                $('.tab2').hide();
                $('.tab3').show();
                $('.tab4').hide();
                $('#guest-post-price').hide();
                $('#link-insertion-price').hide();
                $('#error').hide();
                $('#commission-form').trigger("reset");
            });
            $(document).on('click', '#documentation-tab', function(){
                $('.tab1').hide();
                $('.tab2').hide();
                $('.tab3').hide();
                $('.tab4').show();
                $('#priceUpdate-form').trigger("reset");
                $('#commission-form').trigger("reset");
            });
            $("#commission-form").validate({
                rules:{
                    commission: {
                        required: true,
                        number: true,
                        min: 2,
                    },
                },
                submitHandler: function(e){
                    e.preventDefault();
                    form.submit();
                },
            });
            $("#priceUpdate-form").validate({
                rules:{
                    priceUpdate: {
                        required: true,
                        urlcheck: true,
                    },
                },
                submitHandler: function(){
                    let priceUpdate = $('#priceUpdate').val();
                    $.ajax({
                        url: "{{ route('checkPrice') }}",
                        type: "POST",
                        data: {
                            priceUpdate: priceUpdate,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response){
                            if(response.status == 'success'){
                                $('#guest-post-price').text('Guest Post Price: $' + response.guest_post_price).show();
                                $('#link-insertion-price').text('Link Insertion Price: $' + response.linkinsertion_price).show();      
                            }else{
                                $('#error').text('Error:' + response.error).show();
                            }
                        },
                        error: function(xhr, status, error, response){
                            if(response.status == 'error'){
                                $('#error').text('Error:' + response.error).show();
                            }
                        }
                    });
                },
            });
            let userBalance = parseFloat("{{ $totalBalance }}");
            if (userBalance <= 500) {
                $('body').css({
                    'user-select': 'none',
                    '-webkit-user-select': 'none',
                    '-moz-user-select': 'none',
                    '-ms-user-select': 'none'
                });

                // Prevent right-click
                $(document).on('contextmenu', function (e) {
                    e.preventDefault();
                });

                // Disable text selection/copy/drag on specific token container
                $('.api_token').on('copy paste cut dragstart selectstart', function(e) {
                    e.preventDefault();
                }).css({
                    'user-select': 'none',
                    '-webkit-user-select': 'none',
                    '-moz-user-select': 'none',
                    '-ms-user-select': 'none'
                }).addClass('no-copy');

                // Prevent manual selection or copying attempts
                $('#token-value').on('copy paste cut contextmenu selectstart', function(e) {
                    e.preventDefault();
                }).css({
                    'user-select': 'none'
                });
            }

            // Handle copy button
            $('#copy-btn').on('click', function(){
                let userBalance = parseFloat("{{ $totalBalance }}");
                const btn = $(this);
                const tokenText = $('#token-value').text();

                navigator.clipboard.writeText(tokenText).then(function () {
                    $('.toast').toast('show');
                    btn.css('color', 'green');
                    setTimeout(function(){
                        btn.css('color', 'gray');
                    }, 2000);
                });
            });
        });
    </script>

@endsection
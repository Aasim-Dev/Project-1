@extends('layouts.advertiser')

@section('title', 'API page')

@section('styles')
    <style>
        .api-container {
            margin-top: 2rem;
            padding: 1rem;
            background-color: #fef2f2; /* light red background */
            border-left: 4px solid #dc2626; /* red border */
            border-radius: 0.375rem;
        }

        .api-warning {
            color: #dc2626;
            font-weight: 500;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 4px;
            font-size: 1rem;
            margin: 0;
        }

        .api-warning .add-funds {
            color: #dc2626;
            text-decoration: underline;
            cursor: pointer;
        }

        .api-token-container {
            margin-top: 2rem;
            padding: 1rem;
            background-color: #f0fdf4; /* light green background */
            border-left: 4px solid #16a34a; /* green border */
            border-radius: 0.375rem;
        }

        .api-token-container-note {
            margin-top: 2rem;
            padding: 1rem;
            background-color:rgb(240, 252, 253); /* light green background */
            border-left: 4px solid #3b82f6; /* green border */
            border-radius: 0.375rem;
        }

        .api-token-container h3 {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .api-token-container-note h3 {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .api-token-container a {
            color: #2563eb;
            text-decoration: underline;
            font-weight: 500;
        }
        .copy-button {
            padding: 4px 10px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.2s ease;
        }
        .copy-button:hover {
            background-color: #1e40af;
        }
    </style>
@endsection

@section('content')
    @if($totalBalance == 0 || $totalBalance == null)
        <h2>API Token</h2>
        <div class="api-container">
            <h3 class="api-warning">
                To Generate API Token Please <a class="add-funds">Add Funds</a>.
            </h3>
        </div>
    @elseif($totalBalance <= 500 && $totalBalance != null)
        <h2>API Token</h2>
        <div class="api-token-container-note">
            <h2>Note: Please Maintain minimum amount of $500</h2>
            <h3 class="api_token no-copy">
                Token: <span id="token-value">{{ $token }}</span>
                <button id="copy-btn" class="copy-button"><i class="fas fa-copy"></i></button>
            </h3>
            <p><a href="https://lp-latest.elsnerdev.com/open-api/documentation" style="color:blue" target="_blank">Click Here to Test The APIs</a></p>
        </div>
    @elseif($totalBalance > 500 && $totalBalance != null)
        <h2>API Token</h2>
        <div class="api-token-container">
            <h3 class="api_token">
                Token: <span id="token-value">{{ $token }}</span>
                <button id="copy-btn" class="copy-button"><i class="fas fa-copy"></i></button>
            </h3>
            <p><a href="https://lp-latest.elsnerdev.com/open-api/documentation" style="color:blue" target="_blank">Click Here to Test The APIs</a></p>
        </div>
    @endif
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function(){
            // Disable text selection globally
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
                    btn.html('<i class="fas fa-check"></i>');
                    setTimeout(function () {
                        $btn.html('<i class="fas fa-copy"></i>');
                    }, 1500);
                });
            });
        });
    </script>

@endsection
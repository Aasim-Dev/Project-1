@extends('layouts.advertiser')

@section('title', 'Order Summary')

@section('styles')
    <style>
        /* Global reset and base styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9fafb;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Container styling */
        .order-summary-table {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
        }

        .order-summary-table p,
        .order-summary-table table {
            margin-top: 20px;
        }

        /* Inspirational quote */
        .order-summary-table::before {
            content: "Order Summary";
            display: block;
            font-size: 1rem;
            color: #6b7280;
            margin-bottom: 20px;
            font-style: italic;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            overflow-x: auto;
        }

        thead th {
            background-color: #2563eb;
            color: #ffffff;
            text-align: left;
            padding: 12px 16px;
            font-weight: 600;
            font-size: 14px;
        }

        tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
            color: #374151;
        }

        tbody tr:hover {
            background-color: #f3f4f6;
        }

        a {
            color: #ef4444;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Order summary section */
        .order-summary {
            max-width: 400px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
            text-align: left;
        }

        .order-summary h3 {
            font-size: 20px;
            color: #111827;
            margin-bottom: 15px;
        }

        .order-summary p {
            margin: 8px 0;
            color: #374151;
            font-size: 15px;
        }

        /* Button styling */
        .btn-primary {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: 600;
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

    </style>
@endsection

@section('content')
    <div class="order-summary-table">
        <table id="myTable">
            <thead>
                <tr>
                    <th>Website URL</th>
                    <th>Order Type</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carts as $item)
                    <tr>
                        <td>{{ $item->host_url }}</td>
                        @if( $item->type == 'provide_content' )
                            <td>Guest Post</td>
                        @elseif( $item->type == 'expert_writer' )
                            <td>Content + Guest Post</td>
                        @elseif( $item->type == 'link_insertion' )
                            <td>Link Insertion</td>
                        @endif
                        <td>{{ $item->quantity ?? 1}}</td>
                        <td>
                        @if($item->type == 'provide_content' && $item->type == 'expert_writer' && $item->type == 'link_insertion')
                            ${{ $item->guest_post_price, $item->linkinsertion_price * 1.3 }}
                        @elseif($item->type == 'provide_content' && $item->type == 'expert_writer')
                            ${{ $item->guest_post_price * 1.3 }}
                        @elseif($item->type == 'link_insertion')
                            ${{ $item->linkinsertion_price * 1.3}}
                        @elseif($item->type == 'provide_content')
                            ${{ $item->guest_post_price * 1.3}}
                        @elseif($item->type == 'expert_writer' && $item->word_count == '500 words')
                            ${{ $item->guest_post_price+20 }}
                        @elseif($item->type == 'expert_writer' && $item->word_count == '1000 words')
                            ${{ $item->guest_post_price+30 }}
                        @elseif($item->type == 'expert_writer' && $item->word_count == '1500 words')
                            ${{ $item->guest_post_price+35 }}
                        @elseif($item->type == 'expert_writer' && $item->word_count == '2000 words')
                            ${{ $item->guest_post_price+45 }}
                        @elseif($item->type == 'expert_writer' && $item->word_count == '3000 words')
                            ${{ $item->guest_post_price+65 }}
                        @elseif($item->type == 'expert_writer' && $item->word_count == '100000 words')
                            ${{ $item->guest_post_price+900 }}
                        @else
                            ${{ $item->guest_post_price }}
                        @endif 
                        </td>
                        <td><a href="">delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="order-summary">
        <h3>Summary</h3>
        <h5 style="color:green">The price shown below is with word count you entered. *</h5>
        <p>Total: ${{ number_format($total, 2) }} </p>

            <form method="POST">
            @csrf
                <button type="button" class="btn btn-primary" id="checkout" data-id="{{$item->id}}" data-website_id="{{$item->website_id}}" data-host_url="{{$item->host_url}}" data-type="{{$item->type}}"
                data-price="{{$total}}">Checkout</button>
            </form>

    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Load Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Load jQuery Validation -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

    <!-- Load DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#checkout').on('click', function(){
                var website_id = $(this).data('website_id');
                var host_url = $(this).data('host_url');
                var type = $(this).data('type');
                var id = $(this).data('id');
                var price = $(this).data('price');

                $.ajax({
                    url: "{{route('order.store')}}",
                    type: "POST",
                    data: {
                        website_id: website_id,
                        host_url: host_url,
                        type: type,
                        id: id,
                        price: price,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                           alert('Order placed successfully!');
                            window.location.href = response.redirect_url;
                        } else {
                            alert("Error processing your request.");
                        }
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                });
            });
        });
    </script>
@endsection
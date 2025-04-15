@extends('layouts.advertiser')

@section('title', 'Orders-List')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        #myTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Table headers */
        #myTable thead tr {
            background-color: #4CAF50;
            color: white;
            text-align: left;
        }

        /* Table cells */
        #myTable th, #myTable td {
            padding: 12px 16px;
            border-bottom: 1px solid #ddd;
        }

        /* Table row hover */
        #myTable tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* Heading */
        h2 {
            font-size: 24px;
            color: #333;
            margin: 20px 0;
        }

        /* Cancel Button Styling */
        .cancel {
            padding: 6px 12px;
            background-color: #ff4d4d;
            border: none;
            color: white;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cancel:hover {
            background-color: #e60000;
        }
    </style>
@endsection

@section('content')
    <div>
        <h2> Here are your Some of the Orders</h2>
    </div>
    <table id="myTable">
            <thead>
                <tr>
                    <th>Created at</th>
                    <th>Advertiser ID</th>
                    <th>Publisher ID</th>
                    <th>Website ID</th>
                    <th>Website URL</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Order</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->advertiser_id}}</td>
                        <td>{{$order->publisher_id}}</td>
                        <td>{{$order->website_id}}</td>
                        <td><a href="{{$order->purpose}}">{{$order->purpose}}</a></td>
                        <td>{{($order->price > 0) ? '$' . $order->price : '-'}}</td>
                        <td>{{$order->status}}</td>  
                        <td><button class="cancel" data-id="{{$order->id}}">Cancel</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endsection

@section('scripts')
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            // Set CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#myTable").dataTable({
                "paging": true,
                "searching": true,
                "filtering": true,
                "info": true,
                "ordering": true,
                "order": [[ 0, "desc" ]],
                "lengthMenu": [25, 50],
                "pageLength": 25,
            });

            // Listen to Cancel button clicks using event delegation
            $(document).on('click', '.cancel', function () {
                let orderId = $(this).data('id');

                if (!confirm("Are you sure you want to cancel this order?")) {
                    return;
                }

                $.ajax({
                    url: "{{ route('orders.cancel') }}",
                    method: "POST",
                    data: {
                        id: orderId,
                        status: 'cancelled'
                    },
                    success: function (response) {
                        location.reload();
                        button.text('Cancelled').prop('disabled', true).css('background-color', 'gray');
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert("Something went wrong");
                    }
                });
            });
        });
    </script>
@endsection
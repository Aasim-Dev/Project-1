@extends('layouts.admin')

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
        .approve {
            padding: 6px 12px;
            background-color:rgb(34, 179, 41);
            border: none;
            color: white;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .approve:hover {
            background-color:rgb(38, 230, 0);
        }
        .reject {
            padding: 6px 12px;
            background-color:rgb(154, 55, 25);
            border: none;
            color: white;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .reject:hover {
            background-color:rgba(197, 18, 18, 0.72);
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
                    <!-- <th>Advertiser ID</th>
                    <th>Publisher ID</th>
                    <th>Website ID</th> -->
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
                        <!-- <td>{{$order->advertiser_id}}</td>
                        <td>{{$order->publisher_id}}</td>
                        <td>{{$order->website_id}}</td> -->
                        <td><a href="{{$order->purpose}}">{{$order->purpose}}</a></td>
                        <td>{{($order->price > 0) ? '$' . $order->price : '-'}}</td>
                        <td class="status">{{$order->status}}</td>
                        
                        <td>
                            <button class="approve" data-id="{{$order->id}}">Approve</button>
                            <button class="reject" data-id="{{$order->id}}">Reject</button>
                        </td>
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
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.approve').click(function() {
                let orderId = $(this).data('id');
                updateStatus(orderId, 'approved');
                //$(this).text('Approved');
            });
            $('tr').each(function(){
                let statusText = $(this).find('td.status').text().trim().toLowerCase();
                if(statusText === 'cancelled') {
                    $(this).find('.approve, .reject').attr('disabled', true);
                }
            });
            function updateStatus(orderId, status){
                $.ajax({
                    url: "{{ route('order.updateStatus') }}",
                    type: 'POST',
                    data: {
                        id: orderId,
                        status: status,
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.errors); 
                    }
                });
            }
            $(".reject").click(function(){
                let orderId = $(this).data('id');
                updateStatus(orderId, 'rejected');
                //$(this).text('Rejected');
            });
            
            $("#myTable").DataTable({
                paging: true,
                searching: true,
                ordering: true,
                order: [ 2, 'desc' ],
                lengthMenu: [25, 50],
                pageLength: 25,
                columnDefs:[
                    {
                        targets: -1,
                        orderable: false
                    }
                ]
            });
        });
    </script>
@endsection

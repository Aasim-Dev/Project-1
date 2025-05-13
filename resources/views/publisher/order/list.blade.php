@extends('layouts.publisher')

@section('title', 'Orders-List')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
    <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
        <div class="modal-header">
            <h5 class="modal-title" id="chatModalLabel">Order ID: #</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
            <div class="p-3 mb-3 border rounded bg-light text-danger">
            <strong>⚠️ It is prohibited:</strong><br>
            1. To establish any personal contact outside Link Publishers and share contact details.<br>
            2. To discuss about Link Publishers’ prices.<br><br>
            All messages exchanged here are monitored. Link Publishers holds the authority to suspend or ban your account if any unauthorized activity is noticed or anyone violates our guidelines.
            </div>
            
            <!-- Chat input -->
            <div class="input-group">
            <input type="text" id="box" class="form-control" placeholder="Type your message...">
            <button class="btn btn-primary" type="button">
                <i class="fas fa-paper-plane">send</i>
            </button>
            </div>
        </div>
        </div>
    </div>
    </div>
    <table id="myTable">
            <thead>
                <tr>
                    <th>Order Date</th>
                    <th>OrderID</th>
                    <th>Website</th>
                    <th>Price</th>
                    <th>Language</th>
                    <th>Type</th>
                    <th>delivery Time</th>
                    <th>Action</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->id}}</td>
                        <td>{{$order->host_url}}</td>
                        <td>{{($order->price > 0) ? '$' . $order->price : '-'}}</td>
                        <td>{{$order->language}}</td>
                        @if( $order->type == 'provide_content' )
                            <td>Guest Post</td>
                        @elseif( $order->type == 'expert_writer' )
                            <td>Content + Guest Post</td>
                        @elseif( $order->type == 'link_insertion' )
                            <td>Link Insertion</td>
                        @endif    
                        <td>{{$order->tat}}</td>
                        <td>
                            <button class="approve" data-id="{{$order->id}}">Approve</button>
                            <button class="reject" data-id="{{$order->id}}">Reject</button>
                        </td>  
                        <td><button class="chat" id="chat-btn" data-id="{{$order->id}}">Chat</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
            $('.approve').click(function() {
                let orderId = $(this).data('id');
                updateStatus(orderId, 'in_progress');
                $(this).text('Approved');
            });
            function updateStatus(orderId, status){
                $.ajax({
                    url: "{{ route('order.update') }}",
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

            $('#myTable').on('click', '#chat-btn', function() {
                var orderId = $(this).data('id');
                var websiteId = $(this).data('website-id');
                //$("#box").reset();
                $("#chatModal").modal('show');
                $("#chatModalLabel").text("Order ID: #" + websiteId);
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

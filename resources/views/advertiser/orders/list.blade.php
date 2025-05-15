@extends('layouts.advertiser')

@section('title', 'Orders-List')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
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
    <!-- Chat Modal -->
    <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="chatModalLabel">Order ID: #<span id="order-id-span"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Alert box -->
                <div class="p-3 mb-3 border rounded bg-light text-danger">
                <strong>⚠️ It is prohibited:</strong><br>
                1. To establish any personal contact outside...<br>
                2. To discuss about Link Publishers’ prices.<br><br>
                All messages exchanged here are monitored.
                </div>

                <!-- Chat Messages -->
                <div id="chat-box" class="border rounded p-3 mb-3" style="height: 300px; overflow-y: auto;">
                <div class="text-muted text-center">No messages yet.</div>
                </div>

                <!-- Chat input -->
                <div class="input-group">
                <input type="text" id="chat-input" class="form-control" placeholder="Type your message...">
                <button class="btn btn-primary" id="send-chat" type="button">
                    <i class="fas fa-paper-plane"></i> Send
                </button>
                </div>
            </div>
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
                    <th>Status</th>
                    <th>Action</th>
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
                        <td>{{$order->status}}</td>  
                        <td><button class="btn btn-outline-primary open-chat" data-order-id="{{ $order->id }}" data-user-id="{{ $order->publisher_id }}">
                            Chat
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" style="text-align: center; color: red;">You have 24 Hours of Time to complete the order.</td>
                </tr>
            </tfoot>
        </table>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>
        $(document).ready(function () {
            let receiverId = null;
            let orderId = null;
            let chatInterval = null;
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
                ajax: "",
                columns: [
                    
                ],
                dom: 'Bfrtip', // Enables the buttons section
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'ExportedData', // Optional: Excel file name
                        text: '<i class="fas fa-file-excel"></i>Export', // Button text
                        className: 'btn btn-outline-success', // Optional: Bootstrap styling
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        },
                    }
                ],
                
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
            $('.open-chat').on('click', function () {
                receiverId = $(this).data('user-id');
                orderId = $(this).data('order-id');

                $('#order-id-span').text(orderId);
                $('#chat-box').html('<div class="text-muted text-center">Loading messages...</div>');

                fetchMessages();
                clearInterval(chatInterval);
                chatInterval = setInterval(fetchMessages, 60000);

                setTimeout(() => {
                    Echo.leave('chat.' + receiverId);
                    Echo.channel('chat.' + receiverId)
                        .listen('MessageSeen', (event) => {
                            $('#chat-box').find(`.message[data-id="${event.messageId}"]`).append('<div class="text-muted small text-end">✔ Seen</div>');
                        });
                }, 1000);


                const modal = new bootstrap.Modal(document.getElementById('chatModal'));
                modal.show();
            });

            // Send message on button click
            $('#send-chat').on('click', function () {
                let message = $('#chat-input').val().trim();
                if (!message) return;

                $.ajax({
                url: "{{route('chat.send')}}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    receiver_id: receiverId,
                    message: message
                }),
                success: function (data) {
                    $('#chat-input').val('');
                    fetchMessages();
                }
                });
            });

            // Fetch messages function
            function fetchMessages() {
                $.getJSON(`/chat/messages/${receiverId}`, function (messages) {
                let chatBox = $('#chat-box');
                chatBox.empty();

                if (messages.length === 0) {
                    chatBox.html('<div class="text-muted text-center">No messages yet.</div>');
                    return;
                }

                messages.forEach(function (msg) {
                    const alignment = msg.sender_id == {{ auth()->id() }} ? 'text-end' : 'text-start';
                    const bubbleClass = alignment === 'text-end' ? 'bg-primary text-white' : 'bg-light';

                    let seenLabel = '';
                    // Show "Seen" only for messages sent by current user
                    if (msg.sender_id == {{ auth()->id() }} && msg.is_read) {
                        seenLabel = `<div class="text-muted small text-end">✔ Seen</div>`;
                    }

                    chatBox.append(`
                    <div class="${alignment} message" data-id="${msg.id}">
                        <div class="${bubbleClass} rounded p-2 m-1 d-inline-block">
                            ${msg.message}
                        </div>
                    </div>
                    `);
                });

                chatBox.scrollTop(chatBox[0].scrollHeight);
                });
            }
        });
    </script>
@endsection
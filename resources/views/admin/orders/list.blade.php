@extends('layouts.admin')

@section('title', 'Orders-List')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <style>
        /* General Table Styling */
        #myTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        #myTable thead {
            background-color: #f8f9fa;
        }

        #myTable thead th {
            padding: 12px 16px;
            font-weight: 600;
            color: #333;
            border-bottom: 1px solid #ddd;
        }

        #myTable tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            color: #555;
        }

        #myTable tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Page Heading */
        h2 {
            font-size: 22px;
            color: #444;
            margin-bottom: 10px;
        }

        /* Status Buttons Group */
        .statusButtons {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .statusButtons .filter-btn {
            padding: 6px 14px;
            border: 1px solid #ccc;
            background-color: #f4f4f4;
            color: #333;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .statusButtons .filter-btn:hover {
            background-color: #eaeaea;
        }

        /* Active/Selected Button - JavaScript should apply this class */
        .filter-btn.active {
            background-color: #4CAF50 !important;
            color: white;
            border-color: #4CAF50;
        }

        /* Action Buttons */
        .approve, .reject {
            padding: 6px 12px;
            font-size: 14px;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }

        .approve {
            background-color: #28a745;
        }

        .approve:hover {
            opacity: 0.85;
        }

        .reject {
            background-color: #dc3545;
        }

        .reject:hover {
            opacity: 0.85;
        }

        .approve:disabled,
        .reject:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>

@endsection

@section('content')
    <div>
        <h2> Here are your Some of the Orders</h2>
    </div>
    <div class="statusButtons">
        <div class="newStatus">
            <button id="new" class="filter-btn" data-status="new">New ( {{ $new }} )</button>
        </div>
        <div class="inprogressStatus">
            <button id="ip" class="filter-btn" data-status="in_progress">In Progress ( {{ $in_progress }} )</button>
        </div>
        <div class="rejectStatus">
            <button id="reject" class="filter-btn" data-status="reject">Reject ( {{ $reject }} )</button>
        </div>
        <div class="completeStatus">
            <button id="complete" class="filter-btn" data-status="complete">Completed ( {{ $completed }} )</button>
        </div>
    </div>
    <table id="myTable">
            <thead>
                <tr>
                    <th>Order Date</th>
                    <th>OrderID</th>
                    <th>Advertiser</th>
                    <th>Website</th>
                    <th>Publisher</th>
                    <th>Price</th>
                    <th>Language</th>
                    <th>Type</th>
                    <th>delivery Time</th>
                    <th>Status</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
@endsection

@section('scripts')
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
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
            let status = '';
            $('.filter-btn').on('click', function() {
                $('.filter-btn').removeClass('active');
                $(this).addClass('active');
                status = $(this).data('status');
                $('#myTable').DataTable().ajax.reload();
            });

            
             $("#myTable").dataTable({
                serverSide: true,
                "paging": true,
                "searching": true,
                "lengthMenu": [25, 50],
                "pageLength": 25,
                orderSequence: ['desc', 'asc'],
                ajax: {
                    url: "{{route('adminsideorder.data')}}",
                    type: "POST",
                    data: function (d){
                        d.status = status;
                    },
                },
                columns: [
                    {data: 'created_at', name: 'created_at'},
                    {data: 'id', name: 'id'},
                    {data: 'advertiser_name', name: 'advertiser_name'},
                    {data: 'host_url', name: 'host_url'},
                    {data: 'publisher_name', name: 'publisher_name'},
                    {data: 'price', name: 'price'},
                    {data: 'language', name: 'language'},
                    {data: 'type', name: 'type'},
                    {data: 'tat', name: 'tat'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                columnDefs: [{
                    targets: '_all',
                    orderSequence: ['desc', 'asc'] 
                }],
                dom: 'Bfrtip', // Enables the buttons section
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'OrdersData', // Optional: Excel file name
                        text: '<i class="fas fa-file-excel"></i>Export', // Button text
                        className: 'btn btn-outline-success', // Optional: Bootstrap styling
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                        },
                    }
                ],
                
            });
        });
    </script>
@endsection

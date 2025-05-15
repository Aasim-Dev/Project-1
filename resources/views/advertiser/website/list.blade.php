@extends('layouts.advertiser')

@section('title', 'Website-List')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #f4f6f8;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .content {
        padding: 30px 20px;
        background-color: #f4f6f8;
        min-height: 100vh;
        width: 99%;
    }

    /* Optional quote or intro text */
    .content > div:first-of-type {
        font-size: 16px;
        color: #2c3e50;
        margin-bottom: 20px;
        font-style: italic;
    }

    /* Table styling */
    #myTable {
        width: 99%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    #myTable thead {
        background-color: #2c3e50;
        color: #fff;
    }

    #myTable th,
    #myTable td {
        padding: 14px 18px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    #myTable tbody tr:hover {
        background-color: #f9f9f9;
    }

    /* Add to Cart button */
    #myTable button {
        background-color: #2ecc71;
        color: #fff;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    #myTable button:hover {
        background-color: #27ae60;
    }
</style>
@endsection

@section('content')
    <table id="myTable">
        <thead>
            <tr>
                <th>Created At</th>
                <th>Website</th>
                <th>DA</th>
                <th>Sample Post</th>
                <th>Country</th>
                <th>normal</th>
                <th>other</th>
                <th>guest_post_price</th>
                <th>linkinsertion_price</th>
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
    <script>
        $(document).ready(function () {
            // Set CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $("#myTable").dataTable({
                serverSide: true,
                "paging": true,
                "searching": true,
                "lengthMenu": [25, 50],
                "pageLength": 25,
                ajax: "{{route('dataTable')}}",
                columns: [
                    {data: 'created_at', name: 'created_at'},
                    {data: 'host_url', name: 'host_url'},
                    {data: 'da', name: 'da'},
                    {data: 'sample_post', name: 'sample_post'},
                    {data: 'country', name: 'country'},
                    {data: 'normal', name: 'normal'},
                    {data: 'other', name: 'other'},
                    {data: 'guest_post_price', name: 'guest_post_price'},
                    {data: 'linkinsertion_price', name: 'linkinsertion_price'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                dom: 'Bfrtip', // Enables the buttons section
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'ExportedData', // Optional: Excel file name
                        text: '<i class="fas fa-file-excel"></i>Export', // Button text
                        className: 'btn btn-outline-success', // Optional: Bootstrap styling
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        },
                    }
                ],
            });

            // STEP 1: Load cart item IDs and update buttons
            $.get('{{ route("website.cart") }}', function (response) {
                const cartItems = response.cart.map(id => id.toString());

                $('.add-to-cart').each(function () {
                    const websiteId = $(this).data('id').toString();

                    if (cartItems.includes(websiteId)) {
                        $(this).text("Remove from Cart").css("background-color", "#e74c3c");
                    }
                });

                updateCartCount(); // Set the count on page load
            });

            // STEP 2: Handle Add/Remove click
            $(document).on('click', '.add-to-cart', function () {
                const button = $(this);
                const websiteId = button.data('id').toString();
                //alert('add');
                $.ajax({
                    url: "{{route('cart.toggle')}}",
                    type: "POST",
                    data: {
                        website_id: websiteId,
                        _token: '{{csrf_token()}}',
                    },
                    success: function(response){
                        if (response.status === 'success') {
                            button.text("Remove from Cart").css("background-color", "#e74c3c");
                        } else if (response.status === 'removed') {
                            button.text("Add to Cart").css("background-color", "#2ecc71");
                        }
                        updateCartCount(); // Update the count on toggle
                    },
                });
            });

            // STEP 3: Count updater function
            function updateCartCount() {
                $.ajax({
                    url: "{{route('cart.count')}}",
                    type: "GET",
                    success: function(response){
                         $('#cart-count').text(response.count);
                    },
                });
            }
        });

    </script>
@endsection
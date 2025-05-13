@extends('layouts.advertiser')

@section('title', 'Website-List')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
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
            @foreach($websites as $website)
                <tr>
                    <td>{{$website->created_at}}</td>
                    <td><a href="{{$website->website_url}}">{{ $website->host_url }}</a></td>
                    <td>{{ $website->da }}</td>
                    <td><a href="{{$website->website_url}}">{{ $website->sample_post }}</a></td>
                    <td>{{ $website->country }}</td>
                    <td>{{ $website->normal }}</td>
                    <td>{{ $website->other }}</td>
                    <td>{{ ($website->guest_post_price > 0) ? '$' . $website->guest_post_price : '-' }}</td>
                    <td>{{ ($website->linkinsertion_price > 0) ? '$' . $website->linkinsertion_price : '-' }}</td>
                    <td>
                        <button class="add-to-cart" data-id="{{$website->id}}">Add to Cart</button>
                        <!-- <button class="btn-delete" data-id="{{ $website->id }}">Delete</button> -->
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
        $(document).ready(function () {
            // Set CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                "columnDefs":[
                    {
                        targets: -1,
                        orderable: false
                    }
                ]
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
            $('.add-to-cart').click(function () {
                const button = $(this);
                const websiteId = button.data('id').toString();
                //alert('add');
                $.post('{{ route("cart.toggle") }}', { website_id: websiteId }, function (response) {
                    if (response.status === 'success') {
                        button.text("Remove from Cart").css("background-color", "#e74c3c");
                    } else if (response.status === 'removed') {
                        button.text("Add to Cart").css("background-color", "#2ecc71");
                    }
                    updateCartCount(); // Update the count on toggle
                });
            });

            // STEP 3: Count updater function
            function updateCartCount() {
                $.get('{{ route("cart.count") }}', function (response) {
                    $('#cart-count').text(response.count);
                });
            }
        });

    </script>
@endsection
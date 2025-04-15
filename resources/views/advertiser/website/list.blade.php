@extends('layouts.advertiser')

@section('title', 'Website-List')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f4f6f8;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header with Cart */
        /* .header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            background-color: #fff;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        
        .cart-button {
            background-color: #3498db;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            transition: background-color 0.3s ease;
        }

        .cart-button:hover {
            background-color: #2980b9;
        } */

        /* Quote text */
        .content > div:first-of-type {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-style: italic;
        }

        /* Table styling */
        #myTable {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        #myTable thead {
            background-color: #2c3e50;
            color: white;
        }

        #myTable th, #myTable td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        #myTable tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Add to Cart button */
        #myTable button {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
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
                <th>normal_gp</th>
                <th>normal_li</th>
                <th>other_gp</th>
                <th>other_li</th>
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
                    <td>{{ ($website->normal_gp > 0) ? '$' . $website->normal_gp : '-' }}</td>
                    <td>{{ ($website->normal_li > 0) ? '$' . $website->normal_li : '-' }}</td>
                    <td>{{ ($website->other_gp > 0) ? '$' . $website->other_gp : '-' }}</td>
                    <td>{{ ($website->other_li > 0) ? '$' . $website->other_li : '-' }}</td>
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
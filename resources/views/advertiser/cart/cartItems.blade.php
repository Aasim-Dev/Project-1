@extends('layouts.advertiser')

@section ('title', 'Cart Items')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<style>
        body{
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;    
            -ms-user-select: none;   
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        thead {
            background-color: #f8f9fa;
        }

        th, td {
            padding: 12px 16px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #343a40;
            color: #ffffff;
            font-weight: 600;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        button[type="submit"] {
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        td[colspan="7"] {
            text-align: center;
            font-style: italic;
            color: #6c757d;
        }
    </style>
@endsection

@section('content')
    <h2>My Cart Items</h2>

    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <table id="myTable">
            <thead>
                <tr>
                    <th>Created At</th>
                    <th>Website URL</th>
                    <th>DA</th>
                    <th>Country</th>
                    <th>Prices</th>
                    <th>SubTotal</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                @if ($item->post || $item->user)
                
                    <tr>
                        <td>{{ $item->post->created_at }}</td>
                        <td><a href="{{ $item->post->website_url }}">{{ $item->post->host_url }}</a></td>
                        <td>{{ $item->post->da }}</td>
                        <td>{{ $item->post->country }}</td>
                        <td>NormalGP: {{ ($item->post->normal_gp > 0) ? '$' . $item->post->normal_gp : ' -' }}<br>        
                            NormalLI: {{ ($item->post->normal_li > 0) ? '$' . $item->post->normal_li : ' -' }}<br>        
                            OtherGP: {{ ($item->post->other_gp > 0) ? '$' . $item->post->other_gp : ' -' }}<br>       
                            OtherLI: {{ ($item->post->other_li > 0) ? '$' . $item->post->other_li : ' -' }}
                        </td>
                        <td>
                            NormalGP:{{ ($item->post->normal_gp *1.3 > 0) ? '$' . $item->post->normal_gp *1.3 : ' -'}}<br>
                            NormalLI:{{ ($item->post->normal_li *1.3 > 0) ? '$' . $item->post->normal_li *1.3 : ' -'}}<br>
                            OtherGP:{{ ($item->post->other_gp *1.3 > 0) ? '$' . $item->post->other_gp *1.3 : ' -'}}<br>
                            OtherLI:{{ ($item->post->other_li *1.3 > 0) ? '$' . $item->post->other_li *1.3 : ' -'}}
                        </td>
                        <td>
                            <form method="POST" action="">
                                @csrf
                                <input type="hidden" name="website_id" value="{{ $item->website_id }}">
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endif
                @endforeach
            </tbody>
        </table>

        <br>
        <a href="{{ route('orders.create') }}">
            <button>Proceed to Checkout</button>
        </a>
    @endif
@endsection
@section('scripts')
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
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
        });
    </script>
@endsection


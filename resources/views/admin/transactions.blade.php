@extends('layouts.admin')

@section('title', 'Trasactions')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
    .transaction-data {
        margin: 20px 0;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .transaction-data button {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .transaction-data button:hover {
        background-color: #0056b3;
    }

    .filter-modal {
        background-color: #f8f9fa;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-top: 15px;
        display: none;
        width: 40%;
        max-width: 200px;
    }

    .filter-modal label {
        display: block;
        font-weight: bold;
        margin-top: 10px;
    }

    .filter-modal select,
    .filter-modal input {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .filter-modal .applyFilters {
        margin-top: 15px;
        background-color: #28a745;
    }

    .transaction-table {
        margin-top: 25px;
    }

    table.dataTable thead th {
        background-color: #343a40;
        color: white;
    }

    table.dataTable td {
        vertical-align: middle;
    }

    .btn.btn-outline-success {
        margin-bottom: 10px;
    }
</style>
@endsection

@section('content')
<div class="transaction-data">
    <button class="date-filter">Date Filter</button>
    <button class="filter">Filter Button</button>
    <form action="{{route('export')}}" method="POST">
    @csrf
        <button class="generate">Generate Report</button>
    </form>
    <div class="dateFilter-modal" style="display:none">
        <label for="filterDate" class="form-label">From Date</label>
        <input type="date" id="from-filterDate">
        <label for="filterDate" class="form-label">To Date</label>
        <input type="date" id="to-filterDate">
        <button class="date-btn">Submit</button>
    </div>
    <div class="filter-modal" style="display:none">
        <button class="close-guide" style="float: right;">✖</button>

        <label for="roleFilter">Role Filter</label>
        <select name="roleFilter" id="roleFilter">
            <option value="">select</option>
            <option value="Advertiser">Advertiser</option>
            <option value="Publisher">Publisher</option>
        </select>

        <label for="type-filter">Transaction Type</label>
        <select name="typeFilter" id="typeFilter">
            <option value="">select</option>
            <option value="credit">Credit</option>
            <option value="debit">Debit</option>
        </select>

        <label for="id-filter">Transaction ID</label>
        <select name="idFilter" id="idFilter">
            <option value="">select</option>
            <option value="add_fund">Add Fund</option>
            <option value="buying">Buy</option>
            <option value="refund">Refund</option>
        </select>

        <label for="statusFilter">Status</label>
        <select name="statusFilter" id="statusFilter">
            <option value="">select</option>
            <option value="COMPLETED">Completed</option>
            <option value="FAILED">Failed</option>
        </select>

        <button class="applyFilters">Apply Filter</button>
    </div>
</div>
<div class="transaction-table">
    <table class="myTable">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Role</th>
                <th>Transaction Reference</th>
                <th>Order Type</th>
                <th>Description</th>
                <th>Payment From</th>
                <th>Payment Type</th>
                <th>Amount</th>
                <th>Current Balance</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>

</div>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables Core -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Buttons Extension -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <!-- Required for export functionality -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <!-- Buttons for HTML5 Export -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.myTable').DataTable({
                serverSide: true,
                paging: true, 
                ordering: true,
                ajax: {
                    url: "{{route('transaction.table')}}",
                    type: "POST",
                    data: function(d) {
                        d.role_filter = $('#roleFilter').val();
                        d.type_filter = $('#typeFilter').val();
                        d.id_filter = $('#idFilter').val();
                        d.status_filter = $('#statusFilter').val();
                        d.from_date = $('#from-filterDate').val();
                        d.to_date = $('#to-filterDate').val();
                    },
                },
                columns: [
                    {data:'name', name:'users.name'},
                    {data:'role', name:'users.user_type'},
                    {data:'transaction_reference', name:'wallets.transaction_reference'},
                    {data:'order_type', name:'wallets.order_type'},
                    {data:'description' , name:'wallets.description'},
                    {data: 'payment_type', name:'wallets.payment_type'},
                    {data: 'credit_debit', name: 'wallets.credit_debit'},
                    {data: 'amount', name:'wallets.amount'},
                    {data: 'total', name:'wallets.total'},
                ],
                dom: 'Bfrtip', // Enables the buttons section
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'TransactionData', // Optional: Excel file name
                        text: '<i class="fas fa-file-excel"></i>Export', // Button text
                        className: 'btn btn-outline-success', // Optional: Bootstrap styling
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        },
                    }
                ],
            });
            $(document).on('click', '.filter', function(){
                $('.filter-modal').toggle();
            });
            $(document).on('click', '.date-filter', function(){
                $('.dateFilter-modal').toggle();
            });
            $('.applyFilters, .date-btn').on('click', function() {
                var table = $('.myTable').DataTable();
                table.ajax.reload();
            });
        });
    </script>
@endsection

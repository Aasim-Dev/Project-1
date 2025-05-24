@extends('layouts.admin')

@section('title', 'Orders-List')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container py-4">
    <h2 class="h4 mb-4 text-dark">Here are some of your orders</h2>

    <div class="d-flex flex-wrap gap-2 mb-4">
        <button id="new" class="btn btn-outline-secondary filter-btn" data-status="new">
            New ({{ $new }})
        </button>
        <button id="ip" class="btn btn-outline-secondary filter-btn" data-status="in_progress">
            In Progress ({{ $in_progress }})
        </button>
        <button id="reject" class="btn btn-outline-secondary filter-btn" data-status="reject">
            Reject ({{ $reject }})
        </button>
        <button id="complete" class="btn btn-outline-secondary filter-btn" data-status="complete">
            Completed ({{ $completed }})
        </button>
    </div>

    <div class="table-responsive">
        <table id="myTable" class="table table-bordered table-hover table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order Date</th>
                    <th>Order ID</th>
                    <th>Advertiser</th>
                    <th>Website</th>
                    <th>Publisher</th>
                    <th>Price</th>
                    <th>Language</th>
                    <th>Type</th>
                    <th>Delivery Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
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

            let status = '';

            $('.filter-btn').on('click', function() {
                $('.filter-btn').removeClass('active btn-primary').addClass('btn-outline-secondary');
                $(this).removeClass('btn-outline-secondary').addClass('btn-primary active');
                status = $(this).data('status');
                $('#myTable').DataTable().ajax.reload();
            });

            $('#myTable').DataTable({
                serverSide: true,
                paging: true,
                searching: true,
                lengthMenu: [25, 50],
                pageLength: 25,
                orderSequence: ['desc', 'asc'],
                ajax: {
                    url: "{{ route('adminsideorder.data') }}",
                    type: "POST",
                    data: function (d) {
                        d.status = status;
                    }
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
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        title: 'OrdersData',
                        text: 'Export PDF',
                        className: 'btn btn-outline-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                        },
                    }
                ]
            });
        });
    </script>
@endsection

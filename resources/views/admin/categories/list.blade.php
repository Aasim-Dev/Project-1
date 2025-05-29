@extends('layouts.admin')

@section('title', 'Categories')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }


        /* Table Styling */
        #myTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        #myTable th, #myTable td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        #myTable th {
            background-color: #f2f2f2;
        }

        .btn-edit, .btn-delete {
            padding: 5px 10px;
            margin-right: 5px;
            border-radius: 4px;
            color: white;
        }

        .btn-edit {
            background-color: #2196F3;
        }

        .btn-delete {
            background-color: #f44336;
        }
    </style>
@endsection

@section('content')
<h1>Here are some Categories</h1>
    <button id="addCategory">Add Categories from Here</button>
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form method="POST" id="catForm" action="{{ route('admin.category.store') }}">
                @csrf
                <input type="hidden" id="id" name="id" class="id" value="">
                <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="tag" class="form-label">Tag:</label>
                    <input type="text" id="tag" name="tag" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <input type="text" id="description" name="description" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type:</label>
                    <select name="type" id="type" class="form-select" required>
                    <option value="normal">Normal</option>
                    <option value="other">Other</option>
                    </select>
                </div>
                </div>

                <div class="modal-footer">
                <button type="submit" id="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <table id="myTable">
        <thead>
            <tr>
                <th>Created At</th>
                <th>Name</th>
                <th>Tag</th>
                <th>Description</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->created_at }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->tag }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->type }}</td>
                    <td>
                        <button class="btn-edit" data-id="{{ $category->id }}" data-name="{{$category->name}}" data-tag="{{$category->tag}}" data-description="{{$category->description}}" data-type="{{$category->type}}">Edit</button>
                        <button class="btn-delete" data-id="{{ $category->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#myTable").DataTable({
                paging: true,
                searching: true,
                ordering: true,
                order: [
                        [2, 'desc'],
                        [0, 'desc']
                        ],
                lengthMenu: [25, 50],
                pageLength: 25,
                columnDefs:[
                    {
                        targets: -1,
                        orderable: false
                    }
                ]
            });
            $("#addCategory").click(function () {
                //console.log("Add Category button clicked");
                $("#catForm")[0].reset();
                $("#modalTitle").text("Add Category");
                $("#categoryModal").modal('show');
            });
            $("#categoryModal").click(function(e){
                if(e.target.classList.contains("overlay")){
                    $("#categoryModal").modal('hide');
                }
            });
            $(document).on('click', '.btn-edit', function(){
                

                var id=$(this).data("id");
                var name=$(this).data("name");
                var tag=$(this).data("tag");
                var description=$(this).data("description");
                var type=$(this).data("type");

                $("#id").val(id);
                $("#name").val(name);
                $("#tag").val(tag);
                $("#description").val(description);
                $(".type").val(type);
                
                $("#categoryModal").modal('show');
            });
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data("id"); // Get the category ID
                $("#id").val(id);
                //var row = $(this).closest("tr"); // Find the row to remove

                if (confirm("Are you sure you want to delete this category?")) {
                    $.post("{{ route('admin.category.delete') }}", {
                        id: id,
                        _method: "DELETE",
                        _token: "{{ csrf_token() }}" // CSRF token for security
                    }, function(response) {
                        if (response.success) {
                            console.log("Category deleted successfully!");
                            location.reload();
                        } else {
                            alert("Error deleting category!");
                        }
                    })
                }
                
            });

            // $(document).on('click', '#submit', function() {  
            //     var id = $("#id").val();  // Get the ID from the hidden input
            //     $("#id").val(id);
            //     $("#catForm").submit();
            // });
        });
    </script> 
@endsection
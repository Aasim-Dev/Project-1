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

        /* Modal Overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        /* Modal Box */
        .modal {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Form Fields */
        .modal form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        .modal form input,
        .modal form select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
    <div class="overlay">
        <div class="modal">
            <h2 id="modalTitle">Add Categories</h2>
            <form method="POST" id="catForm" action="{{ route('admin.category.store') }}">
                @csrf
                <input type="hidden" id="id" name="id" class="id" value="">
                <label>Name:</label>
                <input type="text" id="name" name="name" required>
                <label>Tag:</label>
                <input type="text" id="tag" name="tag" required>
                <label>Description:</label>
                <input type="text" id="description" name="description" required>
                <label>Type:</label>
                <select name="type"> <option value="normal"> Normal</option>
                <option value="other"> Other</option> </select>
                <button id="submit" type="submit">Submit</button>
            </form>
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
                $(".overlay").fadeIn();
            });
            $(".overlay").click(function(e){
                if(e.target.classList.contains("overlay")){
                    $(".overlay").fadeOut();
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
                
                $(".overlay").fadeIn();
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
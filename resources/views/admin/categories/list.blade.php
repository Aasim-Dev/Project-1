@extends('layouts.admin')

@section('title', 'Categories')

@section('styles')
    <style>
        /* Overlay and Modal Styling */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none; /* Initially hidden */
        }

        .modal {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 500px;
            max-width: 90%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        #modalTitle {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Close Button */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: #555;
        }

        .close-btn:hover {
            color: red;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        /* Submit Button */
        button#submit {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: 0.3s;
        }

        button#submit:hover {
            background-color: #0056b3;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        /* Action Buttons */
        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-edit {
            background-color: #28a745;
            color: white;
        }

        .btn-edit:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* Add Category Button */
        #addCategory {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            display: block;
            margin: 20px auto;
        }

        #addCategory:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
            }
            
            .modal {
                width: 90%;
            }
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

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Tag</th>
            <th>Description</th>
            <th>Type</th>
            <th>Action<th>
        </tr>
            @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
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
    </table>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
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
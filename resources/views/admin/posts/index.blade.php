@extends('layouts.admin')

@section('title', 'Posts')

@section('styles')
    <style>
        /* Overlay and Modal Styling */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            margin: auto;
        }

        .modal {
            background: white;
            padding: 4px;
            border-radius: 4px;
            width: 500px;
            max-width: 90%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            align-items: center;
            justify-content:center;
            margin:auto;

        }

        #modalTitle {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 5px;
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
            padding: 4px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        button#submit {
            background-color: #007bff;
            color: white;
            padding: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
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

        /* Buttons */
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

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
            }
            
            .modal {
                width: 50%;
            }
        }
    </style>
@endsection
@section('content')
    <h1>Here are Some Post</h1>
    <div class="overlay">
        <div class = "modal">
            <h2 id="modalTitle">Add your Posts</h2>
                <form id="postForm" method="POST" action="{{route('publisher.posts.store')}}">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <label>Website Url:</label>
                    <input type="text" id="web" name="website_url" required><br>
                    <label>Host Url:</label>
                    <input type="text" id="host" name="host_url" required><br>
                    <label>DA:</label>
                    <input type="number" id="da" name="da" required><br>
                    <label>Sample Post:</label>
                    <input type="text" id="sample" name="sample_post" required><br>
                    <label>Country:</label>
                    <input type="text" id="country" name="country" required><br>
                    <label>Normal:</label>
                    <select name="normal"><option value="guest"> Guest</option>
                    <option value="post"> Post</option></select><br>
                    <label>Other:</label>
                    <select name="other"><option value="guest"> Guest</option>
                    <option value="post"> Post</option></select><br>
                    <button type="submit" id="submit">Submit</button>
                </form>
        </div>
    </div>
    <table>
        <tr>
            <th>ID</th>
            <th>Website</th>
            <th>Host</th>
            <th>DA</th>
            <th>Sample POst</th>
            <th>Country</th>
            <th>Normal</th>
            <th>Other</th>
            <th>Action</th>
        </tr>
        @foreach($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->website_url }}</td>
            <td>{{ $post->host_url }}</td>
            <td>{{ $post->da }}</td>
            <td>{{ $post->sample_post }}</td>
            <td>{{ $post->country }}</td>
            <td>{{ $post->normal }}</td>
            <td>{{ $post->other }}</td>
            <td>
                <button class="btn-edit" data-id="{{ $post->id }}" data-website_url="{{$post->name}}" data-host_url="{{$post->tag}}" data-da="{{$post->description}}" data-sample_post="{{$post->sample_post}}">Edit</button>
                <button class="btn-delete" data-id="{{ $post->id }}">Delete</button>
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
            $("#addPost").click(function () {
                //console.log("Add Category button clicked");
                $("#postForm")[0].reset();
                $("#modalTitle").text("Add Post");
                $(".overlay").show();
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

@extends('layouts.publisher')

@section('title', 'website')

@section('styles')
    <style>
        .hidden { display: none; } 

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
    <h1>Here are Some Websites</h1>
    <a href="{{route('publisher.website.create')}}">
        <button >Add Post from Here</button>
    </a>
    <div class="overlay">
        <div class = "modal">
            <h2 id="modalTitle">Add your website</h2>
                <form id="postForm" method="POST" action="{{route('publisher.website.store')}}">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <label>Website Url:</label>
                    <input type="text" id="web" name="website_url" ><br>
                    @error('website_url')
                        <span role="alert">
                            <strong>{{$message}}<strong>
                        </span>
                    @enderror
                    <label></label>
                    <input type="hidden" id="host" name="host_url" >
                    @error('host_url')
                        <span style="color:'red';" role="alert">
                            <strong style="color:'red';">{{$message}}<strong>
                        </span>
                    @enderror
                    <label>DA:</label>
                    <input type="number" id="da" name="da" ><br>
                    @error('da')
                        <span role="alert">
                            <strong>{{$message}}<strong>
                        </span>
                    @enderror
                    <label>Sample Post:</label>
                    <input type="text" id="sample" name="sample_post" ><br>
                    @error('sample_post')
                        <strong>{{$message}}<strong>
                    @enderror
                    <!-- <label>Country:</label>
                    <input type="text" id="country" name="country" ><br>
                    @error('country')
                        <strong>{{$message}}<strong>
                    @enderror -->

                    <select id="categoryType" name="category">
                        <option value="">Select</option>
                        <option value="normal">Normal</option>
                        <option value="other">Other</option>
                    </select>

                    <select name="category_id" id="categoryList">
                        <option value="">Select Category</option>
                    </select>

                    <!-- Normal Category Options -->
                    <div id="normalOptions" class="hidden">
                        <h4>Normal Options</h4>
                        <label><input type="radio" name="normal_gp_li" value="normal_gp"> GP</label>
                        <input type="number" id="normal_gp" name="normal_gp" placeholder="Enter Normal GP Price" class="hidden">

                        <label><input type="radio" name="normal_gp_li" value="normal_li"> LI</label>
                        <input type="number" id="normal_li" name="normal_li" placeholder="Enter Normal LI Price" class="hidden">
                    </div>

                    <!-- Other Category Options -->
                    <div id="otherOptions" class="hidden">
                        <h4>Other Options</h4>
                        <label><input type="radio" name="other_li_gp" value="other_gp"> GP</label>
                        <input type="number" id="other_gp" name="other_gp" placeholder="Enter Other GP Price" class="hidden">

                        <label><input type="radio" name="other_li_gp" value="other_li"> LI</label>
                        <input type="number" id="other_li" name="other_li" placeholder="Enter Other LI Price" class="hidden">
                    </div>

                    <button type="submit" id="submit">Submit</button>
                </form>
        </div>
    </div>
    <table id="mytable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Website</th>
                <th>Host</th>
                <th>DA</th>
                <th>Sample Post</th>
                <th>AHREF Traffic</th>
                <th>TaT</th>
                <th>Country</th>
                <th>normal_gp</th>
                <th>normal_li</th>
                <th>other_gp</th>
                <th>other_li</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach($posts as $post)
        <tbody>
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->website_url }}</td>
                <td>{{ $post->host_url }}</td>
                <td>{{ $post->da }}</td>
                <td>{{ $post->sample_post }}</td>
                <td>{{ $post->ahref_traffic }}</td>
                <td>{{ $post->TaT }}</td>
                <td>{{ $post->country }}</td>
                <td>{{ $post->normal_gp }}</td>
                <td>{{ $post->normal_li }}</td>
                <td>{{ $post->other_gp }}</td>
                <td>{{ $post->other_li }}</td>
                <td>
                    <button class="btn-edit" data-id="{{ $post->id }}" data-website_url="{{$post->website_url}}" data-host_url="{{$post->host_url}}" data-da="{{$post->da}}" data-sample_post="{{$post->sample_post}}">Edit</button>
                    <button class="btn-delete" data-id="{{ $post->id }}">Delete</button>
                </td>
            </tr>
        </tbody>
        @endforeach
    </table>
@endsection    

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            // $("#web").on('input', function(){
            //     let userInput = $(this).val();
            //     let url = new URL(userInput);
            //     let hostname = url.hostname;
            //     $("#host").val(hostname);
                
            //     $.ajax({
            //         url: "{{route('publisher.website.store')}}",
            //         type: "POST",
            //         data:{
            //             _token: "{{ csrf_token() }}",
            //             host_url: hostname
            //         },
            //         success: function(){
            //             console.log("SUCCESS")
            //         },
            //     });
            // });
            $("#mytable").DataTable({
                "paging": true,
                "searching": true,
                "filtering": true,
                "info": true
            });
            $("#addPost").click(function () {
                //console.log("Add Category button clicked");
                $("#postForm")[0].reset();
                $("#modalTitle").text("Add Post");
                $(".overlay").show();
            });
            
            $(".overlay").click(function(e){
                if(e.target.classList.contains("overlay")){
                    $(".overlay").hide();
                }
            });
            $(document).on('click', '.btn-edit', function(){
                

                var id=$(this).data("id");
                var web=$(this).data("website_url");
                var da=$(this).data("da");
                var sample=$(this).data("sample_post");

                $("#id").val(id);
                $("#web").val(web);
                $("#da").val(da);
                $("#sample").val(sample);
                
                $(".overlay").fadeIn();
            });
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data("id"); // Get the category ID
                $("#id").val(id);
                //var row = $(this).closest("tr"); // Find the row to remove

                if (confirm("Are you sure you want to delete this category?")) {
                    $.post("{{ route('publisher.website.delete') }}", {
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

            $("select[name='category']").change(function () {
                let selectedValue = $(this).val(); // Get selected value
                
                if (selectedValue === "normal") {
                    $("#normalOptions").removeClass("hidden"); // Show normal options
                    $("#otherOptions").addClass("hidden"); // Hide other options
                } else if (selectedValue === "other") {
                    $("#otherOptions").removeClass("hidden"); // Show other options
                    $("#normalOptions").addClass("hidden"); // Hide normal options
                } else {
                    $("#normalOptions, #otherOptions").addClass("hidden"); // Hide both if none is selected
                }
            });
            $("input[name='normal_gp_li']").change(function () {
                $("#normal_gp, #normal_li").hide(); // Hide both inputs first
                if ($(this).val() === "normal_gp") {
                    $("#normal_gp").show();  // Show Normal GP price input
                } else if ($(this).val() === "normal_li") {
                    $("#normal_li").show();  // Show Normal LI price input
                }
            });

            $("input[name='other_li_gp']").change(function () {
                $("#other_gp, #other_li").hide(); // Hide both inputs first
                if ($(this).val() === "other_gp") {
                    $("#other_gp").show();  // Show Other GP price input
                } else if ($(this).val() === "other_li") {
                    $("#other_li").show();  // Show Other LI price input
                }
            });

            
            $("#categoryType").change(function () {
                let selectedType = $(this).val();
                console.log("Selected Category Type: ", selectedType); // Debugging

                if (selectedType !== "") {
                    $.ajax({
                        url: "{{route('categories-by-type')}}",
                        type: "GET",
                        data: { type: selectedType },
                        beforeSend: function () {
                            console.log("Sending request to /categories-by-type...");
                        },
                        success: function (response) {
                            console.log("RAW Response: ", response);

                            // Make sure the response is an array
                            if (Array.isArray(response)) {
                                console.log("Valid Category List Received: ", response);
                            } else {
                                console.log("Invalid response format: ", response);
                            }
                            $("#categoryList").empty(); // Clear previous options
                            $("#categoryList").append('<option value="">Select Category</option>');

                            // Append categories to the dropdown
                            $.each(response, function (index, category) {
                                $("#categoryList").append('<option value="' + category.id + '">' + category.name + '</option>');
                            });                  
                        },
                        error: function (xhr, status, error) {
                            console.log("AJAX Error:", xhr.responseText);
                        }
                    });
                }
            });
            
            
            // $(document).on('click', '#submit', function(e) {  
            //     e.preventDefault();
            //     $(".overlay").hide();
            // });
        });
    </script> 
@endsection

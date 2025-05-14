@extends('layouts.publisher')

@section('title', 'website')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f7f9fc;
        margin: 0;
        padding: 20px;
    }

    h1 {
        color: #2c3e50;
        text-align: center;
        margin-bottom: 30px;
    }

    button {
        background-color: #3498db;
        color: white;
        padding: 10px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #2980b9;
    }

    a {
        text-decoration: none;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 999;
        justify-content: center;
        align-items: center;
    }

    .modal {
        background-color: white;
        padding: 25px 30px;
        border-radius: 10px;
        width: 500px;
        max-width: 95%;
        box-shadow: 0 8px 16px rgba(0,0,0,0.3);
        position: relative;
    }

    .modal h2 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #333;
    }

    form label {
        display: block;
        margin: 12px 0 5px;
        font-weight: 600;
    }

    form input[type="text"],
    form input[type="number"],
    form select {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    form input[type="radio"] {
        margin-right: 8px;
    }

    .hidden {
        display: none;
    }

    table#myTable {
        width: 100%;
        border-collapse: collapse;
        margin-top: 40px;
        background: white;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        overflow: hidden;
    }

    #myTable th, #myTable td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    #myTable thead {
        background-color: #3498db;
        color: white;
    }

    #myTable tr:hover {
        background-color: #f1f1f1;
    }

    .btn-edit,
    .btn-delete {
        padding: 6px 10px;
        border-radius: 4px;
        margin: 0 5px;
        font-size: 0.9rem;
    }

    .btn-edit {
        background-color: #27ae60;
        color: white;
    }

    .btn-edit:hover {
        background-color: #1e8449;
    }

    .btn-delete {
        background-color: #e74c3c;
        color: white;
    }

    .btn-delete:hover {
        background-color: #c0392b;
    }

    span[role="alert"] strong {
        color: red;
        font-size: 0.9rem;
    }
</style>
@endsection
@section('content')
    <h1>Here are Some Websites</h1>
    <a href="{{route('publisher.website.create')}}">
        <button >Add Websites from Here</button>
    </a>
    <div class="overlay">
        <div class = "modal">
            <h2 id="modalTitle">Add your website</h2>
                <form id="postForm" method="POST">
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
    <table id="myTable">
        <thead>
            <tr>
                <th>Created At</th>
                <th>Website</th>
                <th>DA</th>
                <th>Sample Post</th>
                <th>AHREF Traffic</th>
                <th>TaT</th>
                <th>Country</th>
                <th>Guest Post Price</th>
                <th>Link Insertion Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)    
                <tr>
                    <td>{{ $post->created_at }}</td>
                    <td><a href="{{$post->website_url}}">{{ $post->host_url }}</a></td>
                    <td>{{ $post->da }}</td>
                    <td><a href="{{$post->website_url}}">{{ $post->sample_post }}</a></td>
                    <td>{{ $post->ahref_traffic }}</td>
                    <td>{{ $post->tat }}</td>
                    <td>{{ $post->country }}</td>
                    <td>{{ ($post->guest_post_price > 0) ? '$' . $post->guest_post_price : '-' }}</td>
                    <td>{{ ($post->linkinsertion_price > 0) ? '$' . $post->linkinsertion_price : '-' }}</td>
                    <td>
                        <button class="btn-edit" data-id="{{ $post->id }}" data-website_url="{{$post->website_url}}" data-host_url="{{$post->host_url}}" data-da="{{$post->da}}" data-sample_post="{{$post->sample_post}}">Edit</button>
                        <button class="btn-delete" data-id="{{ $post->id }}">Delete</button>
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
            // $("#web").on('input', function(){
            //     let userInput = $(this).val();
            //     let url = new URL(userInput);
            //     let hostname = url.hostname;
            //     $("#host").val(hostname);
                
            //     $.ajax({
            //         ,
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
            $("#myTable").DataTable({
                paging: true,
                searching: true,
                ordering: true,
                order: [ 2, 'desc' ],
                lengthMenu: [25, 50],
                pageLength: 25,
                columnDefs:[
                    {
                        targets: -1,
                        orderable: false
                    }
                ]
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

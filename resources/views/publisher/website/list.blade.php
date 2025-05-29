@extends('layouts.publisher')

@section('title', 'website')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f9f9f9;
        color: #333;
    }

    h1 {
        text-align: center;
        margin: 2rem 0;
        font-size: 2rem;
    }

    a button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 16px;
        margin: 1rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    a button:hover {
        background-color: #45a049;
    }
    table#myTable {
        width: 95%;
        margin: 2rem auto;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }

    table#myTable thead {
        background: #f2f2f2;
    }

    table#myTable th, table#myTable td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    table#myTable th {
        font-weight: bold;
        font-size: 14px;
    }

    table#myTable tbody tr:hover {
        background-color: #f9f9f9;
    }

    .btn-edit, .btn-delete {
        padding: 6px 12px;
        margin: 2px;
        font-size: 13px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        color: white;
    }

    .btn-edit {
        background-color: #28a745;
    }

    .btn-delete {
        background-color: #dc3545;
    }

    .btn-edit:hover {
        background-color: #218838;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }

    select {
        cursor: pointer;
    }

    span[role="alert"] strong {
        color: red;
        font-size: 13px;
        display: block;
        margin-top: -10px;
        margin-bottom: 10px;
    }

    /* Responsive Fix */
    @media (max-width: 768px) {
        .modal {
            width: 95%;
            padding: 1rem;
        }

        table#myTable th, table#myTable td {
            font-size: 13px;
            padding: 8px;
        }
    }
</style>
@endsection
@section('content')
    <h1>Here are Some Websites</h1>
    <a href="{{route('publisher.website.create')}}">
        <button >Add Websites from Here</button>
    </a>
    <div class="modal fade" id="websiteModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Update the Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="postForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">

                        <label>Website Url:</label>
                        <input type="text" id="web" name="website_url" class="form-control">
                        @error('website_url')
                            <span role="alert" class="text-danger"><strong>{{$message}}</strong></span>
                        @enderror

                        <input type="hidden" id="host" name="host_url">
                        @error('host_url')
                            <span role="alert" class="text-danger"><strong>{{$message}}</strong></span>
                        @enderror

                        <label>DA:</label>
                        <input type="number" id="da" name="da" class="form-control">
                        @error('da')
                            <span role="alert" class="text-danger"><strong>{{$message}}</strong></span>
                        @enderror

                        <label>Sample Post:</label>
                        <input type="text" id="sample" name="sample_post" class="form-control">
                        @error('sample_post')
                            <span role="alert" class="text-danger"><strong>{{$message}}</strong></span>
                        @enderror

                        <label>Category Type:</label>
                        <select id="categoryType" name="category" class="form-select">
                            <option value="">Select</option>
                            <option value="normal">Normal</option>
                            <option value="other">Other</option>
                        </select>

                        <label>Category:</label>
                        <select name="category_id" id="categoryList" class="form-select">
                            <option value="">Select Category</option>
                        </select>

                        <div id="normalOptions" class="hidden mt-3">
                            <h5>Normal Options</h5>
                            <label><input type="radio" name="normal_gp_li" value="normal_gp"> GP</label>
                            <input type="number" id="normal_gp" name="normal_gp" placeholder="Enter Normal GP Price" class="form-control hidden">

                            <label><input type="radio" name="normal_gp_li" value="normal_li"> LI</label>
                            <input type="number" id="normal_li" name="normal_li" placeholder="Enter Normal LI Price" class="form-control hidden">
                        </div>

                        <div id="otherOptions" class="hidden mt-3">
                            <h5>Other Options</h5>
                            <label><input type="radio" name="other_li_gp" value="other_gp"> GP</label>
                            <input type="number" id="other_gp" name="other_gp" placeholder="Enter Other GP Price" class="form-control hidden">

                            <label><input type="radio" name="other_li_gp" value="other_li"> LI</label>
                            <input type="number" id="other_li" name="other_li" placeholder="Enter Other LI Price" class="form-control hidden">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
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
                $("#websiteModal").modal('show');
            });
            
            $(".overlay").click(function(e){
                if(e.target.classList.contains("overlay")){
                    $("#websiteModal").modal('hide');
                }
            });
            $(document).on('click', '.btn-edit', function(){
                
                $("#websiteModal").modal('show');
                var id=$(this).data("id");
                var web=$(this).data("website_url");
                var da=$(this).data("da");
                var sample=$(this).data("sample_post");

                $("#id").val(id);
                $("#web").val(web);
                $("#da").val(da);
                $("#sample").val(sample);
                
                
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

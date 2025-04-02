@extends('layouts.publisher')

@section('title', 'Create-POST')

@section('styles')
    <style>
        .hidden { display: none; }  

        /* General Form Styling */
        form {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Label Styling */
        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Input Styling */
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Error Messages */
        span[role="alert"], strong {
            color: red;
            font-size: 14px;
        }

        /* Checkbox and Radio Styling */
        input[type="checkbox"],
        input[type="radio"] {
            margin-right: 5px;
        }
        /* Button Styling */
        button[type="submit"] {
            display: block;
            width: 100%;
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
@endsection

@section('content')
        <div>
                <form id="postForm" method="POST" action="{{route('publisher.posts.store')}}">
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
                    <label>Country:</label>
                    <input type="text" id="country" name="country" ><br>
                    @error('country')
                        <strong>{{$message}}<strong>
                    @enderror
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

@endsection

@section('scripts')
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function(){
            // $("#normalOptions, #otherOptions").hide(); // Hide both options initially

          

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

            // $("#web").on('input', function(){
            //     let userInput = $(this).val();
            //     let url = new URL(userInput);
            //     let hostname = url.hostname;
            //     $("#host").val(hostname);
                
            //     $.ajax({
            //         url: "{{route('publisher.posts.store')}}",
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
        });



        // function toggleOptions() {
            //     // Show Normal fields if "Normal" is checked
            //     if ($("#normal").is(":checked")) {
            //         $("#normalOptions").removeClass("hidden");
            //     } else {
            //         $("#normalOptions").addClass("hidden");
            //         $("input[name='normal_gp_li']").prop("checked", false);
            //         $("#normal_gp, #normal_li").addClass("hidden").val('');
            //     }

            //     // Show Other fields if "Other" is checked
            //     if ($("#other").is(":checked")) {
            //         $("#otherOptions").removeClass("hidden");
            //     } else {
            //         $("#otherOptions").addClass("hidden");
            //         $("input[name='other_li_gp']").prop("checked", false);
            //         $("#other_gp, #other_li").addClass("hidden").val('');
            //     }
            // }

            // // Listen for changes on Normal & Other checkboxes
            // $("#normal, #other").change(toggleOptions);

            // // Normal GP/LI selection logic
            // $("input[name='normal_gp_li']").change(function () {
            //     if ($(this).val() === "normal_gp") {
            //         $("#normal_gp").removeClass("hidden").focus();
            //         $("#normal_li").addClass("hidden").val('');
            //     } else if ($(this).val() === "normal_li") {
            //         $("#normal_li").removeClass("hidden").focus();
            //         $("#normal_gp").addClass("hidden").val('');
            //     }
            // });

            // // Other GP/LI selection logic
            // $("input[name='other_li_gp']").change(function () {
            //     if ($(this).val() === "other_gp") {
            //         $("#other_gp").removeClass("hidden").focus();
            //         $("#other_li").addClass("hidden").val('');
            //     } else if ($(this).val() === "other_li") {
            //         $("#other_li").removeClass("hidden").focus();
            //         $("#other_gp").addClass("hidden").val('');
            //     }
            // });

            // // Ensure only one price is entered per category
            // $("#normal_gp").on("input", function () { if ($(this).val() !== "") $("#normal_li").val(""); });
            // $("#normal_li").on("input", function () { if ($(this).val() !== "") $("#normal_gp").val(""); });

            // $("#other_gp").on("input", function () { if ($(this).val() !== "") $("#other_li").val(""); });
            // $("#other_li").on("input", function () { if ($(this).val() !== "") $("#other_gp").val(""); });



    </script>

@endsection
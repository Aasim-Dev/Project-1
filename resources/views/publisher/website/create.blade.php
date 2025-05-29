@extends('layouts.publisher')

@section('title', 'Create-POST')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        /* Apply Bootstrap styles */
        .error{
            color:red;
        }
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }

        /* Form Styling */
        form {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: all 0.3s;
        }

        input:focus, select:focus {
            border-color: #007bff;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
        }

        /* Button Styling */
        button {
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
            margin-top: 15px;
        }

        button:hover {
            background: #0056b3;
        }

        /* Dropdown Styling */
        .select2-container {
            width: 100% !important;
        }

        .TaT {
            width: 100% !important;
            appearance: none;
        }

        /* Prevent Dropdown Overflow */
        .select2-dropdown {
            position: absolute !important;
            z-index: 9999 !important;
            width: auto !important;
            min-width: 100% !important;
        }

        /* Error Message Styling */
        .validation-error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            form {
                padding: 15px;
            }
        }
    </style>
    
@endsection

@section('content')
        <div>
                <form id="websiteForm" method="POST" action="{{route('website.store')}}">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <label>Website Url:</label>
                    <input type="text" id="web" name="website_url" ><br>
                    @error('website_url')
                        <span role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                    <label></label>
                    <input type="hidden" id="host" name="host_url" >
                    @error('host_url')
                        <span style="color:'red';" role="alert">
                            <strong style="color:'red';">{{$message}}</strong>
                        </span>
                    @enderror
                    <label>DA:</label>
                    <input type="text" id="da" name="da" ><br>
                    @error('da')
                        <span role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                    <label>Sample Post:</label>
                    <input type="text" id="sample" name="sample_post" ><br>
                    @error('sample_post')
                        <strong>{{$message}}</strong>
                    @enderror
                    <label>AHREF Traffic:</label>
                    <input type="number" id="ahref" name="ahref_traffic" ><br>
                    <label>TaT:</label>
                    <select class="TaT" name="TaT" id="TaT">
                    @for ($i = 1; $i <= 15; $i++)
                        <option value="{{ $i }} days">{{ $i }} {{ $i == 1 ? 'Day' : 'Days' }}</option>
                    @endfor
                    </select>
                    <label>Country:</label>
                    <input type="text" id="country" name="country" ><br>
                    @error('country')
                        <strong>{{$message}}</strong>
                    @enderror
                    <div class="container-wrapper">
                        <label>Normal Categories:</label>
                        <select class="category-select" name="catenormal" multiple>
                            @foreach ($normalCategories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <div class="price-inputs" id="normalPriceInputs" name="normalPrice" style="display: none;">
                            <h4>Normal Category Prices</h4>
                            <label>GP Price: <input type="number" id="normalGpPrice" name="normalGpPrice" placeholder="Enter GP Price"></label>
                            <label>LI Price: <input type="number" id="normalLiPrice" name="normalLiPrice" placeholder="Enter LI Price"></label>
                        </div>
                    </div>

                    <div class="container-wrapper">
                        <label>Other Categories:</label>
                        <select class="category-select" name="othercate" multiple>
                            @foreach ($otherCategories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <div class="price-inputs" id="otherPriceInputs" name="otherPrice" style="display: none;">
                            <h4>Other Category Prices</h4>
                            <label>GP Price: <input type="number" id="otherGpPrice" name="otherGpPrice" placeholder="Enter GP Price"></label>
                            <label>LI Price: <input type="number" id="otherLiPrice" name="otherLiPrice" placeholder="Enter LI Price"></label>
                        </div>
                    </div>
                   
                    <button type="submit" id="submit" >Submit</button>
                </form>
            </div>
            

@endsection

@section('scripts')
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function(){
            $.validator.addMethod("ValidURL", function(value, element){
                return this.optional(element) || !/https?:\/\/[a-zA-Z0-9.-]+(\.com|\.in|\.au)\/.+$/.test(value);
            }, "The website is not valid.");
            $.validator.addMethod("categoryRequired", function (value, element) {
                return $(".category-select").filter(function () {
                    return $(this).val() !== null && $(this).val().length > 0;
                }).length > 0; 
            }, "Please select at least one category");

            $.validator.addMethod("oneField", function(value, element){
                var gpPrice = $("#normalGpPrice").val();
                var liPrice = $("#normalLiPrice").val();
                return gpPrice.trim() !== ""  || liPrice.trim() !== ""; 
            }, "Please Enter Atleast One Price Field");
            $.validator.addMethod("oneFieldSelect", function(value, element){
                var gpPrice = $("#otherGpPrice").val();
                var liPrice = $("#otherLiPrice").val();
                return gpPrice.trim() !== ""  || liPrice.trim() !== ""; 
            }, "Please Enter Atleast One Price Field");
            $("#websiteForm").validate({
                rules: {
                    catenormal: {
                        categoryRequired: true,
                    },
                    othercate: {
                        categoryRequired: true,
                    },
                    website_url: {
                        required: true,
                        url: true,
                        ValidURL: true,
                    },
                    da: {
                        required: true,
                        number: true,
                        min: 1,
                        max:100,
                    },
                    sample_post: {
                        required: true,
                        url: true
                    },
                    TaT:{
                        required: true,
                    },
                    country: {
                        required: true,
                        minlength: 2
                    },
                    normalGpPrice: {
                        oneField: true,
                        number: true,
                        min: 1
                    },
                    normalLiPrice: {
                        oneField: true,
                        number: true,
                        min: 1
                    },
                    otherGpPrice: {
                        oneFieldSelect: true,
                        number: true,
                        min: 1
                    },
                    otherLiPrice: {
                        oneFieldSelect: true,
                        number: true,
                        min: 1
                    }
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") === "catenormal" || element.attr("name") === "othercate") {
                        if (element.next(".validation-error").length === 0) {
                            element.after('<div class="validation-error text-danger mt-1"></div>');
                        }
                        element.next(".validation-error").html(error);
                    } else {
                        error.insertAfter(element);
                    }
                    if (element.attr("name") === "normalGpPrice" || element.attr("name") === "normalLiPrice") {
                        if ($("#normalPriceInputs .validation-error").length === 0) {
                            $("#normalPriceInputs").append('<div class="validation-error text-danger mt-1"></div>');
                        }
                        $("#normalPriceInputs .validation-error").html(error);
                    }
                    // 🔸 Other Category error placement
                    else if (element.attr("name") === "otherGpPrice" || element.attr("name") === "otherLiPrice") {
                        if ($("#otherPriceInputs .validation-error").length === 0) {
                            $("#otherPriceInputs").append('<div class="validation-error text-danger mt-1"></div>');
                        }
                        $("#otherPriceInputs .validation-error").html(error);
                    } else {
                        error.insertAfter(element);
                    }
                },
                
            });
            
            $("#otherGpPrice, #otherLiPrice").on("input", function () {
                $("#otherGpPrice").valid(); // Trigger validation on either input to update the state
                $("#otherLiPrice").valid();
            });
            $("#normalGpPrice, #normalLiPrice").on("input", function () {
                $("#normalGpPrice").valid(); // Trigger validation on either input to update the state
                $("#normalLiPrice").valid();
            });

            // $("#normalOptions, #otherOptions").hide(); // Hide both options initially
            $(".category-select").select2({
                placeholder: "Select categories",
                allowClear: true,
                closeOnSelect: false
            });

            // Show price inputs only if a category is selected
            $(".category-select").on("select2:select select2:unselect change", function () {
                let selectedValues = $(this).val();
                console.log("Selected Categories:", selectedValues); // Debugging

                let $container = $(this).closest(".container-wrapper");
                let $priceInputs = $container.find(".price-inputs");

                if (selectedValues && selectedValues.length > 0) {
                    $(this).next(".validation-error").remove(); 
                    $priceInputs.show();
                } else {
                    $priceInputs.hide();
                }
                $("#postForm").valid();
            });
        });
    </script>

@endsection
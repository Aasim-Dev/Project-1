@extends('layouts.publisher')

@section('title', 'Create-POST')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Form Container */
        form {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }

        label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 0px 6px rgba(0, 123, 255, 0.3);
        }

        /* Select2 Custom Styling */
        .select2-container .select2-selection--multiple {
            border-radius: 8px;
            border: 1px solid #ccc;
            min-height: 40px;
            padding: 5px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            padding: 3px 8px;
            margin-top: 5px;
        }

        /* Price Input Section */
        .price-inputs {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            display: none;
        }

        .price-inputs h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .price-inputs input {
            width: calc(50% - 5px);
            display: inline-block;
        }

        /* Button Styles */
        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background: #0056b3;
        }

        /* Error Messages */
        span[role="alert"] {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            form {
                max-width: 100%;
            }
            .price-inputs input {
                width: 100%;
                display: block;
                margin-bottom: 10px;
            }
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
                    <input type="number" id="da" name="da" ><br>
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
                    <label>Country:</label>
                    <input type="text" id="country" name="country" ><br>
                    @error('country')
                        <strong>{{$message}}</strong>
                    @enderror
                    <div class="container-wrapper">
                        <label>Normal Categories:</label>
                        <select class="category-select" multiple>
                            @foreach ($normalCategories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <div class="price-inputs" id="normalPriceInputs" style="display: none;">
                            <h3>Normal Category Prices</h3>
                            <label>GP Price: <input type="number" id="normalGpPrice" name="normalGpPrice" placeholder="Enter GP Price"></label>
                            <label>LI Price: <input type="number" id="normalLiPrice" name="normalLiPrice" placeholder="Enter LI Price"></label>
                        </div>
                    </div>

                    <div class="container-wrapper">
                        <label>Other Categories:</label>
                        <select class="category-select" multiple>
                            @foreach ($otherCategories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <div class="price-inputs" id="otherPriceInputs" style="display: none;">
                            <h3>Other Category Prices</h3>
                            <label>GP Price: <input type="number" id="otherGpPrice" name="otherGpPrice" placeholder="Enter GP Price"></label>
                            <label>LI Price: <input type="number" id="otherLiPrice" name="otherLiPrice" placeholder="Enter LI Price"></label>
                        </div>
                    </div>

                    <button type="submit" id="submit">Submit</button>
                </form>
        </div>

@endsection

@section('scripts')
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            // $("#normalOptions, #otherOptions").hide(); // Hide both options initially
            $(".category-select").select2({
                placeholder: "Select categories",
                allowClear: true
            });

            // Show price inputs only if a category is selected
            $(".category-select").on("change", function () {
                let selectedValues = $(this).val();
                console.log("Selected Categories:", selectedValues); // Debugging

                let $container = $(this).closest(".container-wrapper");
                let $priceInputs = $container.find(".price-inputs");

                if (selectedValues && selectedValues.length > 0) {
                    $priceInputs.show();
                } else {
                    $priceInputs.hide();
                }
            });
        });
    </script>

@endsection
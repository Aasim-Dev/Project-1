@extends('layouts.advertiser')

@section('title', 'BLS Tool')

@section('styles')
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 720px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        form label {
            font-weight: 600;
            display: block;
            margin-bottom: 0.5rem;
        }

        #url-check {
            width: 100%;
            resize: vertical;
        }

        #error-msg {
            color: #dc3545;
            margin-top: 0.5rem;
        }

        #sbumit-btn {
            margin-top: 1rem;
            background-color: #007bff;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        #sbumit-btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 35%;
            margin-top: 2rem;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        table th,
        table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
        }

        table th {
            background-color: #f1f1f1;
            text-align: left;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
@endsection

@section('content')

<div class="container">
    <form id="my-form">
    @csrf
        <label for="url">Enter your URL's:</label>
        <textarea name="url_check" id="url-check" rows="15" class="form-control" autofocus></textarea>
        <p id="error-msg"></p>
        <button type="submit" id="sbumit-btn">Submit</button>
    </form>
</div>

<div>
    @if(!empty($checkers))
    <table>
        <tr>
            <th>Checked</th>
            <th>URL</th>
        </tr>
        @foreach($checkers as $check)
        <tr>
            <td>{{($check->checked == 1) ? 'Checked' : 'unCheck' }}</td>
            <td>{{$check->url}}</td>
        </tr>
        @endforeach
    </table>
    @endif
</div>

@endsection

@section('scripts')
    <script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            function normalizeUrl(url){
                url = url.trim().toLowerCase();
                url = url.replace(/^https?:\/\//, '');
                url = url.replace(/^www\./, '');
                url = url.replace(/\/+$/, '');
                return url;
            }
            $("#my-form").validate({
                rules: {
                    url_check: {
                        required: true,
                        minlength: 1
                    }
                },
                messages: {
                    url_check: {
                        required: "Please enter at least one URL.",
                        minlength: "Please enter at least one URL."
                    }
                },
                errorPlacement: function(error, element) {
                    error.appendTo('#error-msg');
                }
            });
            $('#my-form').on('submit', function(e) {
                e.preventDefault();
                let input = $('#url-check').val();
                let regex = /^(https?:\/\/)?(www\.)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(:\d+)?(\/[^\s]*)?$/;
                if(input == '' || input.trim() == '' || input.split(/[\r\n,]+/).lenght < 1){
                    $('#error-msg').text("Please enter at least one URL.");
                    return;
                }else if(input != regex){
                    $('#error-msg').text("Please enter valid URLs.");
                    return;
                }else{
                    $('#error-msg').text("");
                    return;
                }
                let rawUrlsCheck = input.split(/[\r\n,]+/); 
                let trimmedUrls = rawUrlsCheck.map(url => url.trim()).filter(url => url.length > 0);

                let normalizedSet = new Set();
                let normalizedUrlCheck = [];
                let hasDuplicate = false;

                for(let url of trimmedUrls){
                    let normalized = normalizeUrl(url);
                    if(normalizedSet.has(normalized)){
                        hasDuplicate = true;
                        break;
                    }
                    normalizedSet.add(normalized);
                    normalizedUrlCheck.push(normalized);
                }

                if (hasDuplicate) {
                    $('#error-msg').text("Duplicate URLs detected in your submission.");
                } else {
                    $('#error-msg').text("");
                    $.ajax({
                        url: "{{route('urlCheck.save')}}",
                        type: "POST",
                        data: {
                            urls: normalizedUrlCheck,
                        },
                        success: function(response){
                            if(response.status == 'success'){
                                $("#my-form").trigger('reset');
                            }
                        },
                    });
                }
            });
        });
    </script>
@endsection
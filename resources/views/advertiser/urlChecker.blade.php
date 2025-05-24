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
        <label for="url">Enter your URL's:</label>
        <textarea name="url_check" id="url-check" rows="15" class="form-control" autofocus></textarea>
        <p id="error-msg"></p>
        <button type="submit" id="sbumit-btn">Submit</button>
    </form>
</div>

<div>
    @if($checker != null && $checker == '')
    <table>
        <tr>
            <th>URL</th>
        </tr>
        @foreach($checker as $check)
        <tr>
            <td>{{$check->url}}</td>
        </tr>
        @endforeach
    </table>
    @elseif($checkers != null && $checkers == '')
    <table>
        <tr>
            <th>URL</th>
        </tr>
        @foreach($checkers as $check)
        <tr>
            <td>{{$check->url}}</td>
        </tr>
        @endforeach
    </table>
    @endif
</div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
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
            $('#my-form').on('submit', function(e) {
                e.preventDefault();
                let input = $('#url-check').val();
                let rawUrlsCheck = input.split(/[\r\n,]+/); // Split on comma or newline
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
                        success: function(){
                            $("my-form").trigger('reset');
                        },
                    });
                }

                $("#my-form").validate({
                    rules: {
                        url_check: {
                            required: true,
                        },
                    },
                });
            });
        });
    </script>
@endsection
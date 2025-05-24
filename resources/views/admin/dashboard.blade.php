@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
    <style>
        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 columns */
            gap: 1.5rem; /* space between boxes */
            padding: 2rem;
            max-width: 1200px;
            margin: auto;
        }

        .dashboard-box {
            background-color:rgb(193, 186, 186);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .dashboard-box:hover {
            transform: translateY(-4px);
        }

        .dashboard-box h2 {
            color: #34495e;
            font-size: 1.4rem;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .dashboard-box ul {
            list-style-type: none;
            padding-left: 0;
        }

        .dashboard-box li {
            background-color: #f2f6fa;
            margin-bottom: 8px;
            padding: 10px;
            border-radius: 6px;
            color: #2c3e50;
            font-size: 0.95rem;
        }

        @media (max-width: 992px) {
            .dashboard-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-container">   
        <div class ="dashboard-box">
            <a href="{{route('categories.list')}}"><h2>Categories ({{$categories->count()}}): </h2>
                <!-- <ul>
                    @foreach($categories as $category)
                        <li>Other Category:{{ $category->type == 'other' && $category->type !== ''}}</li>
                    @endforeach
                </ul> -->
            </a>
        </div>
        <div class ="dashboard-box">
            <a href="{{route('post.index')}}"><h2>Websites ({{$websites->count()}}): </h2>
                <!-- <ul>
                    @foreach($websites as $website)
                        <li>{{ $website->website_url }}</li>
                    @endforeach
                </ul> -->
            </a>
        </div>
        <div class ="dashboard-box">
            <a href="{{route('order.list')}}"><h2>Orders ({{$orders->count()}}):</h2>
            </a>
        </div>
        <div class ="dashboard-box">
            <h2>Users ({{$users->count()}}):</h2>
            <!-- <ul>
                @foreach($users as $user)
                    <li>{{ $user->name }}</li>
                @endforeach
            </ul> -->
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
@endsection
 
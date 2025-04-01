@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <h2>Hello, How are you </h2>
                <p>Congratss!<p>
                <div class="card-body">
                    @if (session('status'))
                        
                        <div class="alert alert-success" role="alert">
                            
                            {{ session('status') }}

                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

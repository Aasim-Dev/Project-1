@extends('layouts.admin')

@section('title', 'Dashboard')


    <!-- <div class="container">
        <h2>Welcome to the Admin Dashboard</h2>
        <p>Manage your website content here.</p>
    </div> -->





<!-- 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style> -->

    <!-- 
    

</head>
<body>  -->
@section('content')
    <h1>Welcome to Admin DashBoard</h1>
    <!-- <button id="addCategory">Add Categories from Here</button>
    <div class="overlay">
        <div class="modal">
            <h2 id="modalTitle">Add Categories</h2>
            <form method="POST" id="catForm" action="{{ route('admin.category.store') }}">
                @csrf
                <input type="hidden" id="id" name="id" class="id" value="">
                <label>Name:</label>
                <input type="text" id="name" name="name" required>
                <label>Tag:</label>
                <input type="text" id="tag" name="tag" required>
                <label>Description:</label>
                <input type="text" id="description" name="description" required>
                <label>Type:</label>
                <select name="type"> <option value="normal"> Normal</option>
                <option value="other"> Other</option> </select>
                <button id="submit" type="submit">Submit</button>
            </form>
        </div>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Tag</th>
            <th>Description</th>
            <th>Type</th>
            <th>Action<th>
        </tr>
           
        <
    </table> -->
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
@endsection
 
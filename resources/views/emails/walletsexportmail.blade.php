<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet Export Data</title>
</head>
<body>
    <div>
        <h2>Total Records:</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Email</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wallets as $wallet)
            <tr>
                <td>{{$wallet->name}}</td>
                <td>{{$wallet->user_type}}</td>
                <td>{{$wallet->email}}</td>
                <td>{{$wallet->description}}</td>
                <td>{{$wallet->amount}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

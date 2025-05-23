<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet Export Data</title>
</head>
<body>
    <div>
        <h2>Hello {{$data->name}},</h2>
        <h4>We are pleased to inform you that the website you added in your cart with this 
            url({{$data->host_url}}). So now the price of this website has been reduced to 
            10%.
            With this now current publishing price of this website is {{($data->guest_post_price) - ($data->guest_post_price * 0.10)}}.
            and the current link insertion price of this website is {{($data->linkinsertion_price) - ($data->linkinsertion_price * 0.10)}}.
            So you can buy now with this link below.
            <a href="{{route('priceUpdateAdv')}}">Buy Now</a>

            Thank you,
            From Team
        </h4>
    </div>
</body>
</html>

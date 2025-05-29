<html>
<head>
    <title>Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 10px;
      color: #333;
    }
    h3 {
      text-align: center;
      margin-bottom: 20px;
    }
    .container {
      display: flex;
      gap: 40px;
      justify-content: center;
      flex-wrap: wrap; /* if screen is narrow, stack vertically */
    }
    .data15, .data30 {
      flex: 1 1 300px; /* grow/shrink with min width 300px */
      border: 1px solid #ddd;
      padding: 15px 20px;
      border-radius: 8px;
      background: #f9f9f9;
      box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
    }
    h4 {
      margin-top: 0;
      border-bottom: 2px solid #007BFF;
      padding-bottom: 5px;
      color: #007BFF;
    }
    p {
      margin: 6px 0;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <h3>All the Reports of the Users on the Website.</h3>
  <div class="container">
    <div class="data15">
      <h4>Last 15 Days Report</h4>
      <p>Total Users Registered: {{$data15['totalUsers']}}</p>
      <p>Total Active Users: {{$data15['activeUsers']}}</p>
      <p>Total inActive Users:{{$data15['inactiveUsers']}}</p>
      <p>Total Advertisers:{{$data15['totalAdvertisers']}}</p>
      <p>Total Advertisers Who Added Funds:{{$data15['wallet']}}</p>
      <p>Total Order Placed:{{$data15['totalOrders']}}</p>
      <p>Total Advertisers Who Placed Order:{{$data15['advertiserplaced']}}</p>
      <p>Total Sites on Which Order Placed:{{$data15['totalWebsitesOrdered']}}</p>
    </div>
    <div class="data30">
      <h4>Last 30 Days Report</h4>
      <p>Total Users Registered: {{$data30['totalUsers']}}</p>
      <p>Total Active Users: {{$data30['activeUsers']}}</p>
      <p>Total inActive Users:{{$data30['inactiveUsers']}}</p>
      <p>Total Advertisers:{{$data30['totalAdvertisers']}}</p>
      <p>Total Advertisers Who Added Funds:{{$data30['wallet']}}</p>
      <p>Total Order Placed:{{$data30['totalOrders']}}</p>
      <p>Total Advertisers Who Placed Order:{{$data30['advertiserplaced']}}</p>
      <p>Total Sites on Which Order Placed:{{$data30['totalWebsitesOrdered']}}</p>
    </div>
  </div>
</body>
</html>

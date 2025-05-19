<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .welcome-text {
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <a href="/logout" class="logout-btn">Logout</a>
    
    <div class="welcome-text">
        <h1>Welcome, <?= session()->get('username') ?>!</h1>
        <p>This is your dashboard.</p>
    </div>
</body>
</html> 
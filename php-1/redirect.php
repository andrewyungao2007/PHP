<?php
session_start();

if (!isset($_SESSION["name"])) {
    header("Location: index.php");
    exit();
}

$name = $_SESSION["name"];
$age = $_SESSION["age"];
$gender = $_SESSION["gender"];
$email = $_SESSION["email"];
$address = $_SESSION["address"];
$contact = $_SESSION["contact"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Information</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        h1 {
            text-align: center;
            color: #28a745;
            margin-bottom: 25px;
        }

        .info {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
        }

        .info p {
            margin: 12px 0;
            color: #333;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 13px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        .back:hover {
            background: #5568d9;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Form Submitted Successfully!</h1>

    <div class="info">
        <p><strong>Full Name:</strong> <?= htmlspecialchars($name) ?></p>
        <p><strong>Age:</strong> <?= htmlspecialchars($age) ?></p>
        <p><strong>Gender:</strong> <?= htmlspecialchars($gender) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($address) ?></p>
        <p><strong>Contact Number:</strong> <?= htmlspecialchars($contact) ?></p>
    </div>

    <a class="back" href="index.php">Back to Form</a>

</div>

</body>
</html>
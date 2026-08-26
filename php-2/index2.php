<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = "Registration successful! You can now login.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My Website</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f9;
            color: #333;
        }

        nav {
            background: #667eea;
            padding: 20px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        h1 {
            text-align: center;
            color: #667eea;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #5568d9;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 7px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<nav>
    <a href="index.php">Home</a>
    <a href="index.php#register">Register</a>
    <a href="index2.php#login">Login</a>
    <a href="index2.php#forgot">Forgot Password</a>
</nav>

<div class="container" id="login">

    <?php if (isset($message)): ?>
        <div class="success">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <h1>Login</h1>

    <form method="POST" action="index2.php#login">

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="Enter your email"
            required
        >

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Enter your password"
            required
        >

        <button type="submit">Login</button>

    </form>

</div>

<div class="container" id="forgot">

    <h1>Forgot Password</h1>

    <p>Enter your email address to reset your password.</p>

    <form method="POST" action="index2.php#forgot">

        <label for="forgot-email">Email Address</label>
        <input
            type="email"
            id="forgot-email"
            name="email"
            placeholder="Enter your email"
            required
        >

        <button type="submit">Reset Password</button>

    </form>

    <div class="links">
        <p>Remember your password?</p>
        <a href="#login">Login</a>
    </div>

</div>

</body>
</html>
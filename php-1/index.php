<?php
$name = $age = $gender = $email = $address = $contact = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $errors["name"] = "Name is required.";
    } else {
        $name = trim($_POST["name"]);
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $errors["name"] = "Name can only contain letters and spaces.";
        }
    }

    if (empty($_POST["age"])) {
        $errors["age"] = "Age is required.";
    } else {
        $age = filter_var($_POST["age"], FILTER_VALIDATE_INT);
        if ($age === false || $age < 1 || $age > 120) {
            $errors["age"] = "Please enter a valid age.";
        }
    }

    if (empty($_POST["gender"])) {
        $errors["gender"] = "Please select your gender.";
    } else {
        $gender = $_POST["gender"];
    }

    if (empty($_POST["email"])) {
        $errors["email"] = "Email is required.";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "Please enter a valid email.";
        }
    }

    if (empty($_POST["address"])) {
        $errors["address"] = "Address is required.";
    } else {
        $address = trim($_POST["address"]);
    }

    if (empty($_POST["contact"])) {
        $errors["contact"] = "Contact number is required.";
    } else {
        $contact = trim($_POST["contact"]);
        if (!preg_match("/^[0-9+\-\s()]{7,20}$/", $contact)) {
            $errors["contact"] = "Please enter a valid contact number.";
        }
    }

    if (empty($errors)) {
        session_start();

        $_SESSION["name"] = $name;
        $_SESSION["age"] = $age;
        $_SESSION["gender"] = $gender;
        $_SESSION["email"] = $email;
        $_SESSION["address"] = $address;
        $_SESSION["contact"] = $contact;

        header("Location: success.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information</title>

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
            color: #333;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .error {
            color: #d93025;
            font-size: 13px;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 25px;
            border: none;
            border-radius: 8px;
            background: #667eea;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #5568d9;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Personal Information Form</h1>

    <form method="POST" action="index.php">

        <label for="name">Full Name</label>
        <input
            type="text"
            id="name"
            name="name"
            placeholder="Enter your full name"
            value="<?= htmlspecialchars($name) ?>"
            required
        >
        <?php if (isset($errors["name"])): ?>
            <div class="error"><?= htmlspecialchars($errors["name"]) ?></div>
        <?php endif; ?>

        <label for="age">Age</label>
        <input
            type="number"
            id="age"
            name="age"
            min="1"
            max="120"
            placeholder="Enter your age"
            value="<?= htmlspecialchars((string)$age) ?>"
            required
        >
        <?php if (isset($errors["age"])): ?>
            <div class="error"><?= htmlspecialchars($errors["age"]) ?></div>
        <?php endif; ?>

        <label for="gender">Gender</label>
        <select id="gender" name="gender" required>
            <option value="">-- Select Gender --</option>
            <option value="Male" <?= $gender === "Male" ? "selected" : "" ?>>Male</option>
            <option value="Female" <?= $gender === "Female" ? "selected" : "" ?>>Female</option>
            <option value="Other" <?= $gender === "Other" ? "selected" : "" ?>>Other</option>
        </select>

        <?php if (isset($errors["gender"])): ?>
            <div class="error"><?= htmlspecialchars($errors["gender"]) ?></div>
        <?php endif; ?>

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="example@email.com"
            value="<?= htmlspecialchars($email) ?>"
            required
        >
        <?php if (isset($errors["email"])): ?>
            <div class="error"><?= htmlspecialchars($errors["email"]) ?></div>
        <?php endif; ?>

        <label for="address">Address</label>
        <textarea
            id="address"
            name="address"
            placeholder="Enter your complete address"
            required
        ><?= htmlspecialchars($address) ?></textarea>

        <?php if (isset($errors["address"])): ?>
            <div class="error"><?= htmlspecialchars($errors["address"]) ?></div>
        <?php endif; ?>

        <label for="contact">Contact Number</label>
        <input
            type="tel"
            id="contact"
            name="contact"
            placeholder="+63 912 345 6789"
            value="<?= htmlspecialchars($contact) ?>"
            required
        >

        <?php if (isset($errors["contact"])): ?>
            <div class="error"><?= htmlspecialchars($errors["contact"]) ?></div>
        <?php endif; ?>

        <button type="submit">Submit</button>

    </form>

</div>

</body>
</html>
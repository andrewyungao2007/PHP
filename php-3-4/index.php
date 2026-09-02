<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

$message = "";

/* INSERT RECORD */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST["full_name"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $contact_number = $_POST["contact_number"];

    $sql = "INSERT INTO persons
            (full_name, age, gender, email, address, contact_number)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {

        $stmt->bind_param(
            "sissss",
            $full_name,
            $age,
            $gender,
            $email,
            $address,
            $contact_number
        );

        if ($stmt->execute()) {
            $message = "Record successfully registered!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();

    } else {
        $message = "Error preparing statement: " . $conn->error;
    }
}


/* SEARCH / FILTER */
$full_name_filter = $_GET["full_name"] ?? "";
$age_filter = $_GET["age"] ?? "";
$gender_filter = $_GET["gender"] ?? "";
$email_filter = $_GET["email"] ?? "";
$address_filter = $_GET["address"] ?? "";
$contact_filter = $_GET["contact_number"] ?? "";


/* GET RECORDS */
$sql = "SELECT * FROM persons WHERE 1=1";

$params = [];
$types = "";

if ($full_name_filter != "") {
    $sql .= " AND full_name LIKE ?";
    $params[] = "%" . $full_name_filter . "%";
    $types .= "s";
}

if ($age_filter != "") {
    $sql .= " AND age LIKE ?";
    $params[] = "%" . $age_filter . "%";
    $types .= "s";
}

if ($gender_filter != "") {
    $sql .= " AND gender = ?";
    $params[] = $gender_filter;
    $types .= "s";
}

if ($email_filter != "") {
    $sql .= " AND email LIKE ?";
    $params[] = "%" . $email_filter . "%";
    $types .= "s";
}

if ($address_filter != "") {
    $sql .= " AND address LIKE ?";
    $params[] = "%" . $address_filter . "%";
    $types .= "s";
}

if ($contact_filter != "") {
    $sql .= " AND contact_number LIKE ?";
    $params[] = "%" . $contact_filter . "%";
    $types .= "s";
}

$sql .= " ORDER BY id DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Personal Information</title>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(120deg, #607ee8, #7546a8);
    min-height: 100vh;
    padding: 40px;
}


/* FORM */

.form-container {
    width: 520px;
    margin: 20px auto 40px;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.form-container h1 {
    text-align: center;
    color: #263238;
    margin-bottom: 25px;
}

label {
    display: block;
    font-weight: bold;
    margin-top: 12px;
    margin-bottom: 6px;
}

input,
select,
textarea {
    width: 100%;
    padding: 11px;
    border: 1px solid #ccc;
    border-radius: 7px;
    font-size: 14px;
}

textarea {
    height: 80px;
    resize: vertical;
}

button {
    width: 100%;
    padding: 12px;
    margin-top: 18px;
    border: none;
    border-radius: 7px;
    background: #627eea;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background: #506bd2;
}

.success {
    background: #d4edda;
    color: #155724;
    padding: 12px;
    border-radius: 5px;
    margin-bottom: 15px;
    text-align: center;
}


/* REGISTERED PERSON TABLE */

.list-container {
    background: white;
    padding: 20px;
    width: 100%;
    margin: auto;
}

.list-container h1 {
    margin-top: 0;
}

.description {
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    border: 1px solid #333;
    padding: 8px;
    text-align: left;
}

th {
    background: #f5f5f5;
    font-weight: bold;
}

.filter-row input,
.filter-row select {
    width: 100%;
    padding: 7px;
    border-radius: 2px;
    border: 1px solid #999;
}

.filter-button {
    padding: 7px 20px;
    margin: 0;
    background: #eee;
    color: black;
    border: 1px solid #999;
    border-radius: 2px;
}

.top-controls {
    margin-bottom: 10px;
}

.bottom-controls {
    display: flex;
    justify-content: space-between;
    margin-top: 12px;
}

.pagination {
    display: flex;
    gap: 25px;
}

.pagination a {
    color: #666;
    text-decoration: none;
}

.no-data {
    text-align: center;
}

</style>

</head>

<body>


<!-- ================= FORM ================= -->

<div class="form-container">

<h1>Personal Information Form</h1>

<?php if ($message != ""): ?>

<div class="success">
    <?php echo htmlspecialchars($message); ?>
</div>

<?php endif; ?>


<form method="POST" action="">


<label>Full Name</label>

<input
    type="text"
    name="full_name"
    placeholder="Enter your full name"
    required
>


<label>Age</label>

<input
    type="number"
    name="age"
    placeholder="Enter your age"
    required
>


<label>Gender</label>

<select name="gender" required>

<option value="">-- Select Gender --</option>

<option value="Male">Male</option>

<option value="Female">Female</option>

</select>


<label>Email</label>

<input
    type="email"
    name="email"
    placeholder="example@email.com"
    required
>


<label>Address</label>

<textarea
    name="address"
    placeholder="Enter your complete address"
    required
></textarea>


<label>Contact Number</label>

<input
    type="text"
    name="contact_number"
    placeholder="+63 912 345 6789"
    required
>


<button type="submit">
    Submit
</button>

</form>

</div>



<!-- ================= LIST ================= -->

<div class="list-container">

<h1>List of Registered Person</h1>

<p class="description">
This output connects to the database, retrieves data and allows user to filter and search records.
</p>


<div class="top-controls">

Show

<select style="width:60px; padding:5px;">

<option>25</option>

<option>10</option>

<option>50</option>

<option>100</option>

</select>

entries

</div>


<table>

<thead>

<tr>

<th>Full Name</th>

<th>Age</th>

<th>Gender</th>

<th>Email</th>

<th>Address</th>

<th>Contact Number</th>

<th>Action</th>

</tr>


<tr class="filter-row">

<form method="GET">

<td>

<input
    type="text"
    name="full_name"
    value="<?php echo htmlspecialchars($full_name_filter); ?>"
>

</td>


<td>

<input
    type="text"
    name="age"
    value="<?php echo htmlspecialchars($age_filter); ?>"
>

</td>


<td>

<select name="gender">

<option value="">Select All</option>

<option value="Male"
<?php if ($gender_filter == "Male") echo "selected"; ?>>
Male
</option>

<option value="Female"
<?php if ($gender_filter == "Female") echo "selected"; ?>>
Female
</option>

</select>

</td>


<td>

<input
    type="text"
    name="email"
    value="<?php echo htmlspecialchars($email_filter); ?>"
>

</td>


<td>

<input
    type="text"
    name="address"
    value="<?php echo htmlspecialchars($address_filter); ?>"
>

</td>


<td>

<input
    type="text"
    name="contact_number"
    value="<?php echo htmlspecialchars($contact_filter); ?>"
>

</td>


<td>

<button
    type="submit"
    class="filter-button"
>
Filter
</button>

</td>

</form>

</tr>

</thead>


<tbody>

<?php

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

?>

<tr>

<td>
<?php echo htmlspecialchars($row["full_name"]); ?>
</td>

<td>
<?php echo htmlspecialchars($row["age"]); ?>
</td>

<td>
<?php echo htmlspecialchars($row["gender"]); ?>
</td>

<td>
<?php echo htmlspecialchars($row["email"]); ?>
</td>

<td>
<?php echo htmlspecialchars($row["address"]); ?>
</td>

<td>
<?php echo htmlspecialchars($row["contact_number"]); ?>
</td>

<td>
View
</td>

</tr>

<?php

    }

} else {

?>

<tr>

<td colspan="7" class="no-data">
No data available in table
</td>

</tr>

<?php

}

?>

</tbody>

</table>


<div class="bottom-controls">

<div>
Showing <?php echo $result->num_rows; ?> entries
</div>

<div class="pagination">

<a href="#">Previous</a>

<a href="#">Next</a>

</div>

</div>

</div>


</body>

</html>

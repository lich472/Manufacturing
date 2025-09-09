<?php
require_once "inc/dbconn.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="./styles/style_admin.css">
    <script src="./script.js" defer></script>

</head>

<body class="right">
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <h1>Sign Up Page</h1>

        <div>
            <label class="form-label">Username</label>
            <input class="form-input" type="text" name="username">
        </div>

        <div>
            <label class="form-label">Password</label>
            <input class="form-input" type="password" id="password" name="password">
        </div>

        <div>
            <label class="form-label">Work Location</label>
            <input class="form-input" type="text" name="address">
        </div>

        <div>
            <label class="form-label">Date of Birth</label>
            <input class="form-input" type="date" name="dob">
        </div>

        <div>
            <label class="form-label">Phone</label>
            <input class="form-input" type="text" name="phone">
        </div>

        <div>
            <label class="form-label">Role</label>
            <select class="form-input" name="userRole">
                <option>Select...</option>
                <option>Administrator</option>
                <option>Manager</option>
                <option>Operator</option>
                <option>Auditor</option>
            </select>
        </div>
        <br>
        <input type="submit" name="submit" value="Register">
    </form>
    <form action = "login.php">
        <input type="submit" value = "Login">
    </form>
</body>


</html>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS);
    $dob = $_POST["dob"];
    $userRole = $_POST["userRole"];

    if (empty($username)) {
        echo "<p style=\"color: red;margin-top: 10px;\">Please enter a username</p>";
    } elseif (empty($password)) {
        echo "<p style=\"color: red;margin-top: 10px;\">Please enter a password</p>";
    } elseif (empty($address)) {
        echo "<p style=\"color: red;margin-top: 10px;\">Please enter your work location</p>";
    } elseif (empty($phone)) {
        echo "<p style=\"color: red;margin-top: 10px;\">Please enter your phone</p>";   
    } elseif ($userRole == "Select...") {
        echo "<p style=\"color: red;margin-top: 10px;\">Please select a valid user role</p>";
    } else {

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username, password, address, phone, dob, userRole) VALUES ('$username', '$hash_password', '$address', '$phone', '$dob', '$userRole');";
        try{
            mysqli_query($conn, $sql);
            echo "<h3 style=\"margin-top: 10px;\">Thank you $username. Registration complete</h3>";
            header("Location: login.php");
        } catch(mysqli_sql_exception){
            echo "<script>alert(\"That user already exists!\");</script>";
        }

    }

}


mysqli_close($conn);
?>
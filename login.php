<?php
require_once "inc/dbconn.inc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./styles/style_admin.css">
    <script src="./script.js" defer></script>

</head>

<body class="right">
    <h1>Login Page</h1>

    <div>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
            <div>
                <label>Username</label><input type="text" name="username">
            </div>
            <div>
                <label>Password</label><input class="form-input" type="password" id="password" name="password">
            </div>
    </div>
    <div>
        <input type="submit" name="submit" value="Login">
    </div>
    </form>

    <form action = "registration.php">
        <input type="submit" value = "Register">
    </form>
</body>

</html>
<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($username)) {
            echo "<p style=\"color: red;margin-top: 10px;\">Please enter username</p>";
        } elseif (empty($password)) {
            echo "<p style=\"color: red;margin-top: 10px;\">Please enter password</p>";
        } else {
            $sql = "SELECT * FROM users WHERE username = '$username';";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row["password"])) {
                    if($row["userRole"] == "Administrator"){
                        header("Location: index_admin.php");
                        exit();
                    }elseif($row["userRole"] == "Manager"){
                        header("Location: ManagerDashboard.html");
                        exit();
                    }elseif($row["userRole"] == "Operator"){
                        header("Location: OperatorDashboard.html");
                        exit();
                    }elseif($row["userRole"] == "Auditor"){
                        header("Location: AuditorDashboard.html");
                        exit();
                    }
                } else {
                    echo "<p style=\"color: red;margin-top: 10px;\">Password incorrect</p>";
                }
            }else{
                echo "<p style=\"color: red;margin-top: 10px;\">User does not exist</p>";
            }
        }
    }

    mysqli_close($conn);
?>
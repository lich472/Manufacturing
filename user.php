<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Fan: nguy1549" />
    <title>Users</title>
    <link rel="stylesheet" href="./styles/style_admin.css">
    <script src="script.js" defer></script>


</head>
<body>
    <header>
        <h1>Manufacturing</h1>
        <nav>
            <ul>
                <ul>
                    <li><a href="index_admin.php">Dashboard</a></li>
                    <li><a href="user.php">Manage Users</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </ul>
        </nav>
    </header>

    <section class="list">
        <?php require_once "inc/menu.inc.php"; ?>
        <h1>Staff Status</h1>    
        
        <?php
        require_once "inc/dbconn.inc.php";

        $sql = "SELECT id, username, phone, address, dob, userRole FROM users;";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo "<ul><p>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<li>" .
                        "Staff ID: " . $row["id"] .
                        " | " . $row["username"] .
                        " | Phone: " . $row["phone"] .
                        " | Address: " . $row["address"] .
                        " | Role: " . $row["userRole"] .
                        " <form method='post' action='delete.php' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this user?\");'>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <button type='submit' class='delete-btn'>Delete</button>
                        </form>" .
                    "</li>";
                }

                echo "</ul></p>";
                mysqli_free_result($result);
            }
        }    
        ?>
    </section>

    <section class="right">
        <form method="post" action="update-all.php">
            <label>Type username:</label>
            <select id="staffID" name="staffID">
                <?php
                require_once "inc/dbconn.inc.php";

                $sql = "SELECT id, username FROM users;";
                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value=\"" . $row["id"] . "\" name=\"" . $row["username"] . "\">" . $row["username"] . "</option>";
                        }
                        // Free up memory consumed by the $result object
                        mysqli_free_result($result);
                    }
                }
                mysqli_close($conn);
                ?>
            </select><br>

            <label>New Role:</label>
            <select class="form-input" name="newRole">
                <option value="" disabled selected>Select...</option>
                <option>Administrator</option>
                <option>Manager</option>
                <option>Worker</option>
            </select> <br>

            <label>New Phone Number:</label>
            <input type="text" name="newNumber" placeholder="Enter a phone number" />

            <label>New Address:</label>
            <input type="text" name="newAddress" placeholder="Enter an address" />

            <input type="submit" value="Submit">
        </form>
    </section>


</body>
</html>





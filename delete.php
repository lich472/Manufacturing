<?php
require_once "inc/dbconn.inc.php";

// Get ID from POST or GET
$id = $_POST['id'] ?? $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM users WHERE id=?";

    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Prepare failed: " . mysqli_error($conn);
    }
}

mysqli_close($conn);

header("Location: user.php");
exit();
?>


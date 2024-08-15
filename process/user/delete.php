<?php
require '../../config/connection.php';


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    $sql = "DELETE FROM `$table_user`
                WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        header('Location: ../../user.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

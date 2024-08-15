<?php
require '../../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $color = isset($_POST['color']) ? $conn->real_escape_string($_POST['color']) : '';

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : '';

        $sql = "UPDATE `$table_cat` SET
                name = '$name',
                color = '$color'
                WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            header('Location: ../../category.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $sql = "INSERT INTO `$table_cat` (name, color) VALUES ('$name', '$color')";

        if ($conn->query($sql) === TRUE) {
            header('Location: ../../category.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>

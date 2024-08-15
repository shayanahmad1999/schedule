<?php
require '../../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $team = isset($_POST['team']) ? $conn->real_escape_string($_POST['team']) : '';

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : '';

        $sql = "UPDATE `$table_user` SET
                name = '$name',
                team = '$team'
                WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            header('Location: ../../user.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $sql = "INSERT INTO `$table_user` (name, team) VALUES ('$name', '$team')";

        if ($conn->query($sql) === TRUE) {
            header('Location: ../../user.php');
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

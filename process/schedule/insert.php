<?php
require '../../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title']) ? $conn->real_escape_string($_POST['title']) : '';
    $user_id = isset($_POST['user_id']) ? (int)$conn->real_escape_string($_POST['user_id']) : 0;
    $cat_id = isset($_POST['cat_id']) ? (int)$conn->real_escape_string($_POST['cat_id']) : 0;    
    $start_date = isset($_POST['start_date']) ? $conn->real_escape_string($_POST['start_date']) : '';
    $end_date = isset($_POST['end_date']) ? $conn->real_escape_string($_POST['end_date']) : '';

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = isset($_POST['id']) ? $conn->real_escape_string($_POST['id']) : '';

        $sql = "UPDATE `$table_sch` SET
                title = '$title',
                user_id = '$user_id',
                cat_id = '$cat_id',
                start_date = '$start_date',
                end_date = '$end_date'
                WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            header('Location: ../../schedule.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $sql = "INSERT INTO `$table_sch` (title, user_id, cat_id, start_date, end_date) VALUES ('$title', '$user_id', '$cat_id', '$start_date', '$end_date')";

        if ($conn->query($sql) === TRUE) {
            header('Location: ../../schedule.php');
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

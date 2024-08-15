<?php

require './config/connection.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title']) ? $conn->real_escape_string($_POST['title']) : '';
    $user_id = isset($_POST['user_id']) ? (int)$conn->real_escape_string($_POST['user_id']) : 0;
    $cat_id = isset($_POST['cat_id']) ? (int)$conn->real_escape_string($_POST['cat_id']) : 0;
    $start_date = isset($_POST['start_date']) ? $conn->real_escape_string($_POST['start_date']) : '';
    $end_date = isset($_POST['end_date']) ? $conn->real_escape_string($_POST['end_date']) : '';

    try {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $id = $conn->real_escape_string($_POST['id']);
            
            $sql = "UPDATE `$table_sch` SET
                title = '$title',
                user_id = '$user_id',
                cat_id = '$cat_id',
                start_date = '$start_date',
                end_date = '$end_date'
                WHERE id = '$id'";

            if ($conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = 'Record updated successfully';
            } else {
                $response['message'] = "Error: " . $conn->error;
            }
        } else {
            $sql = "INSERT INTO `$table_sch` (title, user_id, cat_id, start_date, end_date) VALUES ('$title', '$user_id', '$cat_id', '$start_date', '$end_date')";

            if ($conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = 'Record inserted successfully';
            } else {
                $response['message'] = "Error: " . $conn->error;
            }
        }
    } catch (mysqli_sql_exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    $conn->close();
} else {
    $response['message'] = 'Invalid request.';
}

echo json_encode($response);
?>

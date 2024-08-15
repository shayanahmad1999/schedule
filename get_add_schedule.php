<?php

require './config/connection.php';
header('Content-Type: application/json');

try {
    $sql = "SELECT `$table_sch`.*, `$table_user`.name AS userName, `$table_cat`.name AS catName, `$table_cat`.color AS catColor
    FROM `$table_sch`
    INNER JOIN `$table_user` ON `$table_sch`.user_id = `$table_user`.id
    INNER JOIN `$table_cat` ON `$table_sch`.cat_id = `$table_cat`.id";
    $result = $conn->query($sql);

    $events = [];


    if ($result && $result->num_rows > 0) {
        $records = $result->fetch_all(MYSQLI_ASSOC);
        $events = []; // Initialize the events array

        foreach ($records as $row) {
            // Escape the values to prevent XSS attacks
            $color = htmlspecialchars($row['catColor'], ENT_QUOTES, 'UTF-8');
            $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
            $userName = htmlspecialchars($row['userName'], ENT_QUOTES, 'UTF-8');
            $catName = htmlspecialchars($row['catName'], ENT_QUOTES, 'UTF-8');
            $start = htmlspecialchars($row['start_date'], ENT_QUOTES, 'UTF-8');
            $end = htmlspecialchars($row['end_date'], ENT_QUOTES, 'UTF-8');

            $color = validateColor($color);

            // Construct the event array
            $events[] = [
                'title' => "<p style='background-color: $color; padding:15px;'>$title</p>",
                'userName' => $userName,
                'catName' => $catName,
                'start' => $start,
                'end' => $end
            ];
        }
    } else {
        echo "No records found.";
    }


    echo json_encode($events);
} catch (mysqli_sql_exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}

$conn->close();


function validateColor($color)
{
    // Regex to validate hex color codes (with or without #)
    if (preg_match('/^#([a-fA-F0-9]{3}|[a-fA-F0-9]{6})$/', $color)) {
        return $color;
    }
    // Regex to validate named colors (simplified)
    $namedColors = ['red', 'green', 'blue', 'yellow', 'black', 'white']; // Add more colors as needed
    if (in_array(strtolower($color), $namedColors)) {
        return $color;
    }
    return 'transparent'; // Fallback color
}

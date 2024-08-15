<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/home.css">
    <link rel="stylesheet" href="./assets/css/form.css">
    
    <?php
    if (basename($_SERVER['PHP_SELF']) !== 'adv_schedule.php') {
        ?>
        <link rel="stylesheet" href="./assets/css/table.css">
        <?php
    }
    ?>
    <style>
        #eventModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            width: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            z-index: 1000;
        }
    </style>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <title><?= $GLOBALS['name'] ?> Home</title>
</head>

<body>
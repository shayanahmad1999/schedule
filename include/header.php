<header>
    <h1><?php
        if (isset($_SESSION['ADMINID'])) {
            echo ucwords($_SESSION['ADMINNAME']);
        } else {
            header('location:./index.php?error');
            exit();
        }
        ?></h1>
    <a href="category.php">Category</a>
    <a href="user.php">User</a>
    <a href="schedule.php">Schedule</a>
    <nav>
        <a href="./config/logout.php">Logout</a>
    </nav>
</header>
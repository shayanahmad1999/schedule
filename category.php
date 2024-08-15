<?php
require './config/connection.php';

require_once('./config/security.php');

require './include/head.php';

require './include/header.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT id, name, color FROM `$table_cat` WHERE id = $id";
    $result = $conn->query($sql);
    if($result){
        $data = $result->fetch_assoc();
    }
}

$sql = "SELECT id, name, color FROM `$table_cat`";
$result = $conn->query($sql);
$records = ($result && $result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];

?>

<main>
    <section>
        <form action="process/category/insert.php" method="post">
            <label for="name">Name: </label>
            <input type="text" id="name" name="name" value="<?= isset($data) ? htmlspecialchars($data['name']) : '' ?>" required><br><br>

            <label for="color">Color: </label>
            <input type="color" id="color" name="color" value="<?= isset($data) ? htmlspecialchars($data['color']) : '' ?>" required><br><br>

            <input type="hidden" name="id" value="<?= isset($data) ? htmlspecialchars($data['id']) : ''  ?>">

            <button type="submit">Submit</button>
        </form>
    </section>
    <section>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Color</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (!empty($records)) {

                    foreach ($records as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td style='background-color: " . htmlspecialchars($row['color']) . ";'></td>";
                        echo "<td>
                                    <a href='category.php?id=" . htmlspecialchars($row['id']) . "'>Edit</a> | 
                                    <a href='process/category/delete.php?id=" . htmlspecialchars($row['id']) . "' onclick=\"return confirm('Are you sure?');\">Delete</a>
                                 </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No categories found.</td></tr>";
                }

                $conn->close();

                ?>
            </tbody>
        </table>
    </section>
</main>

<?php require './include/footer.php'; ?>
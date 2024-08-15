<?php
require './config/connection.php';
require_once('./config/security.php');
require './include/head.php';
require './include/header.php';

$data = [];
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT * FROM `$table_sch` WHERE id = $id";
    $result = $conn->query($sql);

    if ($result) {
        $data = $result->fetch_assoc();
    }
}

$sql = "SELECT `$table_sch`.*, `$table_user`.name AS userName, `$table_cat`.name AS catName, `$table_cat`.color AS catcolor
FROM `$table_sch`
INNER JOIN `$table_user` ON `$table_sch`.user_id = `$table_user`.id
INNER JOIN `$table_cat` ON `$table_sch`.cat_id = `$table_cat`.id";


$result = $conn->query($sql);
$records = ($result && $result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];

$sql_user = "SELECT * FROM `$table_user`";
$result_user = $conn->query($sql_user);
$users = ($result_user && $result_user->num_rows > 0) ? $result_user->fetch_all(MYSQLI_ASSOC) : [];

$sql_cat = "SELECT * FROM `$table_cat`";
$result_cat = $conn->query($sql_cat);
$cats = ($result_cat && $result_cat->num_rows > 0) ? $result_cat->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>

<main>
    <section>
        <form action="process/schedule/insert.php" method="post">
            <label for="title">Title: </label>
            <input type="text" id="title" name="title" value="<?= isset($data['title']) ? htmlspecialchars($data['title']) : '' ?>" required><br>

            <label for="user_id">User: </label>
            <select name="user_id" required>
                <option value="">Choose User</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= htmlspecialchars($user['id']) ?>" <?= isset($data['user_id']) && $data['user_id'] == $user['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($user['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="cat_id">Category: </label>
            <select name="cat_id" required>
                <option value="">Choose Category</option>
                <?php foreach ($cats as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['id']) ?>" <?= isset($data['cat_id']) && $data['cat_id'] == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name'])  ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="start_date">Start Date: </label>
            <input type="date" id="start_date" name="start_date" value="<?= isset($data['start_date']) ? htmlspecialchars($data['start_date']) : '' ?>" required><br><br>

            <label for="end_date">End Date: </label>
            <input type="date" id="end_date" name="end_date" value="<?= isset($data['end_date']) ? htmlspecialchars($data['end_date']) : '' ?>" required><br><br>

            <input type="hidden" name="id" value="<?= isset($data['id']) ? htmlspecialchars($data['id']) : '' ?>">

            <button type="submit">Submit</button>
        </form>
    </section>
    <section>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>User</th>
                    <th>Category</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)): ?>
                    <?php foreach ($records as $row): ?>
                        <tr style="background-color: <?= htmlspecialchars($row['catcolor']) ?>;">
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['userName']) ?></td>
                            <td><?= htmlspecialchars($row['catName']) ?></td>
                            <td><?= htmlspecialchars($row['start_date']) ?></td>
                            <td><?= htmlspecialchars($row['end_date']) ?></td>
                            <td>
                                <a href='schedule.php?id=<?= htmlspecialchars($row['id']) ?>'>Edit</a> |
                                <a href='process/schedule/delete.php?id=<?= htmlspecialchars($row['id']) ?>' onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No Schedule found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php require './include/footer.php'; ?>
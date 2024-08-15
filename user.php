<?php
require './config/connection.php';

require_once('./config/security.php');

require './include/head.php';

require './include/header.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT id, name, team FROM `$table_user` WHERE id = $id";
    $result = $conn->query($sql);
    if ($result) {
        $data = $result->fetch_assoc();
    }
}

$sql = "SELECT id, name, team FROM `$table_user`";
$result = $conn->query($sql);
$records = ($result && $result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];

?>

<main>
    <section>
        <form action="process/user/insert.php" method="post">
            <label for="name">Name: </label>
            <input type="text" id="name" name="name" value="<?= isset($data) ? htmlspecialchars($data['name']) : '' ?>" required><br><br>

            <label for="team">Team: </label>
            <input type="text" id="team" name="team" value="<?= isset($data) ? htmlspecialchars($data['team']) : '' ?>" required><br><br>

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
                    <th>Team</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)): ?>
                    <?php foreach ($records as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['team']) ?></td>
                            <td>
                                <a href='user.php?id=<?= htmlspecialchars($row['id']) ?>'>Edit</a> |
                                <a href='process/user/delete.php?id=<?= htmlspecialchars($row['id']) ?>' onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No Users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php require './include/footer.php'; ?>
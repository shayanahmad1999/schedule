<?php

require './config/connection.php';
require_once('./config/security.php');
require './include/head.php';
require './include/header.php';

// Fetch users and categories
$sql_user = "SELECT * FROM `$table_user`";
$result_user = $conn->query($sql_user);
$users = ($result_user && $result_user->num_rows > 0) ? $result_user->fetch_all(MYSQLI_ASSOC) : [];

$sql_cat = "SELECT * FROM `$table_cat`";
$result_cat = $conn->query($sql_cat);
$cats = ($result_cat && $result_cat->num_rows > 0) ? $result_cat->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();

?>
<style>
    .fc-h-event{
        background-color: white;
        border: 0px;
    }
</style>
<div id="calendar"></div>

<!-- Modal -->
<div id="eventModal" style="display:none;">
    <form id="eventForm">
        <label for="title">Title: </label>
        <input type="text" id="title" name="title" value="<?= isset($data['title']) ? htmlspecialchars($data['title']) : '' ?>" required><br>

        <label for="user_id">User: </label>
        <select name="user_id" id="user_id" required>
            <option value="">Choose User</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= htmlspecialchars($user['id']) ?>" <?= isset($data['user_id']) && $data['user_id'] == $user['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="cat_id">Category: </label>
        <select name="cat_id" id="cat_id" required>
            <option value="">Choose Category</option>
            <?php foreach ($cats as $cat): ?>
                <option value="<?= htmlspecialchars($cat['id']) ?>" <?= isset($data['cat_id']) && $data['cat_id'] == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="start_date">Start Date: </label>
        <input type="date" id="start_date" name="start_date" value="<?= isset($data['start_date']) ? htmlspecialchars($data['start_date']) : '' ?>" required><br><br>

        <label for="end_date">End Date: </label>
        <input type="date" id="end_date" name="end_date" value="<?= isset($data['end_date']) ? htmlspecialchars($data['end_date']) : '' ?>" required><br><br>

        <input type="hidden" name="id" value="<?= isset($data['id']) ? htmlspecialchars($data['id']) : '' ?>">

        <button type="submit">Save</button>
        <button type="button" onclick="closeModal()">Cancel</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            events: function(fetchInfo, successCallback, failureCallback) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'get_add_schedule.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            var events = JSON.parse(xhr.responseText);
                            successCallback(events);
                        } catch (e) {
                            console.error("Error parsing JSON:", e);
                        }
                    }
                };

                xhr.send();
            },
            select: function(info) {
                document.getElementById('start_date').value = info.startStr;
                document.getElementById('end_date').value = info.endStr;
                openModal();
            },
            eventContent: function(arg) {
                var title = arg.event.title;
                var element = document.createElement('div');
                element.innerHTML = `${title}`;
                return {
                    domNodes: [element]
                };
            }
        });

        calendar.render();

        document.getElementById('eventForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var title = document.getElementById('title').value;
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'insert_add_schedule.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    closeModal();
                    location.reload(); 
                }
            };
            xhr.send('title=' + encodeURIComponent(title) +
                '&user_id=' + encodeURIComponent(document.getElementById('user_id').value) +
                '&cat_id=' + encodeURIComponent(document.getElementById('cat_id').value) +
                '&start_date=' + encodeURIComponent(startDate) +
                '&end_date=' + encodeURIComponent(endDate));
        });
    });

    function openModal() {
        document.getElementById('eventModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('eventModal').style.display = 'none';
    }
</script>
</body>

</html>
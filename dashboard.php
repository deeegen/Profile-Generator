<?php
$users = get_users();
$user = current(array_filter($users, fn($u) => $u['email'] === $_SESSION['email']));
$preview_url = "?action=preview&user=".urlencode($_SESSION['email']);
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Dashboard</h2>
    <a href="<?= $preview_url ?>" target="_blank">Preview</a>
    <a href="?action=edit">Edit</a>
    <a href="?action=logout">Logout</a>
</body>
</html>

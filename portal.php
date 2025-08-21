<!-- C:\xampp\htdocs\file\portal.php -->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$dbname = "file";
$user = "root";
$password = "";
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $user_id = $_SESSION['user_id'];

    // Get user department
    $dep_sql = "
        SELECT d.name AS department_name 
        FROM user_departments ud 
        JOIN departments d ON ud.department_id = d.id 
        WHERE ud.user_id = ?";
    $dep_stmt = $pdo->prepare($dep_sql);
    $dep_stmt->execute([$user_id]);
    $department = $dep_stmt->fetch();

    // Get user logs
    $logs_sql = "SELECT file_name, file_path, can_read, can_write, timestamp 
                 FROM file_access_logs WHERE user_id = ? ORDER BY timestamp DESC";
    $logs_stmt = $pdo->prepare($logs_sql);
    $logs_stmt->execute([$user_id]);
    $logs = $logs_stmt->fetchAll();

} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head><title>User Portal</title></head>
<body>
<h2>Welcome, <?= htmlspecialchars($_SESSION['email']) ?></h2>
<p>Department: <?= $department ? htmlspecialchars($department['department_name']) : "Not assigned" ?></p>

<h3>Your File Access Logs</h3>
<table border="1">
    <tr><th>File Name</th><th>Path</th><th>Read?</th><th>Write?</th><th>Time</th></tr>
    <?php foreach ($logs as $log): ?>
    <tr>
        <!-- <td><?= htmlspecialchars($log['file_name']) ?></td> -->
         <td>
    <a href="<?= htmlspecialchars($log['file_path']) ?>" target="_blank">
        <?= htmlspecialchars($log['file_name']) ?>
    </a>
</td>

        <td><?= htmlspecialchars($log['file_path']) ?></td>
        <td><?= $log['can_read'] ? '✅' : '❌' ?></td>
        <td><?= $log['can_write'] ? '✅' : '❌' ?></td>
        <td><?= htmlspecialchars($log['timestamp']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<p><a href="logout.php">Logout</a></p>
</body>
</html>

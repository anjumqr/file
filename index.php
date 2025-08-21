<!-- C:\xampp\htdocs\file\index.php -->
<?php
/**
 * Simple PHP website for User, Department, and File Access Management (MySQL).
 *
 * Works with XAMPP/phpMyAdmin (MySQL/MariaDB).
 * Make sure you created the tables in your database before running this.
 *
 * To use:
 * 1. Create database `file` in phpMyAdmin (or update $dbname).
 * 2. Import your CREATE TABLE statements.
 * 3. Save this file as index.php inside XAMPP/htdocs.
 * 4. Open http://localhost/index.php in browser.
 */

// Database connection details
$host = 'localhost'; 
$dbname = 'file'; // your database name
$user = 'root';   // default XAMPP user
$password = '';   // default XAMPP password is empty
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Add User
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $password]);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Add Department
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_department'])) {
        $name = $_POST['name'];

        $sql = "INSERT INTO departments (name) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name]);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Assign User to Department
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign_user'])) {
        $user_id = $_POST['user_id'];
        $department_id = $_POST['department_id'];

        $sql = "INSERT INTO user_departments (user_id, department_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $department_id]);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Log File Access
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log_access'])) {
        $user_id = $_POST['user_id'];
        $file_name = $_POST['file_name'];
        $file_path = $_POST['file_path'];
        $can_read = isset($_POST['can_read']) ? 1 : 0;
        $can_write = isset($_POST['can_write']) ? 1 : 0;

        $sql = "INSERT INTO file_access_logs (user_id, file_name, file_path, can_read, can_write) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $file_name, $file_path, $can_read, $can_write]);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Fetch all users
    $users_sql = "SELECT id, email FROM users ORDER BY created_at DESC";
    $users_stmt = $pdo->query($users_sql);
    $users = $users_stmt->fetchAll();

    // Fetch all departments
    $departments_sql = "SELECT id, name FROM departments ORDER BY id DESC";
    $departments_stmt = $pdo->query($departments_sql);
    $departments = $departments_stmt->fetchAll();

    // Fetch user-department assignments
    $user_deps_sql = "
        SELECT u.email, d.name AS department_name 
        FROM user_departments ud 
        JOIN users u ON ud.user_id = u.id 
        JOIN departments d ON ud.department_id = d.id";
    $user_deps_stmt = $pdo->query($user_deps_sql);
    $user_departments = $user_deps_stmt->fetchAll();

    // Fetch file access logs
    $logs_sql = "
        SELECT u.email, fal.file_name, fal.file_path, fal.timestamp, fal.can_read, fal.can_write 
        FROM file_access_logs fal 
        JOIN users u ON fal.user_id = u.id 
        ORDER BY fal.timestamp DESC";
    $logs_stmt = $pdo->query($logs_sql);
    $logs = $logs_stmt->fetchAll();

} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>File Access Control</title>
<style>
/* (same CSS from your file — no changes) */
</style>
</head>
<body>
    <div class="container">
        <h1>File Access Control System</h1>

        <div class="grid">
            <!-- Add User -->
            <div>
                <h2>Add New User</h2>
                <form action="" method="post">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                    <label>Password:</label>
                    <input type="password" name="password" required>
                    <button type="submit" name="add_user">Add User</button>
                </form>
            </div>

            <!-- Add Department -->
            <div>
                <h2>Add New Department</h2>
                <form action="" method="post">
                    <label>Department Name:</label>
                    <input type="text" name="name" required>
                    <button type="submit" name="add_department">Add Department</button>
                </form>
            </div>
        </div>

        <!-- Assign User -->
        <h2>Assign User to Department</h2>
        <form action="" method="post">
            <label>User:</label>
            <select name="user_id" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= htmlspecialchars($user['id']); ?>"><?= htmlspecialchars($user['email']); ?></option>
                <?php endforeach; ?>
            </select>
            <label>Department:</label>
            <select name="department_id" required>
                <?php foreach ($departments as $department): ?>
                    <option value="<?= htmlspecialchars($department['id']); ?>"><?= htmlspecialchars($department['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="assign_user">Assign User</button>
        </form>

        <!-- Log File Access -->
        <h2>Log File Access Attempt</h2>
        <form action="" method="post">
            <label>User:</label>
            <select name="user_id" required>
                <?php foreach ($users as $user): ?>
                    <option value="<?= htmlspecialchars($user['id']); ?>"><?= htmlspecialchars($user['email']); ?></option>
                <?php endforeach; ?>
            </select>
            <label>File Name:</label>
            <input type="text" name="file_name" required>
            <label>File Path:</label>
            <input type="text" name="file_path" required>
            <label><input type="checkbox" name="can_read"> Can Read</label>
            <label><input type="checkbox" name="can_write"> Can Write</label>
            <button type="submit" name="log_access">Log Access</button>
        </form>

        <!-- Display Users -->
        <h2>Existing Users</h2>
        <table>
            <tr><th>Email</th><th>User ID</th></tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><?= htmlspecialchars($user['id']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Display Departments -->
        <h2>Existing Departments</h2>
        <table>
            <tr><th>Department Name</th></tr>
            <?php foreach ($departments as $department): ?>
                <tr><td><?= htmlspecialchars($department['name']); ?></td></tr>
            <?php endforeach; ?>
        </table>

        <!-- Display User-Department -->
        <h2>User-Department Assignments</h2>
        <table>
            <tr><th>User Email</th><th>Department</th></tr>
            <?php foreach ($user_departments as $assignment): ?>
                <tr>
                    <td><?= htmlspecialchars($assignment['email']); ?></td>
                    <td><?= htmlspecialchars($assignment['department_name']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Display File Logs -->
        <h2>File Access Logs</h2>
        <table>
            <tr><th>User</th><th>File</th><th>Path</th><th>Read?</th><th>Write?</th><th>Time</th></tr>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log['email']); ?></td>
                    <!-- <td><?= htmlspecialchars($log['file_name']); ?></td> -->
                      <td>
    <a href="<?= htmlspecialchars($log['file_path']) ?>" target="_blank">
        <?= htmlspecialchars($log['file_name']) ?>
    </a>
</td>

                    <td><?= htmlspecialchars($log['file_path']); ?></td>
                    <td><?= $log['can_read'] ? '✅' : '❌'; ?></td>
                    <td><?= $log['can_write'] ? '✅' : '❌'; ?></td>
                    <td><?= htmlspecialchars($log['timestamp']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
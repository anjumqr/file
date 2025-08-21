<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$host = "localhost";
$dbname = "file";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Get total users
    $users_sql = "SELECT COUNT(*) as count FROM users";
    $users_stmt = $pdo->query($users_sql);
    $users_count = $users_stmt->fetch()['count'];

    // Get total departments
    $dept_sql = "SELECT COUNT(*) as count FROM departments";
    $dept_stmt = $pdo->query($dept_sql);
    $dept_count = $dept_stmt->fetch()['count'];

    // Get today's logs
    $today_logs_sql = "SELECT COUNT(*) as count FROM file_access_logs 
                       WHERE DATE(timestamp) = CURDATE()";
    $today_logs_stmt = $pdo->query($today_logs_sql);
    $today_logs_count = $today_logs_stmt->fetch()['count'];

    // Get total files (unique file names)
    $files_sql = "SELECT COUNT(DISTINCT file_name) as count FROM file_access_logs";
    $files_stmt = $pdo->query($files_sql);
    $files_count = $files_stmt->fetch()['count'];

    // Get access data for the chart (last 7 days)
    $chart_sql = "SELECT DATE(timestamp) as date, 
                         COUNT(*) as total_access,
                         SUM(can_read = 1 OR can_write = 1) as allowed_access,
                         SUM(can_read = 0 AND can_write = 0) as denied_access
                  FROM file_access_logs 
                  WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                  GROUP BY DATE(timestamp)
                  ORDER BY date";
    
    $chart_stmt = $pdo->query($chart_sql);
    $chart_data = $chart_stmt->fetchAll();

    echo json_encode([
        'users_count' => $users_count,
        'dept_count' => $dept_count,
        'today_logs_count' => $today_logs_count,
        'files_count' => $files_count,
        'chart_data' => $chart_data
    ]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
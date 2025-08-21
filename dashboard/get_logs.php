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

    // Get logs with user email and formatted timestamp
    $sql = "SELECT u.email, fal.file_name, fal.file_path, 
                   DATE_FORMAT(fal.timestamp, '%Y-%m-%d %H:%i:%s') as timestamp, 
                   fal.can_read, fal.can_write 
            FROM file_access_logs fal 
            JOIN users u ON fal.user_id = u.id 
            ORDER BY fal.timestamp DESC 
            LIMIT 50";
    
    $stmt = $pdo->query($sql);
    $logs = $stmt->fetchAll();

    echo json_encode($logs);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
<?php
session_start();
header('Content-Type: application/json');

$host = "localhost";
$dbname = "file";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['email']) || !isset($input['password'])) {
            echo json_encode(['success' => false, 'message' => 'Email and password required']);
            exit;
        }

        $email = $input['email'];
        $password = $input['password'];

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            
            // Get user's department
            $dept_sql = "SELECT d.name FROM user_departments ud 
                         JOIN departments d ON ud.department_id = d.id 
                         WHERE ud.user_id = ?";
            $dept_stmt = $pdo->prepare($dept_sql);
            $dept_stmt->execute([$user['id']]);
            $department = $dept_stmt->fetch();
            // In the success block after password_verify
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_role'] = $user['role_name']; // Store the role name

            echo json_encode([
                'success' => true,
                'user' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'name' => explode('@', $user['email'])[0],
                    'department' => $department ? $department['name'] : 'Not assigned',
                    'role' => $user['role_name'] // Return the actual role
                ]
            ]);
            // echo json_encode([
            //     'success' => true, 
            //     'user' => [
            //         'id' => $user['id'],
            //         'email' => $user['email'],
            //         'name' => explode('@', $user['email'])[0],
            //         'department' => $department ? $department['name'] : 'Not assigned',
            //         'role' => 'Administrator' // You can implement roles later
            //     ]
                
            // ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
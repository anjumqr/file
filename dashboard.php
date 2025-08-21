<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureFile - Advanced Access Control System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #fca311;
            --info: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --sidebar-width: 250px;
            --header-height: 70px;
            --transition: all 0.3s ease;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(to bottom, var(--primary), var(--secondary));
            color: white;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: var(--shadow);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-header h2 i {
            margin-right: 10px;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: var(--transition);
            border-left: 4px solid transparent;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--success);
        }

        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid var(--warning);
        }

        .menu-item i {
            margin-right: 10px;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: var(--transition);
        }

        /* Header */
        .header {
            background-color: white;
            padding: 15px 30px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary);
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background-color: white;
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 1.1rem;
            color: var(--gray);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .card-content {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .card-footer {
            margin-top: 15px;
            font-size: 0.9rem;
            color: var(--info);
            display: flex;
            align-items: center;
        }

        /* Forms */
        .form-section {
            background-color: white;
            border-radius: var(--radius);
            padding: 25px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.4rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-gray);
            color: var(--primary);
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--gray);
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--light-gray);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--light-gray);
            border-radius: var(--radius);
            font-size: 1rem;
            background-color: white;
            cursor: pointer;
        }

        .checkbox-group {
            display: flex;
            gap: 15px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
        }

        .checkbox-item input {
            margin-right: 8px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-success:hover {
            background-color: #3ab7d8;
        }

        /* Tables */
        .table-container {
            background-color: white;
            border-radius: var(--radius);
            padding: 25px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }

        .data-table th {
            background-color: var(--light);
            font-weight: 600;
            color: var(--gray);
        }

        .data-table tr:hover {
            background-color: var(--light-gray);
        }

        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-success {
            background-color: rgba(76, 201, 240, 0.2);
            color: var(--success);
        }

        .badge-danger {
            background-color: rgba(247, 37, 133, 0.2);
            color: var(--danger);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-edit {
            background-color: rgba(72, 149, 239, 0.2);
            color: var(--info);
        }

        .btn-edit:hover {
            background-color: var(--info);
            color: white;
        }

        .btn-delete {
            background-color: rgba(247, 37, 133, 0.2);
            color: var(--danger);
        }

        .btn-delete:hover {
            background-color: var(--danger);
            color: white;
        }

        /* File preview */
        .file-preview {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: var(--light);
            border-radius: var(--radius);
            margin-bottom: 10px;
        }

        .file-icon {
            width: 40px;
            height: 40px;
            background-color: var(--primary);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .file-info {
            flex: 1;
        }

        .file-name {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .file-meta {
            font-size: 0.8rem;
            color: var(--gray);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: visible;
            }
            
            .sidebar-header h2 span,
            .menu-item span {
                display: none;
            }
            
            .menu-item i {
                margin-right: 0;
                font-size: 1.3rem;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-cards {
                grid-template-columns: 1fr;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
        }

        /* Toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--success);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        /* Login page */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            padding: 20px;
        }

        .login-box {
            background-color: white;
            width: 100%;
            max-width: 450px;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .login-header {
            background-color: var(--primary);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 2rem;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-header h1 i {
            margin-right: 15px;
        }

        .login-body {
            padding: 30px;
        }

        .login-footer {
            padding: 20px 30px;
            background-color: var(--light);
            text-align: center;
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animated {
            animation: fadeIn 0.5s ease forwards;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        /* Chart container */
        .chart-container {
            height: 300px;
            margin-top: 20px;
        }

        /* Loading spinner */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: var(--primary);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: var(--radius);
            color: white;
            z-index: 2000;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            background-color: var(--success);
        }

        .notification.error {
            background-color: var(--danger);
        }

        .notification i {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <!-- Login Page -->
    <div class="login-container" id="loginPage">
        <div class="login-box animated">
            <div class="login-header">
                <h1><i class="fas fa-lock"></i> <span>SecureFile Access</span></h1>
                <p>Sign in to your account</p>
            </div>
            <div class="login-body">
                <form id="loginForm">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input" id="loginEmail" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-input" id="loginPassword" placeholder="Enter your password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-sign-in-alt"></i> Sign In
                        </button>
                    </div>
                </form>
            </div>
            <div class="login-footer">
                <p>Don't have an account? Contact your system administrator</p>
            </div>
        </div>
    </div>

    <!-- Main Application -->
    <div class="app-container" id="appContainer" style="display: none;">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-lock"></i> <span>SecureFile</span></h2>
            </div>
            <div class="sidebar-menu">
                <div class="menu-item active" data-section="dashboard">
                    <i class="fas fa-th-large"></i> <span>Dashboard</span>
                </div>
                <div class="menu-item" data-section="users">
                    <i class="fas fa-users"></i> <span>User Management</span>
                </div>
                <div class="menu-item" data-section="departments">
                    <i class="fas fa-building"></i> <span>Departments</span>
                </div>
                <div class="menu-item" data-section="access">
                    <i class="fas fa-key"></i> <span>Access Control</span>
                </div>
                <div class="menu-item" data-section="logs">
                    <i class="fas fa-history"></i> <span>Access Logs</span>
                </div>
                <div class="menu-item" data-section="reports">
                    <i class="fas fa-chart-bar"></i> <span>Reports</span>
                </div>
                <div class="menu-item" data-section="settings">
                    <i class="fas fa-cog"></i> <span>Settings</span>
                </div>
                <div class="menu-item" id="logoutBtn">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1 class="header-title" id="contentTitle">Dashboard</h1>
                <div class="user-info">
                    <div class="user-avatar" id="userAvatar">JD</div>
                    <div>
                        <div id="userName">John Doe</div>
                        <div style="font-size: 0.8rem; color: var(--gray);" id="userRole">Administrator</div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Section -->
            <div class="content-section" id="dashboardSection">
                <div class="dashboard-cards">
                    <div class="card animated">
                        <div class="card-header">
                            <div class="card-title">Total Users</div>
                            <div class="card-icon" style="background-color: rgba(67, 97, 238, 0.2); color: var(--primary);">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="card-content" id="totalUsers">0</div>
                        <div class="card-footer">
                            <i class="fas fa-sync-alt" style="cursor: pointer;" onclick="loadData()"></i> Click to refresh data
                        </div>
                    </div>
                    
                    <div class="card animated delay-1">
                        <div class="card-header">
                            <div class="card-title">Departments</div>
                            <div class="card-icon" style="background-color: rgba(76, 201, 240, 0.2); color: var(--success);">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                        <div class="card-content" id="totalDepartments">0</div>
                        <div class="card-footer">
                            <i class="fas fa-sync-alt" style="cursor: pointer;" onclick="loadData()"></i> Click to refresh data
                        </div>
                    </div>
                    
                    <div class="card animated delay-2">
                        <div class="card-header">
                            <div class="card-title">Access Logs Today</div>
                            <div class="card-icon" style="background-color: rgba(247, 37, 133, 0.2); color: var(--danger);">
                                <i class="fas fa-history"></i>
                            </div>
                        </div>
                        <div class="card-content" id="totalLogsToday">0</div>
                        <div class="card-footer">
                            <i class="fas fa-sync-alt" style="cursor: pointer;" onclick="loadData()"></i> Click to refresh data
                        </div>
                    </div>
                    
                    <div class="card animated delay-3">
                        <div class="card-header">
                            <div class="card-title">Files Secured</div>
                            <div class="card-icon" style="background-color: rgba(252, 163, 17, 0.2); color: var(--warning);">
                                <i class="fas fa-file"></i>
                            </div>
                        </div>
                        <div class="card-content" id="totalFiles">0</div>
                        <div class="card-footer">
                            <i class="fas fa-sync-alt" style="cursor: pointer;" onclick="loadData()"></i> Click to refresh data
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title"><i class="fas fa-chart-line"></i> Recent Activity</h2>
                    <div class="chart-container">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title"><i class="fas fa-clock"></i> Recent Access Logs</h2>
                    <div class="table-container">
                        <div class="spinner" id="logsSpinner"></div>
                        <table class="data-table" id="recentLogsTable" style="display: none;">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>File</th>
                                    <th>Access Type</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="recentLogsBody">
                                <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Users Section -->
            <div class="content-section" id="usersSection" style="display: none;">
                <div class="form-section">
                    <h2 class="section-title"><i class="fas fa-user-plus"></i> Add New User</h2>
                    <form id="addUserForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-input" name="email" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-input" name="password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add User
                        </button>
                    </form>
                </div>

                <div class="form-section">
                    <h2 class="section-title"><i class="fas fa-users"></i> Existing Users</h2>
                    <div class="table-container">
                        <div class="spinner" id="usersSpinner"></div>
                        <table class="data-table" id="usersTable" style="display: none;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="usersBody">
                                <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Other sections would be here but are hidden by default -->
        </div>
    </div>

    <!-- Notification Container -->
    <div id="notificationContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global variables
        let currentUser = null;
        let activityChart = null;

        // DOM Content Loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is already logged in
            const savedUser = localStorage.getItem('currentUser');
            if (savedUser) {
                try {
                    currentUser = JSON.parse(savedUser);
                    showApp();
                } catch (e) {
                    console.error('Error parsing saved user data', e);
                    localStorage.removeItem('currentUser');
                }
            }

            // Set up event listeners
            document.getElementById('loginForm').addEventListener('submit', handleLogin);
            document.getElementById('logoutBtn').addEventListener('click', handleLogout);
            document.getElementById('addUserForm').addEventListener('submit', handleAddUser);
            
            // Set up navigation
            document.querySelectorAll('.menu-item').forEach(item => {
                if (item.id !== 'logoutBtn') {
                    item.addEventListener('click', function() {
                        handleNavigation(this.getAttribute('data-section'));
                    });
                }
            });
        });

        // Handle login
        async function handleLogin(e) {
            e.preventDefault();
            
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            
            try {
                const response = await fetch('login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
                });
                
                const result = await response.text();
                
                if (response.ok) {
                    // In a real app, you would use the response to set user data
                    currentUser = {
                        email: email,
                        name: email.split('@')[0],
                        role: 'Administrator' // This would come from the server in a real app
                    };
                    
                    localStorage.setItem('currentUser', JSON.stringify(currentUser));
                    showApp();
                    showNotification('Login successful!', 'success');
                } else {
                    showNotification('Login failed: ' + result, 'error');
                }
            } catch (error) {
                console.error('Login error:', error);
                showNotification('Network error. Please try again.', 'error');
            }
        }

        // Handle logout
        function handleLogout() {
            currentUser = null;
            localStorage.removeItem('currentUser');
            document.getElementById('appContainer').style.display = 'none';
            document.getElementById('loginPage').style.display = 'flex';
            showNotification('You have been logged out.', 'success');
        }

        // Show main application
        function showApp() {
            document.getElementById('loginPage').style.display = 'none';
            document.getElementById('appContainer').style.display = 'flex';
            
            // Update user info in UI
            if (currentUser) {
                document.getElementById('userName').textContent = currentUser.name;
                document.getElementById('userAvatar').textContent = currentUser.name.charAt(0).toUpperCase();
                document.getElementById('userRole').textContent = currentUser.role;
            }
            
            // Load initial data
            loadData();
        }

        // Load data from server
        async function loadData() {
            await loadDashboardData();
            await loadUsers();
            await loadRecentLogs();
        }

        // Load dashboard data
        async function loadDashboardData() {
            try {
                // In a real app, you would fetch this from your server
                // For demonstration, we're using static data based on your database
                
                // Simulate API call delay
                await new Promise(resolve => setTimeout(resolve, 500));
                
                // These values would come from your server in a real application
                document.getElementById('totalUsers').textContent = '7';
                document.getElementById('totalDepartments').textContent = '12';
                document.getElementById('totalLogsToday').textContent = '4';
                document.getElementById('totalFiles').textContent = '4';
                
                initCharts();
            } catch (error) {
                console.error('Error loading dashboard data:', error);
                showNotification('Error loading dashboard data.', 'error');
            }
        }

        // Load users
        async function loadUsers() {
            const spinner = document.getElementById('usersSpinner');
            const table = document.getElementById('usersTable');
            
            spinner.style.display = 'block';
            table.style.display = 'none';
            
            try {
                // In a real app, you would fetch this from your server
                const response = await fetch('get_users.php');
                const users = await response.json();
                
                const usersBody = document.getElementById('usersBody');
                usersBody.innerHTML = '';
                
                users.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.email}</td>
                        <td>${user.created_at}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-edit" onclick="editUser('${user.id}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-icon btn-delete" onclick="deleteUser('${user.id}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    `;
                    usersBody.appendChild(row);
                });
                
                spinner.style.display = 'none';
                table.style.display = 'table';
            } catch (error) {
                console.error('Error loading users:', error);
                spinner.style.display = 'none';
                showNotification('Error loading users.', 'error');
            }
        }

        // Load recent logs
        async function loadRecentLogs() {
            const spinner = document.getElementById('logsSpinner');
            const table = document.getElementById('recentLogsTable');
            
            spinner.style.display = 'block';
            table.style.display = 'none';
            
            try {
                // In a real app, you would fetch this from your server
                const response = await fetch('get_logs.php');
                const logs = await response.json();
                
                const logsBody = document.getElementById('recentLogsBody');
                logsBody.innerHTML = '';
                
                logs.forEach(log => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${log.email}</td>
                        <td>
                            <a href="${log.file_path}" target="_blank">
                                ${log.file_name}
                            </a>
                        </td>
                        <td>${log.can_read ? 'Read' : ''} ${log.can_write ? 'Write' : ''}</td>
                        <td>${log.timestamp}</td>
                        <td><span class="badge ${log.can_read || log.can_write ? 'badge-success' : 'badge-danger'}">
                            ${log.can_read || log.can_write ? 'Allowed' : 'Denied'}
                        </span></td>
                    `;
                    logsBody.appendChild(row);
                });
                
                spinner.style.display = 'none';
                table.style.display = 'table';
            } catch (error) {
                console.error('Error loading logs:', error);
                spinner.style.display = 'none';
                showNotification('Error loading access logs.', 'error');
            }
        }

        // Handle add user
        async function handleAddUser(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const email = formData.get('email');
            const password = formData.get('password');
            
            try {
                const response = await fetch('add_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&add_user=1`
                });
                
                const result = await response.text();
                
                if (response.ok) {
                    showNotification('User added successfully!', 'success');
                    e.target.reset();
                    loadUsers(); // Refresh the users list
                    loadData(); // Refresh dashboard stats
                } else {
                    showNotification('Error adding user: ' + result, 'error');
                }
            } catch (error) {
                console.error('Error adding user:', error);
                showNotification('Network error. Please try again.', 'error');
            }
        }

        // Handle navigation
        function handleNavigation(section) {
            document.querySelectorAll('.menu-item').forEach(i => i.classList.remove('active'));
            document.querySelector(`.menu-item[data-section="${section}"]`).classList.add('active');
            
            document.getElementById('contentTitle').textContent = document.querySelector(`.menu-item[data-section="${section}"] span`).textContent;
            
            // Hide all sections and show the selected one
            document.querySelectorAll('.content-section').forEach(s => s.style.display = 'none');
            document.getElementById(`${section}Section`).style.display = 'block';
            
            // Load section-specific data
            if (section === 'users') {
                loadUsers();
            } else if (section === 'logs') {
                loadRecentLogs();
            }
        }

        // Initialize charts
        function initCharts() {
            const ctx = document.getElementById('activityChart').getContext('2d');
            
            if (activityChart) {
                activityChart.destroy();
            }
            
            activityChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'File Access',
                        data: [2, 3, 1, 4, 2, 0, 1],
                        borderColor: '#4361ee',
                        tension: 0.3,
                        fill: true,
                        backgroundColor: 'rgba(67, 97, 238, 0.1)'
                    }, {
                        label: 'Access Denied',
                        data: [0, 1, 0, 0, 1, 0, 0],
                        borderColor: '#f72585',
                        tension: 0.3,
                        fill: true,
                        backgroundColor: 'rgba(247, 37, 133, 0.1)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'File Access Activity (Last 7 Days)'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // Show notification
        function showNotification(message, type) {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                ${message}
            `;
            
            container.appendChild(notification);
            
            // Show notification
            setTimeout(() => notification.classList.add('show'), 10);
            
            // Hide after 5 seconds
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Placeholder functions for user actions
        function editUser(userId) {
            showNotification(`Edit function for user ${userId} would open here.`, 'success');
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                showNotification(`Delete function for user ${userId} would execute here.`, 'success');
            }
        }
    </script>
</body>
</html>
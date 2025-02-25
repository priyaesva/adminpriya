<?php
session_start();

// Database connection
$host = "localhost";  // Database host
$user = "root";       // Database username
$pass = "";           // Database password
$dbname = "bus_service_db"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the query to prevent SQL Injection
    $query = "SELECT * FROM admins WHERE username = ? OR email = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $username, $username); // Bind parameters
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if the admin exists
        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            
            // Verify if the password matches
            if ($password == $admin['password']) {
                // Password is correct, start the session
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_email'] = $admin['email'];
                
                // Redirect to the admin dashboard
                header("Location: admin_dashboard.php");
                exit();
            } else {
                // Incorrect password
                $error = "Invalid username or password!";
            }
        } else {
            // Admin does not exist
            $error = "Invalid username or password!";
        }
        
        // Close statement
        $stmt->close();
    } else {
        // Query preparation failed
        $error = "Database query error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- Include Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS for the login page -->
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Login container */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        /* Box for login form */
        .login-box {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header styling */
        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        /* Form input fields */
        .form-group label {
            font-size: 14px;
            color: #333;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Button styling */
        .btn-block {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            border: none;
            font-size: 16px;
        }

        .btn-block:hover {
            background-color: #0056b3;
        }

        /* Alert message */
        .alert-danger {
            font-size: 14px;
            margin-bottom: 15px;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
        }

        /* Mobile responsiveness */
        @media screen and (max-width: 600px) {
            .login-box {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-box">
            <h2>Admin Login</h2>

            <!-- Display error message if any -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="admin_login.php">
                <div class="form-group">
                    <label for="username">Username or Email:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>

    <!-- Include necessary JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

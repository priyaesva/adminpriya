<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); // Redirect to login if not logged in
    exit();
}

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "bus_reservation";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get dashboard stats
$totalBookingsQuery = "SELECT COUNT(*) AS total_bookings FROM bookings";
$totalBookingsResult = $conn->query($totalBookingsQuery);
$totalBookings = ($totalBookingsResult && $totalBookingsResult->num_rows > 0) ? $totalBookingsResult->fetch_assoc()['total_bookings'] : 0;

$totalBusesQuery = "SELECT COUNT(*) AS total_buses FROM buses";
$totalBusesResult = $conn->query($totalBusesQuery);
$totalBuses = ($totalBusesResult && $totalBusesResult->num_rows > 0) ? $totalBusesResult->fetch_assoc()['total_buses'] : 0;

$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = ($totalUsersResult && $totalUsersResult->num_rows > 0) ? $totalUsersResult->fetch_assoc()['total_users'] : 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap 4 CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .sidebar {
            height: 100%;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            padding-left: 20px;
            padding-right: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 0;
            display: block;
        }

        .sidebar a:hover {
            background-color: #575d63;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .card-stats {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            margin-bottom: 30px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-stats .card-body {
            display: flex;
            justify-content: space-between;
        }

        .card-stats h4 {
            margin-bottom: 10px;
        }

        .card-stats .number {
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .navbar {
            background-color: #007bff;
            color: white;
        }

        .navbar a {
            color: white;
        }

        .section-header {
            margin-top: 30px;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <div class="ml-auto">
            <a href="admin_logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Admin Menu</h3>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="admin_dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="manage_buses.php">Bus Management</a>
            </li>
            <li class="nav-item">
                <a href="manage_bookings.php">Booking Management</a>
            </li>
            <li class="nav-item">
                <a href="manage_users.php">User Management</a>
            </li>
            <li class="nav-item">
                <a href="manage_payments.php">Payment Management</a>
            </li>
            <li class="nav-item">
                <a href="reports.php">Reports</a>
            </li>
            <li class="nav-item">
                <a href="admin_profile.php">Profile</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h2>
        <p>Overview of the current system stats.</p>

        <!-- Dashboard Summary -->
        <div class="row">
            <div class="col-md-3">
                <div class="card-stats">
                    <div class="card-body">
                        <div>
                            <h4>Total Bookings</h4>
                            <span class="number"><?php echo $totalBookings; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-stats">
                    <div class="card-body">
                        <div>
                            <h4>Total Buses</h4>
                            <span class="number"><?php echo $totalBuses; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-stats">
                    <div class="card-body">
                        <div>
                            <h4>Total Users</h4>
                            <span class="number"><?php echo $totalUsers; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bus Management Section -->
        <div id="bus-management">
            <h3 class="section-header">Bus Management</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>Add New Bus</h5>
                            <form>
                                <div class="form-group">
                                    <label for="busName">Bus Name</label>
                                    <input type="text" class="form-control" id="busName" placeholder="Enter bus name">
                                </div>
                                <div class="form-group">
                                    <label for="route">Route</label>
                                    <input type="text" class="form-control" id="route" placeholder="Enter route details">
                                </div>
                                <div class="form-group">
                                    <label for="seats">Available Seats</label>
                                    <input type="number" class="form-control" id="seats" placeholder="Enter number of seats">
                                </div>
                                <button type="submit" class="btn btn-primary">Add Bus</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>Existing Buses</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Bus Name</th>
                                        <th>Route</th>
                                        <th>Seats</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Example Bus List -->
                                    <tr>
                                        <td>Bus A</td>
                                        <td>Route 1</td>
                                        <td>30</td>
                                        <td><button class="btn btn-danger">Delete</button></td>
                                    </tr>
                                    <tr>
                                        <td>Bus B</td>
                                        <td>Route 2</td>
                                        <td>50</td>
                                        <td><button class="btn btn-danger">Delete</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Management Section -->
        <div id="booking-management">
            <h3 class="section-header">Booking Management</h3>
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Bus</th>
                                <th>Seat Number</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example Booking List -->
                            <tr>
                                <td>John Doe</td>
                                <td>Bus A</td>
                                <td>5</td>
                                <td>2025-02-25</td>
                                <td>Confirmed</td>
                                <td><button class="btn btn-warning">Cancel</button></td>
                            </tr>
                            <tr>
                                <td>Jane Doe</td>
                                <td>Bus B</td>
                                <td>12</td>
                                <td>2025-02-26</td>
                                <td>Pending</td>
                                <td><button class="btn btn-warning">Cancel</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- User Management Section -->
        <div id="user-management">
            <h3 class="section-header">User Management</h3>
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example User List -->
                            <tr>
                                <td>John Doe</td>
                                <td>johndoe@example.com</td>
                                <td>Active</td>
                                <td><button class="btn btn-danger">Deactivate</button></td>
                            </tr>
                            <tr>
                                <td>Jane Doe</td>
                                <td>janedoe@example.com</td>
                                <td>Active</td>
                                <td><button class="btn btn-danger">Deactivate</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Reports Section -->
        <div id="reports">
            <h3 class="section-header">Reports</h3>
            <p>Generate and view various reports related to bookings, earnings, and more.</p>
            <!-- Placeholder for Reports -->
        </div>

    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

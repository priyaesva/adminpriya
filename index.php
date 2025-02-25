<?php
// Include header and database connection
include('header.php');
include('db_connection.php');  // Make sure to include your DB connection here

// Fetch available routes (departure, destination)
$sqlRoutes = "SELECT DISTINCT departure, destination FROM buses";
$resultRoutes = $conn->query($sqlRoutes);
?>

<!-- Welcome Quotes with Transition -->
<div class="welcome-container text-center mt-5" id="welcome-container">
    <h1>Welcome to Your Next Journey!</h1>
    <p>Explore the beauty of Tamil Nadu with us. Safe, reliable, and comfortable.</p>
</div>

<!-- Bus Search Form -->
<div class="container mt-5">
    <form id="busSearchForm" action="available_buses.php" method="GET">
        <div class="row justify-content-center">
            <!-- Departure Dropdown -->
            <div class="col-md-3 mb-3">
                <select class="form-control" name="departure" required>
                    <option value="">Select Departure</option>
                    <option value="Tirunelveli">Tirunelveli</option>
                    <?php
                    // Loop through unique departure and destination options from database
                    if ($resultRoutes->num_rows > 0) {
                        while ($row = $resultRoutes->fetch_assoc()) {
                            echo "<option value='" . $row['departure'] . "'>" . $row['departure'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <!-- Destination Dropdown -->
            <div class="col-md-3 mb-3">
                <select class="form-control" name="destination" required>
                    <option value="">Select Destination</option>
                    <option value="Chennai">Chennai</option>
                    <?php
                    // Loop through unique destination options
                    if ($resultRoutes->num_rows > 0) {
                        while ($row = $resultRoutes->fetch_assoc()) {
                            echo "<option value='" . $row['destination'] . "'>" . $row['destination'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <!-- Date Input -->
            <div class="col-md-3 mb-3">
                <input type="date" class="form-control" name="date" required min="<?php echo date('Y-m-d'); ?>"
                    max="<?php echo date('Y-m-d', strtotime('+3 months')); ?>">
            </div>
            <!-- Search Button -->
            <div class="col-md-3 mb-3">
                <button type="submit" class="btn btn-primary btn-block">Search Bus</button>
            </div>
        </div>
    </form>
</div>

<!-- Include Footer -->
<?php include('footer.php'); ?>

<script>
    // Wait for the page to load completely
    window.onload = function() {
        // Add the 'show' class to the welcome container for transition
        document.getElementById('welcome-container').classList.add('show');
    };
</script>

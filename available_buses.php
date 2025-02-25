<?php
// Include header and database connection
include('header.php');
include('db_connection.php');

// Check if the search form is submitted and process it
if (isset($_GET['departure']) && isset($_GET['destination']) && isset($_GET['date'])) {
    $departure = $conn->real_escape_string($_GET['departure']);
    $destination = $conn->real_escape_string($_GET['destination']);
    $date = $_GET['date'];

    // Query to get available buses based on the departure, destination, and travel date
    $sql = "SELECT * FROM buses WHERE departure = '$departure' AND destination = '$destination' AND travel_date = '$date' AND available_seats > 0";
    $result = $conn->query($sql);

    // Check if buses are available for the selected route
    if ($result->num_rows > 0) {
        echo "<h2>Available Buses from $departure to $destination on $date:</h2>";
        echo "<table class='table'>";
        echo "<thead><tr><th>Bus Name</th><th>Departure Time</th><th>Arrival Time</th><th>Available Seats</th><th>Action</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['bus_name'] . "</td>";
            echo "<td>" . $row['departure_time'] . "</td>";
            echo "<td>" . $row['arrival_time'] . "</td>";
            echo "<td>" . $row['available_seats'] . "</td>";
            echo "<td><a href='book_bus.php?bus_id=" . $row['id'] . "' class='btn btn-success'>Book Now</a></td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No buses available for the selected route and date.</p>";
    }
}

$conn->close();
?>

<!-- Include Footer -->
<?php include('footer.php'); ?>

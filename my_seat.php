<?php include('header.php'); ?>

<?php
// Fetch bus details and selected seats from URL parameters
$bus_id = $_GET['bus_id'] ?? null;
$bus_time = $_GET['time'] ?? '10:00 AM';
$bus_price = $_GET['price'] ?? 500; // Default price, could be dynamic from DB

// Dummy bus seat data (48 seats) - 12 rows, 4 columns
$bus_seats = [];
$seat_number = 1; // Seat number counter
for ($row = 1; $row <= 12; $row++) {
    for ($seat = 1; $seat <= 4; $seat++) { // 4 columns
        $bus_seats[] = ['row' => $row, 'seat' => $seat, 'available' => true, 'seat_number' => str_pad($seat_number++, 2, '0', STR_PAD_LEFT)];
    }
}
?>

<div class="container mt-5">
    <h3 class="text-center text-primary">Choose Your Seats</h3>
    <p class="text-center text-dark">Departure Time: <?php echo $bus_time; ?> | Price per Seat: ₹<?php echo $bus_price; ?></p>

    <div id="seat-layout" class="mt-5">
        <h4 class="text-center text-primary">Select Your Seats</h4>

        <div class="seat-container">
            <?php for ($row = 1; $row <= 12; $row++): ?>
                <div class="seat-row">
                    <?php foreach ($bus_seats as $seat): ?>
                        <?php if ($seat['row'] == $row): ?>
                            <div class="seat" data-seat-id="<?php echo $seat['seat_number']; ?>" data-seat-available="<?php echo $seat['available'] ? 'true' : 'false'; ?>">
                                <?php echo "Seat " . $seat['seat_number']; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </div>

        <button class="btn btn-primary btn-block mt-4" onclick="proceedToPassengerDetails()">Continue</button>
    </div>
</div>

<?php include('footer.php'); ?>

<script>
// Seat selection logic
document.querySelectorAll('.seat').forEach(function(seat) {
    seat.addEventListener('click', function() {
        const isAvailable = seat.dataset.seatAvailable === 'true';
        if (isAvailable) {
            seat.classList.toggle('selected'); // Toggle selection
        } else {
            alert('This seat is already booked!');
        }
    });
});

// Proceed to passenger details
function proceedToPassengerDetails() {
    const selectedSeats = [];
    document.querySelectorAll('.seat.selected').forEach(function(seat) {
        selectedSeats.push(seat.dataset.seatId); // Collect selected seat numbers
    });

    if (selectedSeats.length > 0) {
        // Redirect to passenger details page with selected seats and bus details
        window.location.href = 'passenger_details.php?bus_id=<?php echo $bus_id; ?>&seats=' + selectedSeats.join(',') + '&price=<?php echo $bus_price; ?>';
    } else {
        alert('Please select at least one seat.');
    }
}
</script>
<style>
/* Background color for the page */
body {
    background-color: #f8f9fa; /* Light grey background */
}

/* Center the seat layout */
.seat-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
}

/* Seat Rows Styling */
.seat-row {
    display: flex;
    justify-content: space-between; /* Space between columns */
    margin-bottom: 10px;
}

/* Individual Seat Styling */
.seat {
    width: 50px; /* Smaller size for seats */
    height: 50px; /* Smaller height */
    margin: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 2px solid #007bff; /* Blue border */
    border-radius: 5px;
    background-color: #ffffff; /* White background */
    color: #007bff; /* Blue text */
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
    font-weight: bold;
    text-align: center;
}

.seat.selected {
    background-color: #007bff; /* Selected seat color (blue) */
    color: white; /* White text when selected */
}

.seat:hover {
    background-color: #007bff;
    color: white;
}

/* Button Style */
.btn {
    font-size: 16px;
}

.btn-block {
    width: 100%;
}

/* Text styling */
.text-primary {
    color: #007bff !important; /* Blue color for headings */
}

.text-dark {
    color: #343a40 !important; /* Dark color for description */
}
</style>

<?php include('header.php'); ?>

<?php
// Fetch bus details and selected seats from URL parameters
$bus_id = $_GET['bus_id'] ?? null;
$seats = isset($_GET['seats']) ? explode(',', $_GET['seats']) : [];
$num_passengers = count($seats); // Number of selected seats
$bus_price = $_GET['price'] ?? 500; // Example price per seat (adjust as needed)

// Calculate the total amount (price * number of passengers)
$total_amount = $bus_price * $num_passengers;
?>

<div class="container mt-5">
    <h3 class="text-center text-primary">Enter Passenger Details</h3>
    <p class="text-center text-dark">You have selected <?php echo $num_passengers; ?> seat(s).</p>

    <form action="payment.php" method="POST">
        <?php for ($i = 0; $i < $num_passengers; $i++): ?>
            <div class="passenger-form mb-3">
                <h5>Passenger <?php echo $i + 1; ?></h5>
                <div class="form-group">
                    <label for="name_<?php echo $i; ?>">Name</label>
                    <input type="text" class="form-control" id="name_<?php echo $i; ?>" name="name[]" required maxlength="50" pattern="[A-Za-z\s]+" placeholder="Enter full name">
                </div>
                <div class="form-group">
                    <label for="age_<?php echo $i; ?>">Age</label>
                    <input type="number" class="form-control" id="age_<?php echo $i; ?>" name="age[]" required min="1" max="99" placeholder="Enter age (2 digits)">
                </div>
                <div class="form-group">
                    <label for="gender_<?php echo $i; ?>">Gender</label>
                    <select class="form-control" id="gender_<?php echo $i; ?>" name="gender[]" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
        <?php endfor; ?>

        <div class="form-group">
            <label for="contact_number">Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" required maxlength="10" pattern="\d{10}" placeholder="Enter 10-digit contact number">
        </div>

        <input type="hidden" name="bus_id" value="<?php echo $bus_id; ?>">
        <input type="hidden" name="seats" value="<?php echo implode(',', $seats); ?>">
        <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">

        <button type="submit" class="btn btn-primary btn-block mt-4">Proceed to Payment</button>
    </form>
</div>

<?php include('footer.php'); ?>
<script>
// Ensure only valid names, ages, and contact number are allowed
document.querySelectorAll('input[name="name[]"]').forEach(function(input) {
    input.addEventListener('input', function() {
        // Allow only alphabets and spaces
        this.value = this.value.replace(/[^A-Za-z\s]/g, '');
    });
});

document.querySelectorAll('input[name="contact_number"]').forEach(function(input) {
    input.addEventListener('input', function() {
        // Allow only digits
        this.value = this.value.replace(/\D/g, '');
    });
});
</script>

<style>
/* Background color for the page */
body {
    background-color: #f8f9fa; /* Light grey background */
}

/* Form styling */
.passenger-form {
    background-color: #ffffff;
    padding: 15px;
    border: 1px solid #007bff;
    border-radius: 5px;
}

h5 {
    color: #007bff;
}

/* Input fields */
input, select {
    border-radius: 5px;
    border: 1px solid #007bff;
    padding: 10px;
}

/* Button style */
.btn {
    font-size: 16px;
}

.btn-block {
    width: 100%;
}

/* Text styling */
.text-primary {
    color: #007bff !important;
}

.text-dark {
    color: #343a40 !important;
}
</style>
<?php include('header.php'); ?>

<?php
// Fetch the bus details and selected seats from POST data
$bus_id = $_POST['bus_id'] ?? null;
$seats = isset($_POST['seats']) ? explode(',', $_POST['seats']) : [];
$total_amount = $_POST['total_amount'] ?? 0;
?>

<div class="container mt-5">
    <!-- Payment Success Message -->
    <div id="payment-success-message" class="text-center" style="display: none;">
        <h3 class="text-success">Payment Successful</h3>
        <p>Thank you for your payment!</p>
    </div>

    <!-- Ticket Details (initially hidden) -->
     <center>
    <div id="ticket-details" class="ticket-details" style="display: none;">
        <h4 class="text-center text-primary">Your Ticket Details</h4>
        <p><strong>Bus ID:</strong> <?php echo $bus_id; ?></p>
        <p><strong>Number of Passengers:</strong> <?php echo count($seats); ?></p>
        <p><strong>Selected Seats:</strong> <?php echo implode(', ', $seats); ?></p>
        <p><strong>Total Amount Paid:</strong> <?php echo $total_amount; ?></p>
    </div>
</center>
</div>

<script>
    // Show payment success message
    document.getElementById("payment-success-message").style.display = "block";

    // After 4 seconds, hide the success message and show the ticket details
    setTimeout(function() {
        // Hide payment success message
        document.getElementById("payment-success-message").style.display = "none";

        // Show ticket details
        document.getElementById("ticket-details").style.display = "block";
    }, 4000); // 4 seconds delay
</script>

<?php include('footer.php'); ?>
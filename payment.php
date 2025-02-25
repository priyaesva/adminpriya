<?php include('header.php'); ?>

<?php
// Fetch bus details, selected seats, and total amount from the previous page
$bus_id = $_POST['bus_id'] ?? null;
$seats = isset($_POST['seats']) ? explode(',', $_POST['seats']) : [];
$total_amount = $_POST['total_amount'] ?? 0;

// Get the number of passengers
$num_passengers = count($seats);
?>

<div class="container mt-5">
    <h3 class="text-center text-primary">Payment Information</h3>
    <p class="text-center text-dark">You are about to make a payment for <?php echo $num_passengers; ?> seat(s).</p>

    <form action="payment_success.php" method="POST">
        <div class="form-group">
            <label for="card_number">ATM Card Number</label>
            <input type="text" class="form-control" id="card_number" name="card_number" required maxlength="19" placeholder="Enter 16-digit ATM card number" pattern="\d{4} \d{4} \d{4} \d{4}" oninput="formatCardNumber()" />
        </div>

        <div class="form-group">
            <label for="expiry_date">Expiry Date (MM/YY)</label>
            <input type="text" class="form-control" id="expiry_date" name="expiry_date" required maxlength="5" placeholder="MM/YY" pattern="\d{2}/\d{2}" oninput="formatExpiryDate()" />
        </div>

        <div class="form-group">
            <label for="cvv">CVV (3 digits)</label>
            <input type="text" class="form-control" id="cvv" name="cvv" required maxlength="3" placeholder="Enter CVV" pattern="\d{3}" />
        </div>

        <!-- Total Amount Calculation (read-only) -->
        <div class="form-group">
            <label for="total_amount">Total Amount</label>
            <input type="text" class="form-control" id="total_amount" name="total_amount" value="₹<?php echo $total_amount; ?>" readonly />
        </div>

        <input type="hidden" name="bus_id" value="<?php echo $bus_id; ?>">
        <input type="hidden" name="seats" value="<?php echo implode(',', $seats); ?>">

        <button type="submit" class="btn btn-primary btn-block mt-4">Proceed to Pay</button>
    </form>
</div>

<script>
    // Function to format the ATM card number with spaces
    function formatCardNumber() {
        var cardNumber = document.getElementById('card_number').value.replace(/\D/g, ''); // Remove non-numeric characters
        var formatted = '';
        
        // Add spaces after every 4 digits
        for (var i = 0; i < cardNumber.length; i++) {
            if (i > 0 && i % 4 === 0) {
                formatted += ' ';
            }
            formatted += cardNumber[i];
        }
        
        document.getElementById('card_number').value = formatted;
    }

    // Function to automatically add a slash in the expiry date (MM/YY format)
    function formatExpiryDate() {
        var expiryDate = document.getElementById('expiry_date').value.replace(/\D/g, ''); // Remove non-numeric characters
        if (expiryDate.length > 2) {
            expiryDate = expiryDate.slice(0, 2) + '/' + expiryDate.slice(2, 4);
        }
        document.getElementById('expiry_date').value = expiryDate;
    }
</script>

<?php include('footer.php'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
session_start();
// Enable error reporting for debugging  
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../customer/layout/layout.php'); // Including layout
include('../database/connection.php'); // Including database connection

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email']; // Fetch logged-in user email

// Fetch all food items
$sql = "SELECT food_id, name, description, price, image FROM fooditem";
$result = $conn->query($sql);
?>

<!------------------ FRONTEND ------------------->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="../css/card.css">

    <div class="main-detail">
        <h1 class="main-title">Choose Orders</h1>
        <div class="detail-wrapper">
            <?php if ($result && $result->num_rows > 0) { 
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="detail-card">
                        <img src="../img/<?php echo !empty($row['image']) ? htmlspecialchars($row['image']) : 'path/to/default-image.jpg'; ?>" 
                            class="detail-img" 
                            alt="<?php echo htmlspecialchars($row['name']); ?>" />
                        <div class="detail-desc">
                            <div class="detail-name">
                                <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                                <p class="detail-sub"><?php echo htmlspecialchars($row['description']); ?></p>
                                <p class="price"><strong>Price: NRs.<?php echo htmlspecialchars($row['price']); ?></strong></p>
                                <form method="post" action="">
                                    <input type="hidden" name="food_id" value="<?php echo $row['food_id']; ?>">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Quantity:</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                                    </div>
                                    <button type="submit" name="placeorder" class="btn btn-primary w-100">Place Order</button>
                                </form>
                            </div>
                        </div>
                    </div> <!-- Close .detail-card here -->
                <?php } ?>
            <?php } else { ?>
                <div class="col-12">
                    <p>No food items available.</p>
                </div>
            <?php } ?>
        </div> <!-- Close .detail-wrapper here -->
    </div> <!-- Close .main-detail here -->

</div>
        </div>
    </div>
</body>

<script>
    <?php if ($messageType && $messageText): ?>
        Swal.fire({
            icon: '<?php echo $messageType; ?>',  // 'success' or 'error'
            title: '<?php echo $messageType === 'success' ? 'Success!' : 'Oops!'; ?>',
            text: '<?php echo $messageText; ?>',
            confirmButtonText: 'Okay'
        });
    <?php endif; ?>
</script>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg-com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<!-- adding javascript -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="../js/app.js"></script>
</html>

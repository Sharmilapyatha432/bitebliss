<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();  // Start the session

if (!isset($_SESSION['adminname'])) {
    // If admin is not logged in, redirect to the login page
    header("Location: admin_login.php");
    exit();
}

// Database Connection
include('../database/connection.php');

// Fetch orders
$order_query = "SELECT o.order_id, o.cid AS customer_id, c.name AS customer_name, o.total_amount,
                o.delivery_status, o.order_date, o.estimated_delivery_time,
                od.order_details_id, od.food_id, f.name AS food_name, od.quantity, od.price
                FROM orders o 
                JOIN orderdetails od ON o.order_id = od.order_id
                JOIN fooditem f ON od.food_id = f.food_id
                JOIN customer c ON o.cid = c.cid
                ORDER BY o.order_id";
$orders = mysqli_query($conn, $order_query);

if (!$orders) {
    // Handle query error 
    die("Query Failed: " . mysqli_error($conn));
}

include('../admin/layout/adminheader.php');
?>


<!-- <link rel="stylesheet" href="css/adminpanel.css"> -->
<link rel="stylesheet" href="../css/admin_table.css">
<div class="main-content">
    <h2 align="center">Orders List</h2>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Order Detail ID</th>
                <th>Ordered At</th>
                <th>Customer Name</th>
                <th>Food ID</th>
                <th>Food Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Estimated Delivery Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                <td><?php echo htmlspecialchars($order['order_details_id']); ?></td>
                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($order['food_id']); ?></td>
                <td><?php echo htmlspecialchars($order['food_name']); ?></td>
                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                <td><?php echo htmlspecialchars($order['total_amount']); ?></td>
                <td><?php echo htmlspecialchars($order['estimated_delivery_time']); ?></td>
                <td><?php echo htmlspecialchars($order['delivery_status']); ?></td>
                <td>
                    <form action="update_order_status.php" method="POST">
                        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                        <select name="delivery_status" onchange="this.form.submit()" class="form-select" 
                                <?php if ($order['delivery_status'] == 'delivered') echo 'disabled'; ?>>
                            <option value="" disabled selected>Order Status</option>
                            <option value="shipped" <?php if ($order['delivery_status'] == 'shipped') echo 'selected'; ?>>Shipped</option>
                            <option value="delivered" <?php if ($order['delivery_status'] == 'delivered') echo 'selected'; ?>>Delivered</option>
                        </select>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php
session_start();
include('../database/connection.php');

// Check if user is logged in
if (!isset($_SESSION['cid'])) {
    header("Location: login.php");
    exit();
}

$customer_id = $_SESSION['cid'];

// Check if form is submitted (Handle order placement)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['food_id']) && isset($_POST['quantity']) && isset($_POST['shipping_address']) && isset($_POST['city']) && isset($_POST['distance_from_restaurant'])) {
        
        // Sanitize and validate inputs
        echo "hfjsdhfkjsdhfkjdfhgkjdfs fbgkdfhsjkghsf sdbgjfhk";
        $food_id = filter_var($_POST['food_id'], FILTER_VALIDATE_INT);
        $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);
        $shipping_address = htmlspecialchars(trim($_POST['shipping_address']));
        $city = htmlspecialchars(trim($_POST['city']));
        $distance_from_restaurant = filter_var($_POST['distance_from_restaurant'], FILTER_VALIDATE_FLOAT);

        if ($food_id === false || $quantity === false || empty($shipping_address) || empty($city)  || $distance_from_restaurant === false) {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Invalid input data. Please check the form and try again.'
            ];
            header("Location: viewfooditem.php");
            exit();
        }
        //

        // Begin transaction
        $conn->begin_transaction();

        try {
            // Fetch food details (price)
            $stmt = $conn->prepare("SELECT price FROM fooditem WHERE food_id = ?");
            $stmt->bind_param("i", $food_id);
            $stmt->execute();
            $food = $stmt->get_result()->fetch_assoc();

            // Ensure the food exists
            if ($food) {
                $total_amount = $food['price'] * $quantity;
                // Algorithm Here
                // Set the estimated delivery time (prep time + distance-based adjustment)
                $prep_time = 30; // Base preparation time in minutes
                $delivery_time = ($distance_from_restaurant <= 5) ? 45 : 45 + ($distance_from_restaurant - 5) * 5;   //For each additional kilometer, an additional 5 minutes is added.

                // Insert the order into the orders table
                $sql_order = "INSERT INTO orders (cid, total_amount, shipping_address, city, delivery_status, distance, estimated_delivery_time)
                            VALUES (?, ?, ?, ?, 'pending', ?, ?)";
                            $stmt_order = $conn->prepare($sql_order);
                            $stmt_order->bind_param("idssdi", $customer_id, $total_amount, $shipping_address, $city, $distance_from_restaurant, $delivery_time); // Match the parameters correctly
                            $stmt_order->execute();

                           // Get the last inserted order ID
                            $order_id = $conn->insert_id;

                           // Insert order details into orderdetails table
                            $sql_order_item = "INSERT INTO orderdetails (order_id, food_id, quantity, price) 
                                            VALUES (?, ?, ?, ?)";
                            $stmt_order_item = $conn->prepare($sql_order_item);
                            $stmt_order_item->bind_param("iiid", $order_id, $food_id, $quantity, $food['price']);
                            $stmt_order_item->execute();

                // Commit the transaction
                $conn->commit();

                // Set success message in session
                $_SESSION['message'] = [
                    'type' => 'success',
                    'text' => 'Your order has been placed successfully. Estimated delivery time: ' . $delivery_time . ' minutes.'
                ];
            } else {
                // Rollback transaction if food item is not available
                $conn->rollback();
                $_SESSION['message'] = [
                    'type' => 'error',
                    'text' => 'Food Item not available'
                ];
            }
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'An error occurred while placing the order. Please try again.'
            ];

            // Log the error for debugging purposes
            error_log($e->getMessage());
        }

        // Redirect back to view_product.php with a message
        header("Location: viewfooditem.php");
        exit();
    } else {
        // If required POST data is missing
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Missing required data. Please try again.'
        ];
        header("Location: viewfooditem.php");
        exit();
    }
}
?>

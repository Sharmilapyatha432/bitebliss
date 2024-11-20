<?php
include('../admin/layout/adminheader.php');

// Check if the user is logged in; redirect to login page if not logged in
session_start();
if (!isset($_SESSION['adminname'])) {
    header("location:admin_login.php");
}
$adminname = $_SESSION['adminname'];

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include("../database/connection.php");

// Delete Category
if (isset($_POST['delete'])) {
    $food_id = $_POST['food_id'];
    $sql = "DELETE FROM fooditem WHERE food_id='$food_id'";
    $result = $conn->query($sql);
    if ($result) {
        echo "<script>alert('Food Item Deleted Successfully');</script>";
        header("Location: fooditems.php");
        exit; // Redirect after deletion
    } else {
        die("Error: " . $conn->error);
    }
}


// Fetch all food items for the list
$food_query = "SELECT f.*, fc.category_name FROM fooditem f 
        LEFT JOIN foodcategory fc ON f.category_id = fc.category_id";
// $result = $conn->query($sql);

// Query to join Products and Categories and get the product list
// $food_query = "SELECT p.product_id, p.name AS product_name, p.description, p.price, p.stock, 
//                 p.image_url, p.created_at, p.updated_at, c.name AS category_name
//                 FROM Products p JOIN Categories c ON p.category_id = c.category_id
//                 ORDER BY p.product_id;";

// Execute the query
$food_result = mysqli_query($conn, $food_query);

// Check if query succeeded
if (!$food_result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<link rel="stylesheet" href="css/adminpanel.css">
<div class="main-content">
    <?php if (!isset($_POST['add'])) { ?>
        <h1 align="center">List of Food Items</h1>
        <div class="table-wrapper">
            <form action="add_fooditem.php" method="post">
                <input type="submit" value="Add Food" name="add">
            </form>
            <table class="fl-table">
                <thead>
                <tr>
                    <th>Food ID</th>
                    <th>Food Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <?php if ($food_result && $food_result->num_rows > 0) {
                        while ($row = $food_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['food_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td><?php echo htmlspecialchars($row['price']); ?></td>
                                <td><img src="../img/<?php echo htmlspecialchars($row['image']); ?>" alt="Food Image" width="50"></td>
                                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                                <td>
                                    <div class="button-row">
                                        <form method="post" action="editfooditem.php">
                                            <input type="hidden" value="<?php echo $row['food_id']; ?>" name="food_id" />
                                            <input type="submit" value="Edit" name="edit" />
                                        </form>
                                        <form method="post" action="fooditems.php">
                                            <input type="hidden" value="<?php echo $row['food_id']; ?>" name="food_id" />
                                            <input type="submit" value="Delete" name="delete" 
                                            onclick="return confirm('Are you sure you want to delete this food item?');"
                                            style="background-color: red; color: white; border: none; cursor: pointer;" 
                                            onmouseover="this.style.backgroundColor='darkred';" 
                                            onmouseout="this.style.backgroundColor='red';" />
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="10">No Food Items Listed.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>

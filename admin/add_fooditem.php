<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food Items</title>
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</head>
<body>

<?php
session_start();
include('../database/connection.php');

if (!isset($_SESSION['adminname'])) {
    header("Location: admin_login.php");
    exit;
}

// Add Product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all expected form fields are set
    if (isset($_POST['name'], $_POST['description'], $_POST['price'], $_POST['category_id'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];

        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "../img/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $allowed_file_types = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array($imageFileType, $allowed_file_types)) {
                if (file_exists($target_file)) {
                    $target_file = $target_dir . time() . "_" . basename($_FILES["image"]["name"]);
                }

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $query = "INSERT INTO fooditem (name, description, price, category_id, image) 
                              VALUES ('$name', '$description', '$price', '$category_id', '$target_file')";

                    if (mysqli_query($conn, $query)) {
                        // Set success message
                        $_SESSION['message'] = "Food Item added successfully!";
                        $_SESSION['msg_type'] = "success"; // or any other type you want to define
                        // header("Location: fooditems.php");
                        // exit;
                    } else {
                        // Set error message
                        $_SESSION['message'] = "Error inserting food item: " . mysqli_error($conn);
                        $_SESSION['msg_type'] = "error";
                    }
                } else {
                    $_SESSION['message'] = "Error uploading the image.";
                    $_SESSION['msg_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
                $_SESSION['msg_type'] = "error";
            }
        } else {
            $_SESSION['message'] = "Image file is required.";
            $_SESSION['msg_type'] = "error";
        }
    }
}
?>

    <?php if (isset($_SESSION['message'])): ?>
        <script>
            swal({
                title: "<?php echo $_SESSION['msg_type'] == 'success' ? 'Success' : 'Error'; ?>",
                text: "<?php echo $_SESSION['message']; ?>",
                icon: "<?php echo $_SESSION['msg_type'] == 'success' ? 'success' : 'error'; ?>",
                button: "OK",
            }).then(() => {
                // Redirect if success
                <?php if ($_SESSION['msg_type'] == 'success'): ?>
                    window.location.href = "fooditems.php"; // Redirect to the product list page
                <?php endif; ?>
            });
        </script>
        <?php unset($_SESSION['message']); ?>
        <?php unset($_SESSION['msg_type']); ?>
    <?php endif; ?>


<link rel="stylesheet" href="../css/form.css">
<form method="post" action="add_fooditem.php" enctype="multipart/form-data" autocomplete="off">
    <div class="container">
        <label for="foodname">Food Name</label>
        <input type="text" name="name" placeholder="Enter Food Name" required>

        <label for="fooddescription">Food Description</label>
        <textarea name="description" placeholder="Enter Food Description"></textarea>

        <label for="price">Price</label>
        <input type="number" name="price" placeholder="Price" required>

        <label for="category">Category</label>
        <select name="category_id" required>
            <!-- Loop through categories dynamically -->
            <?php
            $category_query = "SELECT * FROM foodcategory";
            $categories = mysqli_query($conn, $category_query);
            echo "<option value='choose' disabled selected>Select Category</option>";
            while ($category = mysqli_fetch_assoc($categories)) {
                echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
            }
            ?>
        </select>

        <label for="image">Food Image</label>
        <input type="file" name="image" accept="image/*" required>
        
        <button type="submit">Add Food</button>
        <button><a href="fooditems.php">Back</a></button>
    </div>
</form>
</body>
</html>
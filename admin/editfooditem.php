<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<?php
// include('../admin/layout/adminheader.php');

// Check if the user is logged in; redirect to login page if not logged in
session_start();
if (!isset($_SESSION['adminname'])) {
    header("location:admin_login.php");
}
$adminname = $_SESSION['adminname'];

// Database connection
include("../database/connection.php");

// Initialize variables for editing
$name = $description = $price = $category_id = $food_id = $image = "";

// Editing food item
if (isset($_POST['edit_food'])) {
    $food_id = $_POST['food_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category_id'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target = "../img/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        // Fetch the existing image if no new image is uploaded
        $stmt = $conn->prepare("SELECT image FROM fooditem WHERE food_id = ?");
        $stmt->bind_param("i", $food_id);
        $stmt->execute();
        $image_result = $stmt->get_result();
        if ($image_result->num_rows > 0) {
            $image_row = $image_result->fetch_assoc();
            $image = $image_row['image'];
        }
        // If no new image is uploaded, retain the old image
        //$image = ''; // You might want to fetch the current image from the database if needed
    }

    // Prepare SQL statement
    $sql = "UPDATE fooditem SET name='$name', description='$description', price='$price', category_id='$category'";

    // Only update the image if it's new
    if ($image) {
        $sql .= ", image='$image'";
    }

    $sql .= " WHERE food_id='$food_id'";
    
    if ($conn->query($sql)===TRUE ) {
        echo "<script>
        swal({
            title: 'Food Item Updated',
            text: 'Food Item updated successfully!',
            icon: 'success',
            confirmButtonText: 'Ok',
        }).then((function) => {
        
            window.location.href = 'fooditems.php';
        
        });
    </script>";
    exit;
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Update Failed',
                text: 'An error occured while updating the food items',
                confirmButtonText: 'OK'
            });
        </script>";
        // exit;
    }
}

// View food items details for editing
if (isset($_POST['edit'])) {
    $food_id = $_POST['food_id'];
    $sql = "SELECT * FROM fooditem WHERE food_id='$food_id'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
        $category_id = $row['category_id'];
        $food_id = $row['food_id'];
        $image = $row['image'];
    } else {
        die("No food item found with the given ID.");
    }
}
?>
        
        <!-- Food Item Edit Form -->
        <body>
        <link rel="stylesheet" href="../css/form.css">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="container">
                <label for="foodname">Food Name</label>
                <input type="text" name="name" placeholder="Enter Food Name" required value="<?php echo htmlspecialchars($name); ?>">

                <label for="fooddescription">Food Description</label>
                <textarea name="description" placeholder="Enter Food Description" required><?php echo htmlspecialchars($description); ?></textarea>

                <label for="price">Price</label>
                <input type="number" name="price" step="0.01" placeholder="Price" required value="<?php echo htmlspecialchars($price); ?>">

                <label for="category">Category</label>
                <select name="category_id" required>
                    <option value='choose' disabled>Select Category</option>
                    <?php
                    $category_query = "SELECT * FROM foodcategory";
                    $categories = mysqli_query($conn, $category_query);
                    while ($category = mysqli_fetch_assoc($categories)) {
                        $selected = ($category['category_id'] == $category_id) ? 'selected' : '';
                        echo "<option value='{$category['category_id']}' $selected>{$category['category_name']}</option>";
                    }
                    ?>
                </select

                <label for="image">Food Image</label>
                <input type="file" name="image" value="<?php //echo htmlspecialchars($image); ?>" accept="image/*">
                <img src="../img/<?php echo htmlspecialchars($image); ?>" width="100px" alt="Food Image">

                <input type="hidden" name="food_id" value="<?php echo htmlspecialchars($food_id); ?>" />
                <button type="submit" name="edit_food">Update Food Item</button>
                <button type="button" onclick="window.location.href='fooditems.php'">Back</button>
            </div>
        </form>
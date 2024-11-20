<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
        <!-- Font Awesome CDN -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
<style>

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Arial', sans-serif;
  background-color: #d9f2ee;
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
  background-color: #0ac1dde1;
  color: white;
}

/* .logo img {
  width: 50px;
  height: auto;
}

.logoo{
  height: 100%;
  width: 250px;
  padding-left: 15px;
} */

strong{
    color: #fff; /* Text color */
    font-size: 20px; /* Font size */
    font-weight: bold; /* Make the text bold */
    text-transform: uppercase; /* Transform text to uppercase */
    letter-spacing: 1px; /* Space between letters */
    transition: color 0.3s ease; /* Smooth transition for hover effect */}

.nav-links {
  display: flex;
  list-style-type: none;
}

.nav-links li {
  margin: 0 15px;
}

.nav-links a {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-decoration: none;
  color: #c4c4c4;
  font-size: 0.9em;
}

.nav-links a:hover {
  color: white;
}

.nav-links a i {
  font-size: 1.2em;
  margin-bottom: 5px;
  color: #333;
}

.nav-links a span {
  font-size: 0.85em;
  color: #333;
}

</style>
<body>
<!------------- FOR NAVBAR -------------->
<nav class="navbar">
        <div class="logo">
            <!-- <img src="../img/Biteblisss.png" alt="Logo" /> -->
            <strong>BITEBLISS</strong>
        </div>
        <ul class="nav-links">
            <!-- <li><a href="adminpanel.php"><i class="fas fa-home"></i><span>Home</span></a></li> -->
            <li><a href="category_list.php"><i class="fas fa-tachometer-alt"></i><span>Categories</span></a></li>
            <li><a href="fooditems.php"><i class="fas fa-box"></i><span>FoodItems</span></a></li>
            <li><a href="admin_panel.php"><i class="fas fa-th"></i><span>Orders</span></a></li>
            <li><a href="customer_list.php"><i class="fa-solid fa-user-group"></i><span>Customers</span></a></li>
            <!-- <li><a href="deliveryperson_list.php"><i class="fa-solid fa-person-biking"></i><span>Delivery</span></a></li> -->
            <li><a href="admin_logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>Logout</span></a></li>
        </ul>
    </nav>
</body>
</html> 


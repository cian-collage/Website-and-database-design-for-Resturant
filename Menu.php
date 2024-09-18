<!--  
    Description: This PHP script fetches menu items from the database and displays them categorized on the menu page.
 -->

<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Project"; 

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch menu items from the database for each category
    $categories = array("Starters", "Mains", "Desserts");
    $menuByCategory = array();

    foreach ($categories as $category) {
        $sql = "SELECT * FROM menu WHERE category = '$category'";
        $result = $conn->query($sql);

        // Fetch data and organize it by category
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $menuByCategory[$category][] = $row;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=Devicewidth, initial-scale=1.0">
        <title>Project</title>
        <link rel="stylesheet" href="Menu_style.css">
        <link rel="shortcut icon" href="Fuego-Title.png" type="image/x-icon">
    </head>
    <body>

        <!-- Make Title -->
        <div id="title" class="title">
            <p>MENU</p>
        </div>

        <!-- Adds menu button -->
        <button id="openbtn" class="openbtn" onclick="openNav()">☰</button>

        <!-- Creates contents of side menu -->
        <div id="mySidenav" class="sidebar">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
            <a href="Home.html">Home</a>
            <a href="Menu.php">Menu</a>
            <a href="Account.php">Account</a>
            <a href="Contact.html">Contact</a>
        </div>

        <!-- Display menu items from Databse -->
        <div id="Main" class="main">
            <?php foreach ($menuByCategory as $category => $items): ?>
                <!-- create catagory title -->
                <div class="category">
                    <h2><?php echo $category; ?></h2>
                    <!-- create list of menu items for catagory -->
                    <ul>
                        <?php foreach ($items as $item): ?>
                            <ul>
                                <strong><?php echo $item["Name"]; ?></strong><br>
                                <?php echo $item["Description"]; ?><br>
                                Price: $<?php echo $item["Price"]; ?><br>
                                Allergens: <?php echo $item["Alergen"]; ?>
                            </ul>
                            <br><br>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

    <script>

        <!-- script for opening and closeing side menu -->
        function openNav() {
            document.getElementById("mySidenav").style.width = "25vw";
            document.getElementById("main").style.marginLeft = "25vw";
        }
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0vw";
            document.getElementById("main").style.marginLeft= "0vw";
        }
    </script>

</body>

</html>


<!-- 
    Description: 
    This is the admin account page. 
    It gives the admin the ability to view all 4 tables (menu,Reservations,users and actions)
    The admin can also add,edit and delete items from the menu table.
-->
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Function to display menu items
    function displayMenu() {
        global $conn;

        // Query to retrieve menu items
        $sql = "SELECT * FROM menu";
        $result = mysqli_query($conn, $sql);

        // Check if menu items are found
        if ($result && mysqli_num_rows($result) > 0) {
            // Display menu items in a table
            echo "<table>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["Name"] . "</td>";
                echo "<td>" . $row["Description"] . "</td>";
                echo "<td>€" . $row["Price"] . "</td>";
                echo "<td>" . $row["Alergen"] . "</td>";
                echo "<td>" . $row["category"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            // Display message if no menu items found
            echo "No menu items found.";
        }
    }

    // Function to display user data
    function displayUsers() {
        global $conn;

        // Query to retrieve user data
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);

        // Check if users are found
        if ($result && mysqli_num_rows($result) > 0) {
            // Display users in a table
            echo "<table>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["User_id"] . "</td>";
                echo "<td>" . $row["Username"] . "</td>";
                echo "<td>€" . $row["Password"] . "</td>";
                echo "<td>" . $row["UserType"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            // Display message if no users found
            echo "No users found.";
        }
    }

    // Function to display edit actions
    function displayEdits() {
        global $conn;

        // Query to retrieve edit actions
        $sql = "SELECT * FROM edits";
        $result = mysqli_query($conn, $sql);

        // Check if edit actions are found
        if ($result && mysqli_num_rows($result) > 0) {
            // Display edit actions in a table
            echo "<table>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["Edit_id"] . "</td>";
                echo "<td>" . $row["EditType"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            // Display message if no edit actions found
            echo "No edits found.";
        }
    }

    // Function to add a product
    function add($name, $description, $price, $alergen, $category) {
        global $conn;

        // SQL query to add a product
        $sql = "INSERT INTO menu (Name, Description, Price, Alergen, category) VALUES ('$name', '$description', $price, '$alergen', '$category')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            // Insert record into edits table indicating the action performed
            $editType = 'Add';
            $editSql = "INSERT INTO edits (EditType) VALUES ('$editType')";
            mysqli_query($conn, $editSql);

            echo "New menu item added successfully";
        } else {
            // Display error message if query fails
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Function to delete a product
    function delete($name) {
        global $conn;

        // SQL query to delete a product
        $sql = "DELETE FROM menu WHERE Name='$name'";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            // Insert record into edits table indicating the action performed
            $editType = 'Delete';
            $editSql = "INSERT INTO edits (EditType) VALUES ('$editType')";
            mysqli_query($conn, $editSql);

            echo "Menu item deleted successfully";
        } else {
            // Display error message if query fails
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Function to edit a product
    function edit($name, $description, $price, $alergen, $category) {
        global $conn;

        // SQL query to edit a product
        $sql = "UPDATE menu SET Description='$description', Price=$price, Alergen='$alergen', category='$category' WHERE Name='$name'";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            // Insert record into edits table indicating the action performed
            $editType = 'Edit';
            $editSql = "INSERT INTO edits (EditType) VALUES ('$editType')";
            mysqli_query($conn, $editSql);

            echo "Menu item updated successfully";
        } else {
            // Display error message if query fails
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Function to display reservations
    function displayReservations() {
        global $conn;

        // Query to retrieve reservations
        $sql = "SELECT * FROM reservations";
        $result = mysqli_query($conn, $sql);

        // Check if reservations are found
        if ($result && mysqli_num_rows($result) > 0) {
            // Display reservations in a table
            echo "<table>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["reservation_id"] . "</td>";
                echo "<td>" . $row["reservation_date"] . "</td>";
                echo "<td>" . $row["reservation_time"] . "</td>";
                echo "<td>" . $row["party_size"] . "</td>";
                echo "<td>" . $row["special_requests"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            // Display message if no reservations found
            echo "No reservations found.";
        }
    }

    // Handle form submission for adding a product
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Retrieve form data
        $name = $_POST['Name'];
        $description = $_POST['Description'];
        $price = $_POST['Price'];
        $alergen = $_POST['Alergen'];
        $category = $_POST['category'];

        // Call add function
        add($name, $description, $price, $alergen, $category);
    }

    // Handle form submission for deleting a product
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        // Retrieve form data
        $name = $_POST['deleteName'];

        // Call delete function
        delete($name);
    }

    // Handle form submission for updating a product
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
        // Retrieve form data
        $name = $_POST['Name'];
        $description = $_POST['Description'];
        $price = $_POST['Price'];
        $alergen = $_POST['Alergen'];
        $category = $_POST['category'];

        // Call edit function
        edit($name, $description, $price, $alergen, $category);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>
    <link rel="stylesheet" href="Admin_style2.css">
    <link rel="shortcut icon" href="Fuego-Title.png" type="image/x-icon">
</head>

<body>
    <!-- Top navigation menu -->
    <div class="topnav">
        <a class="active" href="#menu" onclick="showContent('menu')">View Menu table</a>
        <a href="#add" onclick="showContent('add')">Add item</a>
        <a href="#edit" onclick="showContent('edit')">Edit item</a>
        <a href="#delete" onclick="showContent('delete')">Delete item</a>
        <a href="#reservations" onclick="showContent('reservations')">Reservation list</a>
        <a href="#delete" onclick="showContent('users')">View Users</a>
        <a href="#edits" onclick="showContent('edits')">View Actions</a>
    </div>

    <!-- Create Menu table -->
    <div id="menu" class="menu">
        <table>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Alergen</th>
                <th>category</th>
            </tr>
            <!-- call displayMenu function -->
            <?php
            displayMenu($conn);
            ?>

        </table>
    </div>

    <!-- Create Users table -->
    <div id="users" class="users">
        <table>
            <tr>
                <th>User_id</th>
                <th>Username</th>
                <th>Password</th>
                <th>UserType</th>
            </tr>
            <!-- call displayUsers function -->
            <?php
            displayUsers($conn);
            ?>

        </table>
    </div>

    <!-- Create Edits table -->
    <div id="edits" class="edits">
        <table>
            <tr>
                <th>Edit ID</th>
                <th>Edit Type</th>
            </tr>
            <!-- call displayEdits function -->
            <?php
            displayEdits($conn);
            ?>

        </table>
    </div>

    <!-- Create Reservations table -->
    <div id="reservations" class="reservations">
        <table>
            <tr>
                <th>Reservation ID</th>
                <th>Reservation Date</th>
                <th>Reservation Time</th>
                <th>Party Size</th>
                <th>Special Requests</th>
            </tr>
            <!-- call displayReservations function -->
            <?php
            displayReservations($conn);
            ?>

        </table>
    </div>

    <!-- Create form to add a product -->
    <div id="add" class="add">
        <form method="post">
            Item Name: <input type="text" name="Name"><br>
            Description: <input type="text" name="Description"><br>
            Price: <input type="text" name="Price"><br>
            Alergen: <input type="text" name="Alergen"><br>
            Category: <input type="text" name="category"><br>
            <input type="submit" name="add" value="Add">
        </form>
    </div>

    <!-- Create form to delete a product -->
    <div id="delete" class="delete">
        <form method="post">
            Product Name to Delete: <input type="text" name="deleteName"><br>
            <input type="submit" name="delete" value="Delete">
        </form>
    </div>

    <!-- Create form to edit a product -->
    <div id="edit" class="edit">
        <form method="post">
            Item Name to Edit: <input type="text" name="Name"><br>
            New Description: <input type="text" name="Description"><br>
            New Price: <input type="text" name="Price"><br>
            New Alergen: <input type="text" name="Alergen"><br>
            New Category: <input type="text" name="category"><br>
            <input type="submit" name="edit" value="Edit">
        </form>
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


    <script>
         <!-- script for opening and closeing side menu -->
        function openNav() {
            document.getElementById("mySidenav").style.width = "25vw";
            document.getElementById("main").style.marginLeft = "25vw";
        }
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0vw";
            document.getElementById("main").style.marginLeft = "0vw";
        }


        <!--  script to show content based on menu selection -->
        function showContent(contentId) {
        // Hide all content divs except the one with the specified contentId
        var contents = document.querySelectorAll('.menu,.users,.edits,.reservations,.add,.delete,.edit');
        for (var i = 0; i < contents.length; i++) {
            if (contents[i].id !== contentId) { 
                contents[i].style.display = "none"; 
            } else {
                contents[i].style.display = "block"; 
            }
        }
    }
    </script>
</body>
</html>

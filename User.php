<!-- 
    Description: 
    This is the Customer account page. 
    It gives the Customer the ability to view  2 tables (Users and Reservations) however only the info relevent to their user_id as found in the Login page 
    The Customer can also add reservations to the Reservations table.
-->

<?php
    session_start(); // Start session at the beginning of the script

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Project"; // Change this to your actual database name

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Function to display menu items
    function displayInfo() {
        global $conn;
        // Pull user_id from Session created in Account.php
        $user_id = $_SESSION['user_id'];

        // Query to retrieve User info
        $sql = "SELECT * FROM users WHERE user_id = $user_id";
        $result = mysqli_query($conn, $sql); 

        // Check if User info is found
        if ($result && mysqli_num_rows($result) > 0) {
            // Display User info in a table
            echo "<table>";
            echo "<tr><th>User ID</th><th>Password</th><th>Username</th><th>User Type</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["User_id"] . "</td>";
                echo "<td>" . $row["Password"] . "</td>";
                echo "<td>" . $row["Username"] . "</td>";
                echo "<td>" . $row["UserType"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            // Display message if no menu items found
            echo "No users found.";
        }
    }


    // Function to display reservations for a specific user
    function displayUserReservations() {
        global $conn;
        // Pull user_id from Session created in Account.php
        $user_id = $_SESSION['user_id'];

        // Query to retrieve User info
        $sql = "SELECT * FROM reservations WHERE user_id = $user_id";
        $result = mysqli_query($conn, $sql);

        // Check if reservations are found
        if ($result && mysqli_num_rows($result) > 0) {
            // Display reservations in a table
            echo "<table>";
            echo "<tr><th>Reservation ID</th><th>User ID</th><th>Reservation Date</th><th>Reservation Time</th><th>Party Size</th><th>Special Requests</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["reservation_id"] . "</td>";
                echo "<td>" . $row["user_id"] . "</td>";
                echo "<td>" . $row["reservation_date"] . "</td>";
                echo "<td>" . $row["reservation_time"] . "</td>";
                echo "<td>" . $row["party_size"] . "</td>";
                echo "<td>" . $row["special_requests"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            // Display message if no reservations found
            echo "No reservations found for the current user.";
        }
    }

    // Function to add a reservation
    function addReservation($date, $time, $party_size, $special_requests) {
        global $conn;

        // SQL query to add a reservation
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO reservations (user_id, reservation_date, reservation_time, party_size, special_requests) 
                VALUES ('$user_id', '$date', '$time', '$party_size', '$special_requests')";

        if (mysqli_query($conn, $sql)) {
            echo "Reservation added successfully";
        } else {
            // Display error message if query fails
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

        // Handle form submission for adding a Reservation
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Get form data
        $date = $_POST['date'];
        $time = $_POST['time'];
        $party_size = $_POST['party_size'];
        $special_requests = $_POST['special_requests'];

        // Call addReservation function
        addReservation($date, $time, $party_size, $special_requests);
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Project</title>
        <link rel="stylesheet" href="User_style.css">
        <link rel="shortcut icon" href="Fuego-Title.png" type="image/x-icon">
    </head>
    <body>

        <!-- Top navigation menu -->
        <div class="topnav">
            <a class="active" href="#menu" onclick="showContent('menu')">Account Details</a>
            <a href="#reservations" onclick="showContent('reservations')">Reservation list</a>
            <a href="#reservation-add" onclick="showContent('reservation-add')">Book Reservation</a>
        </div>

        <!-- Create Info table -->
        <div id="menu" class="menu">
            <?php displayInfo(); ?>
        </div>

        <div id="reservations" class="reservations">
            <?php
                // Check if user is logged in and display reservations if logged in
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    // call displayUserReservations function
                    displayUserReservations();
                } else {
                    echo "Please <a href='Account.php'>log in</a> to view reservations.";    
                }
            ?>
        </div>
        <!-- Create form to add a reservation -->
        <div id="reservation-add" class="reservation-add">
            <form method="post">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required><br><br>
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required><br><br>
                <label for="party_size">Party Size:</label>
                <input type="number" id="party_size" name="party_size" required><br><br>
                <label for="special_requests">Special Requests:</label><br>
                <textarea id="special_requests" name="special_requests" rows="4" cols="50"></textarea><br><br>
                <input type="submit" name="add" value="Add Reservation">
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

            function showContent(contentId) {
                // Hide all content divs except the one with the specified contentId
                var contents = document.querySelectorAll('.menu,.reservations,.reservation-add');
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

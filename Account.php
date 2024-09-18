<!-- 
    Description: 
    This PHP script handles logging into accounts for the Restrant. 
    It verifies user credentials against a database and redirects users based on their UserType.
    It stores current user_id for later use.
 -->

<?php
    session_start(); // Start session at the beginning of the script

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

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get username and password from form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare a statement to avoid SQL injection
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE Username=? AND Password=?");
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // If a row is returned, the user exists
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['User_id']; // Save user ID in session for later use

            // Check UserType and redirect accordingly
            if ($row['UserType'] == 'admin') {
                header("Location: Admin.php");
                exit(); 
            } elseif ($row['UserType'] == 'staff') {
                header("Location: Staff.php");
                exit(); 
            } elseif ($row['UserType'] == 'user') {
                header("Location: User.php");
                exit(); 
            }
        } else {
            // Display message if login fails
            $error_message = "Invalid username or password";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account</title>
        <link rel="stylesheet" href="Account_style.css">
        <link rel="shortcut icon" href="Fuego-Title.png" type="image/x-icon">
    </head>
    <body>

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

        <!-- Creats Login box -->
        <div class="account-container">
            <div class="login-box">
                <!-- Creates login title -->
                <h1>Login</h1>

                <!-- Creat input for Username and  password -->
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <!-- Create submitt button that calls PHP -->
                    <button type="submit" class="login-btn">Login</button>
                </form>
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
        </script>

    </body>
</html>

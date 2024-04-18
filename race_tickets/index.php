<?php
$servername = "race_tickets_db";
$username = "user";
$password = "5QSDdSwCp&@Bd3";
$dbname = "race_condition_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize session (or resume existing)
session_start();
$message = '';

// Check if user is logged in (session exists)
if (isset($_COOKIE['PHPSESSID'])) {
    $session_id = $_COOKIE['PHPSESSID'];

    $result = $conn->query("SELECT tickets FROM users WHERE session_id = '$session_id'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tickets = $row['tickets'];
    } else {
        // User not found in database - add him
        $conn->query("INSERT INTO users (session_id) VALUES ('$session_id')");
        $tickets = 0;
    }
} else {
    // No cookie, set default ticket value
    $tickets = 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['get_ticket'])) {
        // Simulate race condition
        if (isset($_COOKIE['PHPSESSID'])) {
            $session_id = $_COOKIE['PHPSESSID'];
        } else {
            $session_id = '4d8c1d5bc58eeb45489bc58d70647fbb'; // Default
        }
        $conn->query("START TRANSACTION");
        $result = $conn->query("SELECT tickets FROM users WHERE session_id = '$session_id' FOR UPDATE");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $tickets = $row['tickets'];

            if ($tickets < 1) {
                $tickets = 1; // Update local variable after database update
                $conn->query("UPDATE users SET tickets = $tickets WHERE session_id = '$session_id'");
                $message = 'Here you go!';
            } else {
                $message = 'You can\'t get more tickets... Sorry!'; 
            }
        }

        $conn->query("COMMIT");
    } elseif (isset($_POST['exchange_flag'])) {
        if (isset($_COOKIE['PHPSESSID'])) {
            $session_id = $_COOKIE['PHPSESSID'];
        } else {
            $session_id = '4d8c1d5bc58eeb45489bc58d70647fbb'; // Default
        }
        // Check if user has enough tickets to exchange for flag
        if ($tickets >= 3) {
            $tickets = $tickets - 3;
            $conn->query("START TRANSACTION");
            $conn->query("UPDATE users SET tickets = $tickets WHERE session_id = '$session_id'");
            $flag = file_get_contents('flag.txt');
            $message =  "Congratulations! Here's your flag: $flag";
        } else {
            $message =  "You need at least 3 tickets to exchange for a flag.";
        }

        $conn->query("COMMIT");
    }
}

// Close database connection
$conn->close();
?>

<html>
<head>
    <meta charset="UTF-8">
    <style>
        #main {
            width: 100vw;
            display: flex;
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }
    </style>
</head>
<body>
<div id="main">
    <h1>You have <?php echo $tickets; ?> ticket(s)</h1>
    <form action="" method="POST">
        <input type="submit" name="get_ticket" value="Get a ticket">
    </form>
    <form action="" method="POST">
        <input type="submit" name="exchange_flag" value="Exchange tickets for a flag (3 tickets required)">
    </form>
    <p><?php echo $message; ?></p>
</div>
</body>
</html>

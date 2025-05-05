<?php
var_dump($_POST); // To check what data is sent via POST

// Step 1: Database connection settings
$host = "localhost";
$username = "root";     // replace with your MySQL username
$password = "rama78@#$";     // replace with your MySQL password
$database = "test_db";     // replace with your MySQL database name

// Step 2: Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check if the database connection works
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connection successful!<br>"; // Confirm connection
}

// Step 3: Debug - check if POST data is received
var_dump($_POST); // Debugging form data

// Step 4: Get and validate form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);

    // Output received data for debugging
    echo "Name: " . $name . "<br>";
    echo "Email: " . $email . "<br>";

    // Check if both fields are filled
    if (!empty($name) && !empty($email)) {
        // Step 5: Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        if ($stmt === false) {
            die("Error preparing the statement: " . $conn->error); // Die on error
        } else {
            $stmt->bind_param("ss", $name, $email); // 'ss' = two strings

            // Step 6: Execute and check
            if (!$stmt->execute()) {
                die("Error executing query: " . $stmt->error); // Die on error
            } else {
                echo "Form submitted successfully!";
            }

            // Step 7: Close statement
            $stmt->close();
        }
    } else {
        echo "Please fill in all fields.";
    }
}

// Step 8: Close connection
$conn->close();
?>

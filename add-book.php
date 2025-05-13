<?php
// Database Configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "LibraryDB";

try {
    // Establish database connection
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        throw new Exception("Database Connection Failed: " . $conn->connect_error);
    }

    // Handle the addition of a new book
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve form data
        $title = trim($_POST['title']);
        $authorID = $_POST['author'];
        $genre = trim($_POST['genre']);
        $pub_year = $_POST['pub_year'];
        $isbn = trim($_POST['isbn']);

        // Validate ISBN uniqueness
        $isbn_check = $conn->prepare("SELECT ISBN FROM Books WHERE ISBN = ?");
        $isbn_check->bind_param("s", $isbn);
        $isbn_check->execute();
        $isbn_check->store_result();
        if ($isbn_check->num_rows > 0) {
            throw new Exception("Error: The ISBN '$isbn' is already in use.");
        }

        // Prepare and bind the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO Books (Title, AuthorID, Genre, PublicationYear, ISBN) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $title, $authorID, $genre, $pub_year, $isbn);

        // Execute the query
        if (!$stmt->execute()) {
            throw new Exception("Error adding book: " . $stmt->error);
        }

        // Success message
        header("Location: index.html?message=Book added successfully!");
        exit();
    }

    // Fetch authors for the dropdown in the HTML form
    $result = $conn->query("SELECT AuthorID, CONCAT(FirstName, ' ', LastName) AS AuthorName FROM Authors");
    if (!$result) {
        throw new Exception("Error fetching authors: " . $conn->error);
    }
    $authors = [];
    while ($row = $result->fetch_assoc()) {
        $authors[] = $row;
    }

} catch (Exception $e) {
    // Display a user-friendly error message
    echo "<p class='error'>" . $e->getMessage() . "</p>";
} finally {
    // Close the database connection if it was successfully created
    if (isset($conn) && $conn->connect_error == null) {
        $conn->close();
    }
}
?>

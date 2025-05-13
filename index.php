<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Library</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome to Our Library 📚</h2>
    
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

        // Fetch available books
        $sql = "
        SELECT 
            b.Title, 
            CONCAT(a.FirstName, ' ', a.LastName) AS AuthorName, 
            b.Genre, 
            b.PublicationYear, 
            b.ISBN 
        FROM Books b 
        JOIN Authors a ON b.AuthorID = a.AuthorID
        ORDER BY b.Title ASC";
        
        $result = $conn->query($sql);
        if (!$result) {
            throw new Exception("Error fetching books: " . $conn->error);
        }

        // Check if any books are available
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Title</th><th>Author</th><th>Genre</th><th>Publication Year</th><th>ISBN</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Title'] . "</td>";
                echo "<td>" . $row['AuthorName'] . "</td>";
                echo "<td>" . $row['Genre'] . "</td>";
                echo "<td>" . $row['PublicationYear'] . "</td>";
                echo "<td>" . $row['ISBN'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='message'>No books available at the moment. Please check back later.</p>";
        }

    } catch (Exception $e) {
        echo "<p class='error'>" . $e->getMessage() . "</p>";
    } finally {
        // Close the database connection if it was successfully created
        if (isset($conn) && $conn->connect_error == null) {
            $conn->close();
        }
    }
    ?>
</body>
</html>

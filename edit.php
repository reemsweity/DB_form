<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Fetch the existing data for the specific id
        $sql = "SELECT id, firstnam, lastname, email FROM person WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if a record is found
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "Record not found!";
            exit();
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "No ID provided.";
    exit();
}

// Handle form submission for updating the record
if (isset($_POST['submit'])) {
    $firstnam = $_POST['firstnam'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    try {
        // Prepare the UPDATE query
        $sql = "UPDATE person SET firstnam = :firstnam, lastname = :lastname, email = :email WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':firstnam', $firstnam);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "Record updated successfully.";
            header("Location: index.php"); // Redirect to the main page after update
        } else {
            echo "Error updating record.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the connection
    $conn = null;
}
?>

<!-- HTML form for editing -->
<form method="post">
    <label for="firstnam">First Name:</label>
    <input type="text" name="firstnam" value="<?php echo $row['firstnam']; ?>" required><br>
    
    <label for="lastname">Last Name:</label>
    <input type="text" name="lastname" value="<?php echo $row['lastname']; ?>" required><br>
    
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $row['email']; ?>" required><br>
    
    <input type="submit" name="submit" value="Update">
</form>

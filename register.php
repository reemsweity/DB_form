<?php
include 'config.php';  

$firstnam = $lastname = $email = "";
$firstnameError = $lastnameError = $emailError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (empty($_POST['firstnam'])) {
        $firstnameError = "First name is required";
    } else {
        $firstnam = $_POST['firstnam'];
    }

    if (empty($_POST['lastname'])) {
        $lastnameError = "Last name is required";
    } else {
        $lastname = $_POST['lastname'];
    }

    if (empty($_POST['email'])) {
        $emailError = "Email is required";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email format";
    } else {
        $email = $_POST['email'];
    }

    
    if (empty($firstnameError) && empty($lastnameError) && empty($emailError)) {
        try {
            $sql = "INSERT INTO person (firstnam, lastname, email) VALUES (:firstnam, :lastname, :email)";
            $stmt = $conn->prepare($sql);
           
            $stmt->bindParam(':firstnam', $firstnam);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                echo "Registration successful!";
                header("Location: index.php"); 
                exit;
            } else {
                echo "Error: Could not execute query.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="" method="POST">
        First Name: <input type="text" name="firstnam" value="<?php echo htmlspecialchars($firstnam); ?>">
        <span style="color: red;"><?php echo $firstnameError; ?></span><br><br>

        Last Name: <input type="text" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>">
        <span style="color: red;"><?php echo $lastnameError; ?></span><br><br>

        Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <span style="color: red;"><?php echo $emailError; ?></span><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>

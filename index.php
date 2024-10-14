<?php

include 'config.php'; 
try {
    $sql = "SELECT id, firstnam, lastname, email FROM person";
    $result = $conn->query($sql);

   
    if ($result->rowCount() > 0) {
       echo  "<a href='register.php'>.Register New User</a>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
         <th>Action</th>
        </tr>";

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['firstnam'] . "</td>";
            echo "<td>" . $row['lastname'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>";
            echo "<a href='delete.php?id=" . $row['id'] . "'>Delete</a> ";
            echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a>";
            echo "</td>";
         
           
            echo "</tr>";
        }

      
        echo "</table>";
    } else {
        echo "No results found.";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;

?>





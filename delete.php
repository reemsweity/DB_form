<?php

include 'config.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
    
        $sql = "DELETE FROM person WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

     
        if ($stmt->execute()) {
           
        } else {
            echo "Error deleting record.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


    $conn = null;
} else {
    echo "No ID provided for deletion.";
}
?>
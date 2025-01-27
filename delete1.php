<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // First, get the image filename from the database
    $result = mysqli_query($conn, "SELECT file FROM portfolio1 WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // Check if the file exists in the folder and delete it
    $file_path = 'portfolio1/' . $row['file'];
    if (file_exists($file_path)) {
        unlink($file_path); // Delete the image from the server
    }

    // Delete the image record from the database
    $query = "DELETE FROM portfolio1 WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        echo "<h2>Image deleted successfully</h2>";
    } else {
        echo "<h2>Failed to delete image</h2>";
    }
}

header("Location: portfolio1.php");
exit();
?>
<?php 
include('footer.php');
?>

<?php
$host = 'localhost:3307';
$user = 'root';
$password = '';
$dbname = 'precious_memories';

// Create connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $category = $_POST['category'];
    $description = $_POST['description'];

    if (!empty($_FILES['image']['name'])) {
        $file_name = $_FILES['image']['name'];
        $tempname = $_FILES['image']['tmp_name'];
        $folder = 'Images/' . $file_name;

        $query = mysqli_query($conn, "INSERT INTO sort (file, category, description) VALUES ('$file_name', '$category', '$description')");

        if (move_uploaded_file($tempname, $folder)) {
            echo "<h2>File uploaded successfully</h2>";
        } else {
            echo "<h2>File not uploaded</h2>";
        }

        // Redirect to prevent re-upload on page reload
        header("Location: gallery.php");
        exit();
    } else {
        echo "<h2>Please select an image to upload</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <style>
       /* Global Styles */
       body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    color: #333;
}

/* Header Styles */
header {
    background-color: #87CEEB; /* Sky blue */
    color: #fff;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

header h1 {
    margin: 0;
    font-size: 2.5em;
}

/* Button Styles */
.go-to-admin {
    display: inline-block;
    margin-top: 10px;
    padding: 12px 20px;
    background-color: #87CEEB; /* Sky blue */
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
}

/* Form Styles */
form {
    margin: 20px auto;
    width: 80%;
    max-width: 550px;
    background-color: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: grid;
    gap: 15px;
}

form input,
form textarea,
form select,
form button {
    width: 100%;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    background-color: #fafafa;
}

form input[type="file"] {
    padding: 5px;
}

form button {
    background-color: #87CEEB; /* Sky blue */
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 18px;
}

/* Image Gallery */
.image-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
    margin: 30px auto;
    width: 80%;
}

.image-item {
    background-color: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    position: relative;
}

.image-item img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-bottom: 1px solid #ddd;
}

.image-item p {
    margin: 15px;
    font-size: 16px;
    color: #555;
}

.actions a button {
    padding: 12px 20px;
    margin: 5px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-size: 16px;
}

.delete-btn {
    background-color: #87CEEB; /* Sky blue */
    color: white;
}

.update-btn {
    background-color: #87CEEB; /* Sky blue */
    color: white;
}

/* Media Queries for Responsiveness */
@media (max-width: 768px) {
    header h1 {
        font-size: 2em;
    }

    .image-gallery {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }

    .image-item p {
        font-size: 14px;
    }
}
</style>
</head>
<body>
    <header>
        <h1>Image Gallery</h1>
        <a href="admin.php" class="go-to-admin">Go to Admin</a>
    </header>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image" required />
        <select name="category" required>
        <option value="" disabled selected>Select category</option>
        <option value="Nature">Nature</option>
        <option value="Wildlife">Wildlife</option>
        <option value="Precious_Memories">Precious_memories</option>
        <!-- Add more options as needed -->
    </select>
        <!-- <input type="text" name="category" placeholder="Enter category" required /> -->
        <textarea name="description" placeholder="Enter description" required></textarea>
        <button type="submit" name="submit">Upload Image</button>
    </form>

    <div class="image-gallery">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM sort");
        while ($row = mysqli_fetch_assoc($res)) {
        ?>
            <div class="image-item">
                <img src="Images/<?php echo $row['file']; ?>" alt="Gallery Image">
                <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
                <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                <div class="actions">
                    <a href="update.php?id=<?php echo $row['id']; ?>"><button class="update-btn">Update</button></a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this image?');"><button class="delete-btn">Delete</button></a>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>

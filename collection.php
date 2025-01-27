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

// Get filter and sort options from GET request
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';

// Start the base SQL query
$sql = "SELECT * FROM sort WHERE 1";

// Apply filtering if a category is selected
if ($filter) {
    $sql .= " AND category = '$filter'";
}

// Apply sorting based on the selected sort option
if ($sort === 'newest') {
    $sql .= " ORDER BY upload_date DESC";  // Sort by date (newest first)
} elseif ($sort === 'oldest') {
    $sql .= " ORDER BY upload_date ASC";  // Sort by date (oldest first))
}

// Execute the query
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Collection</title>
   
    <style>
        /* Add the styles as you have previously defined */
    </style>
    
</head>

<body>
<?php
        include('header.php');
        ?>
        <br>
    <!-- Header -->
    <header class="header">
       
        
        <h1>    Precious Memories-Image Collection</h1>
    </header>

    

    <!-- Filter and Sort Form -->
    <div class="filter-sort">
        <form method="GET" action="collection.php">
            <label for="filter">Filter by Category:</label>
            <select name="filter" id="filter">
                <option value="">All</option>
                <option value="Nature" <?php echo $filter == 'Nature' ? 'selected' : ''; ?>>Nature</option>
                <option value="Wildlife" <?php echo $filter == 'Wildlife' ? 'selected' : ''; ?>>Wildlife</option>
                <option value="precious_memories" <?php echo $filter == 'precious_memories' ? 'selected' : ''; ?>>precious_memories</option>
                <!-- Add other categories as needed -->
            </select>

            <label for="sort">Sort by:</label>
            <select name="sort" id="sort">
                <option value="newest" <?php echo $sort == 'date' ? 'selected' : ''; ?>>Newest first</option>
                <option value="oldest" <?php echo $sort == 'date' ? 'selected' : ''; ?>>Oldest First</option>
            </select>

            <button type="submit">Apply</button>
        </form>
    </div>

    <!-- Image Gallery -->
    <div class="image-gallery">
        <?php
        while ($row = mysqli_fetch_assoc($res)) {
            $imagePath = "images/" . $row['file'];
            if (file_exists($imagePath)) {
        ?>
            <div class="image-item">
                <img src="<?php echo $imagePath; ?>" alt="Gallery Image">
                <p><strong>Category:</strong> <?php echo $row['category']; ?></p>
                <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
            </div>
        <?php
            } else {
                echo "<p>Image not found</p>";
            }
        }
        ?>
    </div>

</body>
<?php include('footer.php'); ?>
</html>

<?php
// Close the connection
mysqli_close($conn);
?>



    <style>
        /* General Body */
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f7f7f7;
    margin: 0;
    padding: 0;
}

/* Header Styling */
header {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 20px 0;
}

header h1 {
    margin: 0;
    font-size: 2.5em;
}

/* Filter and Sort Section */
.filter-sort {
    display: flex;
    justify-content: center;
    margin: 20px 0;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.filter-sort form {
    display: flex;
    gap: 15px;
    align-items: center;
}

.filter-sort label {
    font-size: 1.1em;
    color: #333;
}

.filter-sort select, .filter-sort button {
    padding: 8px 12px;
    font-size: 1em;
    border-radius: 6px;
    border: 1px solid #ccc;
    background-color: #fff;
    color: #333;
}

.filter-sort select:focus, .filter-sort button:focus {
    outline: none;
    border-color: #007BFF;
}

.filter-sort button {
    cursor: pointer;
    background-color: #007BFF;
    color: white;
    border: none;
}

.filter-sort button:hover {
    background-color: #0056b3;
}

/* Image Gallery */
.image-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin: 40px 10%;
}

.image-item {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.image-item:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
}

.image-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

/* Admin Button Styling */
.admin-btn-container {
    margin: 20px;
    text-align: center;
}

.admin-btn {
    padding: 12px 20px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    text-decoration: none;
}

.admin-btn:hover {
    background-color: #0056b3;
}

/* Lightbox */
.lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.lightbox img {
    max-width: 90%;
    max-height: 90%;
    border-radius: 8px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
}

.lightbox:target {
    display: flex;
}

/* Close Button */
.lightbox-close {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 30px;
    color: white;
    text-decoration: none;
}


    </style>
</head>

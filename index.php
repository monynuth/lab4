<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = 'images/'; 
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 4 * 1024 * 1024; 
    
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $fileName = $_FILES['images']['name'][$key];
        $fileSize = $_FILES['images']['size'][$key];
        $fileType = $_FILES['images']['type'][$key];
        
        if (!in_array($fileType, $allowedTypes)) {
            echo "Error: Only JPG, PNG, and GIF files are allowed - $fileName<br>";
            continue;
        }
        
        if ($fileSize > $maxSize) {
            echo "Error: File size exceeds 4MB - $fileName<br>";
            continue;
        }
        
        $destination = $uploadDir . basename($fileName);
        if (move_uploaded_file($tmpName, $destination)) {
            echo "Success: $fileName uploaded!<br>";
        } else {
            echo "Error: Failed to upload $fileName<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Multiple Images</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        Upload your files:<input type="file" name="images[]" multiple accept="image/jpeg, image/png, image/gif" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
<?php
// Create database connection
//$db = mysqli_connect("localhost", "root", "", "image_upload");

// Initialize message variable
//$msg = "";

// if upload button is pressed
if (isset($_POST['upload'])) {

     $target = "images/" . basename($_FILES['image']['name']);

     $dsn = 'mysql:host=localhost;dbname=image_upload';
     $username = 'root';
     $password = '';

     try {

          $con = new PDO($dsn, $username, $password);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch (Exception $ex) {

          echo 'Not Connected to the database ' . $ex->getMessage();
     }

     // get all the submitted data from the form
     $image = $_FILES['image']['name'];
     $text = $_POST['text'];

     $sql = $con->prepare("INSERT INTO images (image, text) VALUES ('$image', '$text')");
     $sql->execute(); //stores the submitted data in the table (images)

     //lets move the upload image into the folder (images)

     if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
          $msg = "Image uploaded successfully";
     } else {
          $msg = "There was a problem uploading the image";
     }
}
$result = $pdo->query("SELECT * FROM images");
?>

<!DOCTYPE html>
<html>

<head>
     <title>Image upload</title>
     <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
     <div id="content">
          <?php
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
               echo "<div id='img_div'>";
               echo "<img src='images/" . $row['image'] . "' alt='BatAdded'>";
               echo "<p>" . $row['image_text'] . "</p>";
               echo "</div>";
          }
          ?>
          <form method="POST" action="index.php" enctype="multipart/form-data">
               <input type="hidden" name="size" value="1000000" <div>
               <input type="file" name="image">
     </div>
     <div>
          <textarea name="text" cols="40" rows="4" placeholder="say something about this image"></textarea>
     </div>
     <div>
          <input type="submit" name="upload" value="upload image">
     </div>
     </form>
     </div>
</body>

</html>
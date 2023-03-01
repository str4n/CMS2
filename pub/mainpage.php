<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
</head>
<body>
    <?php 
        $db = new mysqli('localhost', 'root', '', 'cms');

        $sql = "SELECT filename FROM post ORDER BY timestamp DESC";
        $result = $db->query($sql);

        while ($row = $result->fetch_assoc()) {
            $filename = $row['filename'];
            $url = "img/" . $filename;
            echo "<img src='$url'>";
        }

        $db->close();
    ?>
</body>
</html>
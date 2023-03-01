<?php 
    class Post {
        static function upload(string $tempFileName, string $title = "") {
            $uploadDir = "img/";

            $imgInfo = getimagesize($tempFileName);

            if(!is_array($imgInfo)) {
                die("BŁĄD: Przekazany plik nie jest obrazem!");
            }

            $randomSeed = rand(10000,99999) . hrtime(true);
            $hash = hash("sha256", $randomSeed);
            $targetFileName = $uploadDir . $hash . ".webp";

            
            if(file_exists($targetFileName)) 
            {
                die("BŁĄD: Podany plik już istnieje!");
            }


            $imageString = file_get_contents($tempFileName);

            $gdImage = @imagecreatefromstring($imageString);

            imagewebp($gdImage, $targetFileName);

            global $db;
            
            $dateTime = date("Y-m-d H:i:s");

            $sql = "INSERT INTO post (timestamp, filename, title) VALUE ('$dateTime', '$targetFileName', '$title')";

            $db->query($sql);
            $db->close();
    
        }
    }
?>

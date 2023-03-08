<?php 
    class Post {
        private string $title;
        private string $imageUrl;
        private string $timeStamp;

        function __construct(string $title, string $imageUrl, string $timeStamp)
        {
            $this->title = $title;
            $this->imageUrl = $imageUrl;
            $this->timeStamp = $timeStamp;
        }

        static function getLast() : Post {
            global $db;

            $query = $db->prepare("SELECT * FROM post ORDER BY timestamp DESC LIMIT 1");

            $query->execute();
            
            $result = $query->get_result();

            $row = $result->fetch_assoc();
            $p = new Post($row['id'], $row['filename'], $row['timestamp']);
            return $p; 
        }

        static function getPage(int $pageNumber = 1, int $pageSize = 10) {
            global $db;
            $query = $db->prepare("SELECT * FROM post LIMIT 10 OFFSET ?");
            $offset = ($pageNumber -1) * $pageSize;
            $query->bind_param('i', $offset);
            $query->execute();
            $result = $query->get_result();
            $postsArray = array();

            while ($row = $result->fetch_assoc()) {
                $post = new Post($row['title'],$row['filename'],$row['timestamp']);

                array_push($postsArray, $post);
            }

            return $postsArray;
        }


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

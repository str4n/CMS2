<form action="" method="post" enctype="multipart/form-data">
    <label for="titleInput">Tytuł: </label>
    <input type="text" id ="titleInput" name="title"><br>
    <label for="uploadedFileInput">
            Wybierz plik do wgrania na serwer:
        </label><br>
        <input type="file" name="uploadedFile" id="uploadedFileInput" required><br>
        <input type="submit" value="Wyślij plik" name="submit"><br>
    </form>

<?php
require('./../src/Post.class.php');
require('./../src/config.php');
if(isset($_POST['submit'])) 
    Post::upload($_FILES['uploadedFile']['tmp_name'], $_POST['title']);
?>
<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$title = $_POST["title"];
$description = $_POST["description"];
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is an actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check == false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $xml=simplexml_load_file("paths.xml");
        try {$sub = $xml->createElement("sub");
            $xml-> appendChild($sub);
            $title=$xml->createElement("title",$title);
            $sub->appendChild($title);
            $description=$xml->createElement("description",$description);
            $sub->appendChild($description);
            $file=$xml->createElement("file",$_FILES["fileToUpload"]["name"]);
            $sub->appendChild($file);
            $xml->save("paths.xml");
        } catch (DOMException $e) {
        }
        header("Location: display.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
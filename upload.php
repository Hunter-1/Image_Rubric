<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$title = $_POST["input_title"];
$description = $_POST["input_description"];
$x = null;
$y = null;
$new = $_POST["new"];
$file = $_FILES["fileToUpload"]["name"];
if (!$new) {
    $x = $_POST["input_x"];
    $y = $_POST["input_y"];
    $file = $_POST["input_image"];
}

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is an actual image or not
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check == false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow specific file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    echo '    <form action="reset.php" id="reset">
        <input type="submit" value="Reset" name="reset">
    </form>';
// if everything is ok, try to upload file
} else {
    if ($new) {
        //Creates a new xml File
        $xml = new SimpleXMLElement("<images/>");
        $image = $xml->addChild("image");
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }
    } else {
        //Updates Xml File
        $xml = simplexml_load_file("paths.xml");
        $location = $xml->xpath("//image[@file='$file']")[0];
        $image = $location->addChild("image");
    }
    $image->addAttribute("title", $title);
    $image->addAttribute("description", $description);
    $image->addAttribute("file", $_FILES["fileToUpload"]["name"]);
    if ($x != null || $y != null) {
        $image->addAttribute("x", $x);
        $image->addAttribute("y", $y);
    }
    //Formats the XML File
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save("paths.xml");
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        header("Location: display.php?file=" . $file);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
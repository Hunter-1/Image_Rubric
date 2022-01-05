<?php
$dirname = "uploads/";
$xml = simplexml_load_file("paths.xml");
$mainImage = $xml;
$currentImage = $mainImage;
$currentFile = $currentImage->file;
$filepath = $dirname.$currentFile;
$currentTitle = $currentImage->title;
$currentDescription = $currentImage->description;
echo '<img alt="'.$currentTitle.'"src="'.$filepath.'" /><br />';
echo '<h1>'.$currentTitle.'</h1>';
echo '<p>'.$currentDescription.'</p>';
echo '<form action="upload_new.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <label for="title">Title</label>
    <input type="text" name="title" id="title">
    <label for="description">Description</label>
    <input type="text" name="description" id="description">
    <label for="x">X Coordinates</label>
    <input type="number" name="x" id="x">
    <label for="y">Y Coordinates</label>
    <input type="number" name="y" id="y">
    <input type="submit" value="Upload" name="submit">
</form>';

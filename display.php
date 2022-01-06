<?php
$dirname = "uploads/";
$xml = simplexml_load_file("paths.xml");
$file = htmlspecialchars($_GET["file"]);
$image = $xml->xpath("//image[@file='$file']")[0];
$currentImage = $image;
$currentFile = $currentImage->attributes()->file;
$filepath = $dirname.$currentFile;
$currentTitle = $currentImage->attributes()->title;
$currentDescription = $currentImage->attributes()->description;
$xml = simplexml_load_file("paths.xml");
echo '<img alt="'.$currentTitle.'"src="'.$filepath.'" /><br />';
echo '<h1>'.$currentTitle.'</h1>';
echo '<p>'.$currentDescription.'</p>';
foreach ($currentImage->children() as $subImage){
    $subTitle = $subImage->attributes()->title;
    $subFile = $subImage->attributes()->file;

    echo '<form method="get" action="display.php?file='.$subFile.'">
    <input type="hidden" value="'.$subFile.'" name="file" id="file">
    <button type="submit">'.$subTitle.'</button>
    </form>';
}

echo '<form action="upload.php" method="post" enctype="multipart/form-data">
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
    <input type="hidden" value="'.$currentFile.'" name="image" id="image">
    <input type="submit" value="Upload" name="submit">
</form>';

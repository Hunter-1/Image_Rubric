<?php
$dirname = "uploads/";
$xml = simplexml_load_file("paths.xml");
$file = htmlspecialchars($_GET["file"]);
$image = $xml->xpath("//image[@file='$file']")[0];
$mainImage =
$currentImage = $image;
$currentFile = $currentImage->attributes()->file;
$filepath = $dirname.$currentFile;
$currentTitle = $currentImage->attributes()->title;
$currentDescription = $currentImage->attributes()->description;
$xml = simplexml_load_file("paths.xml");
echo '<head><title>Image Rubrics</title><style>
#image_container>img {
    position: relative;
}';
$i = 0;
foreach ($currentImage->children() as $subImage){
    $subTitle = $subImage->attributes()->title;
    $subFile = $subImage->attributes()->file;
    $subFile = str_replace(".", "\.",$subFile);
    $subX = $subImage->attributes()->x;
    $subY = $subImage->attributes()->y;
    echo '
#image_container>form>#'.$subFile.' {
position: absolute;
left: '.$subX.'px;
top: '.$subY.'px;
}';
    $i++;
}
echo'</style></head>';
echo '<div id="image_container">';
echo '<img onclick="imageOnClick(this)" alt="'.$currentTitle.'"src="'.$filepath.'" /><br />';
$i = 0;
foreach ($currentImage->children() as $subImage){
    $subTitle = $subImage->attributes()->title;
    $subFile = $subImage->attributes()->file;
    echo '<form method="get" action="display.php">
    <input type="hidden" value="'.$subFile.'" name="file" id="file">
    <button type="submit" id="'.$subFile.'">'.$subTitle.'</button>
    </form>';
    $i++;
}
echo '</div>';
echo '<h1>'.$currentTitle.'</h1>';
echo '<p>'.$currentDescription.'</p>';

if($currentImage != $xml->xpath("/images/image")){
    $upperImage = $currentImage->xpath("..")[0];
    $upperTitle = $upperImage->attributes()->title;
    $upperFile = $upperImage->attributes()->file;
    if ($upperFile != null){
        echo '<form method="get" action="display.php">
    <input type="hidden" value="'.$upperFile.'" name="file" id="file">
    <button type="submit">'.$upperTitle.'</button>
    </form>';
    }
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
?>
<script type="text/javascript">
    function imageOnClick()
    {
        getEventLocation(event);
    }
    function getEventLocation(eventRef)
    {
        var positionX = 0;
        var positionY = 0;

        if ( eventRef.pageX )
        {
            positionX = eventRef.pageX;
            positionY = eventRef.pageY;
        }
        else if ( window.event )
        {
            positionX = eventRef.clientX + document.body.scrollLeft;
            positionY = eventRef.clientY + document.body.scrollTop;
        }
        else if ( eventRef.clientX )
        {
            positionX = eventRef.clientX;
            positionY = eventRef.clientY;
        }
        document.getElementById("x").value = positionX;
        document.getElementById("y").value = positionY;
    }
</script>

<?php
$dirname = "uploads/";
$xml = simplexml_load_file("paths.xml");
$file = htmlspecialchars($_GET["file"]);
$image = $xml->xpath("//image[@file='$file']")[0];
$currentImage = $image;
$currentFile = $currentImage->attributes()->file;
$filepath = $dirname . $currentFile;
$currentTitle = $currentImage->attributes()->title;
$currentDescription = $currentImage->attributes()->description;
?>
<head><title>Image Rubrics</title>
    <link rel="stylesheet" href="style.css">
    <style>
        <?php
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
        }
        ?>
    </style>
</head>
<div id="image_container">
    <?php

    echo '<img onclick="imageOnClick(this)" id="image" alt="' . $currentTitle . '"src="' . $filepath . '" /><br />';

    foreach ($currentImage->children() as $subImage) {
        $subTitle = $subImage->attributes()->title;
        $subFile = $subImage->attributes()->file;
        echo '<form method="get" action="display.php">
    <input type="hidden" value="' . $subFile . '" name="file" id="file">
    <button type="submit" id="' . $subFile . '">' . $subTitle . '</button>
    </form>';
    }
    echo '</div>';
    echo '<div class="info">';
    echo '<h1 id="title">' . $currentTitle . '</h1>';
    echo '<p id="description">' . $currentDescription . '</p>';
    $i = 1;
    foreach ($currentImage->children() as $subImage) {
        $subTitle = $subImage->attributes()->title;
        echo '<p> '.$i.'. '.$subTitle.'</p>';
        $i++;
    }

    if ($currentImage != $xml->xpath("/images/image")) {
        $upperImage = $currentImage->xpath("..")[0];
        $upperTitle = $upperImage->attributes()->title;
        $upperFile = $upperImage->attributes()->file;
        if ($upperFile != null) {
            echo '<form method="get" action="display.php">
    <input type="hidden" value="' . $upperFile . '" name="file" id="file">
    <button type="submit">' . $upperTitle . '</button>
    </form>';
        }
    }
    ?>


    <form action="upload.php" method="post" enctype="multipart/form-data" id="upload_form">
        <div class="input"><label for="fileToUpload">Select image to upload:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" required></div>
        <div class="input"><label for="input_title">Title</label>
            <input type="text" name="input_title" id="input_title" required></div>
        <div class="input"><label for="input_description">Description</label>
            <input type="text" name="input_description" id="input_description" required></div>
        <p>Select Position on Image</p>
        <div class="input"><label for="input_x">X Coordinates</label>
            <input type="number" name="input_x" id="input_x" min="1" max="" required></div>
        <div class="input"><label for="input_y">Y Coordinates</label>
            <input type="number" name="input_y" id="input_y" min="1" max="" required></div>
        <input type="hidden" value=0 name="new" id="new">
        <?php
        echo '<input type="hidden" value="' . $currentFile . '" name="input_image" id="input_image">';
        ?>
        <input type="submit" value="Upload" name="submit">
    </form>
    <form action="reset.php" id="reset">
        <input type="submit" value="Reset" name="reset">
    </form>
</div>
<script type="text/javascript">
    let width = "1000";
    let height = "1000";
    document.getElementById("input_x").max = width;
    document.getElementById("input_y").max = height;
    <?php
    list($imgWidth, $imgHeight) = getimagesize($filepath);
    echo 'document.getElementById("input_x").max = "'.$imgWidth.'";
    ';
    echo 'document.getElementById("input_y").max = "'.$imgHeight.'";
    ';
    ?>
    function imageOnClick() {
        getEventLocation(event);
    }
    function getEventLocation(eventRef) {
        let positionX = 0;
        let positionY = 0;

        if (eventRef.pageX) {
            positionX = eventRef.pageX;
            positionY = eventRef.pageY;
        }  else if (eventRef.clientX) {
            positionX = eventRef.clientX;
            positionY = eventRef.clientY;
        }
        document.getElementById("input_x").value = positionX;
        document.getElementById("input_y").value = positionY;
    }
</script>

<?php
$dirname = "uploads/";
$images = glob($dirname."*.{jpg,jpeg,gif,png}",GLOB_BRACE);

foreach($images as $image) {
    echo '<img src="'.$image.'" /><br />';
}
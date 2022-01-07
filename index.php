<?php
$files = glob('uploads/*'); // get all file names
foreach($files as $file){ // iterate files
    if(is_file($file)) {
        unlink($file); // delete file
    }
}
?>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <label for="title">Title</label>
    <input type="text" name="title" id="title">
    <label for="description">Description</label>
    <input type="text" name="description" id="description">
    <input type="hidden" name="new" id="new" value=1>
    <input type="submit" value="Upload" name="submit">
</form>
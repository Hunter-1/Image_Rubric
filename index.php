
<head><title>Image Rubrics</title>
    <link rel="stylesheet" href="style.css">
</head>
<div class="info">
<form action="upload.php" method="post" enctype="multipart/form-data" id="upload_form">
    <div class="input"><label for="fileToUpload">Select image to upload:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" required></div>
    <div class="input"><label for="input_title">Title</label>
        <input type="text" name="input_title" id="input_title" required></div>
    <div class="input"><label for="input_description">Description</label>
        <input type="text" name="input_description" id="input_description" required></div>
    <input type="hidden" name="new" id="new" value=1>
    <input type="submit" value="Upload" name="submit">
</form>
</div>
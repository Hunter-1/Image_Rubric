<?php
$files = glob('uploads/*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}
header("Location: index.html");

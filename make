<?php
$sourceFilePath = 'env.example';
$destinationFilePath = '.env';

// Copy the file
if (copy($sourceFilePath, $destinationFilePath)) {
    echo "File copied successfully.\n";
} else {
    echo "Error copying the file.\n";
}

<?php
$imagesDir = './images/';
$metadataDir = './metadata/';
$safetensorsDir = './safetensors/';

$images = glob($imagesDir . '*.png');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EasyLoraWebShop</title>
    <style>
        body {
            background-color: #333;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .item {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #222;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
        }
        img {
            max-width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        .name, .download {
            margin-top: 10px;
        }
        a {
            color: #4aa;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .refresh-button {
            position: absolute;
            top: 10px;
            left: 10px;
            color: #4aa;
            cursor: pointer;
        }
    </style>
</head>
<body>
<a class="refresh-button" href="./create_meta.php" target="_blank">Refresh metadata</a>
<div class="gallery">
    <?php foreach ($images as $image): 
        $baseName = basename($image, '.png');
        $infoLink = "./info.php?modelname=" . urlencode($baseName);
        $safetensorFile = $safetensorsDir . $baseName . '.safetensors';
    ?>
    <div class="item">
        <a href="<?= htmlspecialchars($infoLink) ?>" target="_blank">
            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($baseName) ?>">
        </a>
        <div class="name"><?= htmlspecialchars($baseName) ?></div>
        <div class="download">
            <a href="<?= htmlspecialchars($safetensorFile) ?>" download="<?= htmlspecialchars($baseName) ?>.safetensors">Download Safetensor</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>MetaStore - <?php if(isset($_GET['modelname'])) echo htmlspecialchars($_GET['modelname']); ?></title>
    <style>
        body {
            background-color: #333; /* Setzt die Hintergrundfarbe der gesamten Seite auf Schwarz */
            color: white; /* Setzt die Textfarbe auf Weiß */
        }
        table {
            border-collapse: collapse;
            width: 100%; /* Stellt sicher, dass die Tabelle die volle Breite einnimmt */
        }
        table, th, td {
            border: 1px solid white; /* Setzt die Rahmenfarbe auf Weiß */
        }
        th, td {
            padding: 10px; /* Fügt Abstand innerhalb der Zellen hinzu */
            text-align: left; /* Textausrichtung links */
        }
    </style>
</head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_GET['modelname'])) {
    $modelName = $_GET['modelname'];
    $filePath = "./metadata/" . $modelName . ".safetensors.txt";

    if(file_exists($filePath)) {
        $fileContent = file_get_contents($filePath);
        $metadata = json_decode($fileContent, true);

        echo "<div style='background-color: #333; color: white; padding: 20px;'>";

        $keysToExtract = [
            'ss_output_name' => 'Model Name',
            'ss_dataset_dirs' => 'Model Directorys',
            'ss_tag_frequency' => 'Model Tags',
            'ss_sd_model_name' => 'Base Model Name',
            'ss_base_model_version' => 'Base Model Version',
            'modelspec.architecture' => 'Base Model Architecture',
            'ss_sd_model_hash' => 'Hash',
            'ss_sd_scripts_commit_hash' => 'Commitment Hash'
        ];

        $data = [];

        foreach($keysToExtract as $key => $displayName) {
            if(isset($metadata[$key])) {
                $value = $metadata[$key];
                if($key == 'ss_tag_frequency') {
                    $tagsArray = json_decode($value, true); // JSON-String zu einem Array decodieren
                    if(is_array($tagsArray)) {
                        $formattedValue = '';
                        foreach($tagsArray as $tagCategory => $tags) {
                            foreach($tags as $tag => $count) {
                                $formattedValue .= htmlspecialchars($tag) . ": " . htmlspecialchars($count) . "<br>";
                            }
                        }
                    } else {
                        $formattedValue = 'Keine Tags verfügbar';
                    }
                } else {
                    $formattedValue = is_array($value) ? json_encode($value) : htmlspecialchars($value);
                }
                $data[$displayName] = $formattedValue;
            }
        }

        echo "<table>";
        foreach($data as $displayName => $value) {
            echo "<tr><td><strong>$displayName</strong></td><td>" . nl2br($value) . "</td></tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p>Datei nicht gefunden.</p>";
    }
} else {
    echo "<p>Modellname wurde nicht angegeben.</p>";
}
?>

</body>
</html>

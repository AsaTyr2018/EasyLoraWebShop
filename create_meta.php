
<?php

$safetensorsPfad = __DIR__ . '/safetensors';
$metadataPfad = __DIR__ . '/metadata';

#if (!file_exists($metadataPfad)) {
#    mkdir($metadataPfad, 0777, true);
#}

$dateien = glob($safetensorsPfad . '/*.safetensors');

echo "<!DOCTYPE html>
<html>
<head>
    <title>Safetensors Metadata Report</title>
    <style>
        body { background-color: #000; color: #fff; font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #fff; }
        th { background-color: #222; }
        .success { color: #4CAF50; }
        .error { color: #F44336; }
    </style>
</head>
<body>
    <h2>Safetensors Metadata Report</h2>
    <table>
        <tr>
            <th>Datei</th>
            <th>Status</th>
        </tr>";

foreach ($dateien as $datei) {
    $dateiInfo = pathinfo($datei);
    $neueDateiName = $metadataPfad . '/' . $dateiInfo['basename'] . '.txt';

    if (file_exists($neueDateiName)) {
        echo "<tr><td>{$dateiInfo['basename']}</td><td class='error'>Skipped (File Existing)</td></tr>";
        continue;
    }

    $handle = fopen($datei, 'rb');
    if ($handle === false) {
        echo "<tr><td>{$dateiInfo['basename']}</td><td class='error'>Failed to open file.</td></tr>";
        continue;
    }

    $bytes = fread($handle, 8);
    $length = unpack('P', $bytes)[1]; 

    $jsonString = fread($handle, $length);
    fclose($handle);

    $daten = json_decode($jsonString, true);

    if (!isset($daten['__metadata__'])) {
        echo "<tr><td>{$dateiInfo['basename']}</td><td class='error'>No Data Found '__metadata__'.</td></tr>";
        continue;
    }

    file_put_contents($neueDateiName, json_encode($daten['__metadata__'], JSON_PRETTY_PRINT));
    echo "<tr><td>{$dateiInfo['basename']}</td><td class='success'>Metadata Extracted Successful</td></tr>";
}

echo "
    </table>
</body>
</html>";
?>

<?php
// Replace this with your data source logic
$data = [
    "Label 1" => 30,
    "Label 2" => 40,
    "Label 3" => 20,
    "Label 4" => 10,
];

header("Content-Type: application/json");
echo json_encode($data);
?>

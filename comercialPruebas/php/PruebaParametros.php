<?php
$datos = $_REQUEST;
header('Content-Type: application/json');
echo json_encode($datos);
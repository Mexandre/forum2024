<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-type: application/json'); 
$response = ['success' => false, 'msg' => 'Une erreur inattendue s\'est produite'];
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);
require_once('../config/bdd.php');
if ($method == 'GET') {
}
if ($method == 'POST') {
}
if ($method == 'PATCH') {
}
if ($method == 'PUT') {
}
if ($method == 'DELETE') {
}
echo json_encode($response);
?>
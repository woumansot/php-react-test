<?php
// api.php

header('Content-Type: application/json');

// Read raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Basic validation
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

if (!isset($data['cmd'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing "cmd" parameter']);
    exit;
}

// Allowed commands (add to this array as you expand)
$allowed_commands = ['echo', 'your_new_command'];

$cmd = $data['cmd'];
if (!in_array($cmd, $allowed_commands)) {
    http_response_code(400);
    echo json_encode(['error' => "Invalid command '$cmd'"]);
    exit;
}

// Command handlers
$rc = array(
    'status' => 'error',
    'message' => 'Command not found',
    'data' => null
);
switch ($cmd) {
    case 'echo':
        $rc = doEcho($data['data'] ?? '');
        break;

        // Add new cases here as you expand
}
header("Content-Type: application/json");
echo json_encode($rc);

function doEcho($data)
{
    $returnData = array(
        'status' => 'ok',
        'message' => 'Echo command executed successfully',
        'data' => $data
    );
    return $returnData;
}

// Define additional command handler functions here

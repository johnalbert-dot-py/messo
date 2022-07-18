<?php


function return_json_response($json_data, $status_code = 200)
{
    header('Content-Type: application/json');
    http_response_code($status_code);
    echo json_encode($json_data);
}

function return_error_response($error_reason = "", $error_description = "", $error_code = 0)
{
    $error = [
        "error" => true,
        "reason" => $error_reason,
        "description" => $error_description,
        "code" => $error_code
    ];

    return return_json_response($error, 400);
}

function return_success_response($success_reason = "", $success_description = "", $data = [])
{
    $success = [
        "error" => false,
        "reason" => $success_reason,
        "description" => $success_description,
        "data" => $data
    ];

    return return_json_response($success, 200);
}

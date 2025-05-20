<?php
include 'connection.php';
include 'helper.php';

try {

    $sql = "SELECT * FROM notices";

    $result = mysqli_query($con, $sql);


    if (!$result) {

        echo json_encode([
            "success" => false,
            "message" => "Failed to fetch notices."
        ]);
        die();
    }


    $notices = mysqli_fetch_all($result, MYSQLI_ASSOC);


    echo json_encode([
        "success" => true,
        "message" => "Notices fetched successfully.",
        "data" => $notices
    ]);
} catch (\Throwable $th) {
    echo json_encode([
        "success" => false,
        "message" => $th->getMessage()
    ]);
}

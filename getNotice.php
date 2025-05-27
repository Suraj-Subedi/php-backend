<?php
include 'connection.php';
include 'helper.php';

try {

    $sql = "SELECT * FROM notices where deleted_at IS NULL ORDER BY created_at DESC";

    $result = mysqli_query($con, $sql);


    if (!$result) {

        echo json_encode([
            "success" => false,
            "message" => "Failed to fetch notices."
        ]);
        die();
    }


    $notices = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $sql = "SELECT COUNT(*) as total FROM notices WHERE deleted_at IS NULL";
    $countResult = mysqli_query($con, $sql);
    if (!$countResult) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to count notices."
        ]);
        die();
    }
    $countRow = mysqli_fetch_assoc($countResult);


    echo json_encode([
        "success" => true,
        "message" => "Notices fetched successfully.",
        "data" => $notices,
        "total" => $countRow['total']
    ]);
} catch (\Throwable $th) {
    echo json_encode([
        "success" => false,
        "message" => $th->getMessage()
    ]);
}

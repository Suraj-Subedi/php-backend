<?php
include 'connection.php';
include 'helper.php';

try {

    if (!isset($_POST["token"])) {
        echo json_encode([
            "success" => false,
            "message" => "Login is required.!"
        ]);
        die();
    }


    $token = $_POST["token"];
    $user_id = getUserIdFromToken($token, $con);

    if (!$user_id) {
        echo json_encode([
            "success" => false,
            "message" => "Your are not authorized user.!"
        ]);
        die();
    }


    if (!isset($_POST["notice_id"])) {
        echo json_encode([
            "success" => false,
            "message" => "Notice ID is required."
        ]);
        die();
    }



    $sql = "UPDATE notices SET deleted_at = NOW() WHERE notice_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $_POST["notice_id"]);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$result) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to delete notice."
        ]);
        die();
    }

    echo json_encode([
        "success" => true,
        "message" => "Notice deleted successfully."
    ]);
} catch (\Throwable $th) {
    echo json_encode([
        "success" => false,
        "message" => $th->getMessage()
    ]);
}

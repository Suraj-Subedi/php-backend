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



    $sql = "SELECT * FROM inquiries";

    $result = mysqli_query($con, $sql);


    if (!$result) {

        echo json_encode([
            "success" => false,
            "message" => "Failed to fetch inquiries."
        ]);
        die();
    }


    $inquiries = mysqli_fetch_all($result, MYSQLI_ASSOC);


    echo json_encode([
        "success" => true,
        "message" => "Inquiries fetched successfully.",
        "data" => $inquiries
    ]);
} catch (\Throwable $th) {
    echo json_encode([
        "success" => false,
        "message" => $th->getMessage()
    ]);
}

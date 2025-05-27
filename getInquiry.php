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

    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $page_size = isset($_GET["page_size"]) ? (int)$_GET["page_size"] : 10;
    $offset = ($page - 1) * $page_size;




    $sql = "SELECT * FROM inquiries ORDER BY created_at DESC LIMIT $page_size OFFSET $offset";

    $result = mysqli_query($con, $sql);


    if (!$result) {

        echo json_encode([
            "success" => false,
            "message" => "Failed to fetch inquiries."
        ]);
        die();
    }


    $inquiries = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $sql = "SELECT COUNT(*) as total FROM inquiries";
    $countResult = mysqli_query($con, $sql);
    if (!$countResult) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to count inquiries."
        ]);
        die();
    }
    $countRow = mysqli_fetch_assoc($countResult);
    $total = $countRow['total'];


    echo json_encode([
        "success" => true,
        "message" => "Inquiries fetched successfully.",
        "data" => $inquiries,
        "total" => $total,
        "total_pages" => ceil($total / $page_size)
    ]);
} catch (\Throwable $th) {
    echo json_encode([
        "success" => false,
        "message" => $th->getMessage()
    ]);
}

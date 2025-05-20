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

    if (isset($_POST["title"], $_POST["description"], $_FILES["notice_file"])) {

        $title = $_POST["title"];
        $description = $_POST["description"];
        $file = $_FILES["notice_file"];



        // Validate file upload
        $size = $file['size'];
        $type = $file['type'];
        $name = $file['name'];
        $tmp_name = $file['tmp_name'];

        $file_extension = pathinfo($name, PATHINFO_EXTENSION);

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];


        if (!in_array($file_extension, $allowed_extensions)) {
            echo json_encode([
                "success" => false,
                "message" => "File type not allowed. Allowed types: jpg, jpeg, png, pdf."
            ]);
            die();
        }


        if ($size > 5 * 1024 * 1024 && $file_extension !== "pdf") { // 5MB limit
            echo json_encode([
                "success" => false,
                "message" => "File size exceeds the limit of 5MB for images."

            ]);
            die();
        } else if ($size > 20 * 1024 * 1024 && $file_extension === "pdf") { // 20MB limit for pdf
            echo json_encode([
                "success" => false,
                "message" => "File size exceeds the limit of 20MB for PDF files."
            ]);
            die();
        }

        $new_name = uniqid() . '.' . $file_extension;
        $upload_path = 'uploads/' . $new_name;

        if (!move_uploaded_file($tmp_name, $upload_path)) {
            echo json_encode([
                "success" => false,
                "message" => "Failed to upload file."
            ]);
            die();
        }

        $sql = "INSERT INTO notices (title, description, file_url)
                VALUES ('$title', '$description', '$upload_path')";

        $result = mysqli_query($con, $sql);


        if (!$result) {
            echo json_encode([
                "success" => false,
                "message" => "Failed to add notice."
            ]);
            die();
        }

        echo json_encode([
            "success" => true,
            "message" => "Notice added successfully!",
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "title, description, and notice_file are required."
        ]);
    }
} catch (\Throwable $th) {
    echo json_encode([
        "success" => false,
        "message" => $th->getMessage()
    ]);
}

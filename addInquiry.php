<?php
include 'connection.php';

try {

    //first_name, last_name, email, phone_number,message

    if (isset($_POST["first_name"], $_POST["last_name"], $_POST["email"], $_POST["phone_number"], $_POST["message"])) {

        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        $phone_number = $_POST["phone_number"];
        $message = $_POST["message"];


        $sql = "INSERT INTO inquiries (first_name, last_name, email, phone_number, message)
                VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$message')";

        $result = mysqli_query($con, $sql);


        if (!$result) {
            echo json_encode([
                "success" => false,
                "message" => "Failed to add inquiry."
            ]);
            die();
        }

        echo json_encode([
            "success" => true,
            "message" => "Inquiry added successfully!"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "first_name, last_name, email, phone_number, and message are required."
        ]);
    }
} catch (\Throwable $th) {
    echo json_encode([
        "success" => false,
        "message" => $th->getMessage()
    ]);
}

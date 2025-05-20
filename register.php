<?php
include 'connection.php';

try {
    if (isset($_POST["email"], $_POST["password"], $_POST["full_name"])) {

        $email = $_POST["email"];
        $password = $_POST["password"];
        $fullname = $_POST["full_name"];


        $sql = "select * from users where email='$email'";

        $result = mysqli_query($con, $sql);


        $count = mysqli_num_rows($result);

        if ($count > 0) {
            echo json_encode([
                "success" => false,
                "message" => "Email is already registered!"
            ]);
            die();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "insert into users (email, password, full_name,role) values ('$email', '$hashed_password', '$fullname','admin')";

        $result = mysqli_query($con, $sql);


        if (!$result) {
            echo json_encode([
                "success" => false,
                "message" => "Failed to register user."
            ]);
            die();
        }


        echo json_encode([
            "success" => true,
            "message" => "User registered successfully!"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "email, password, and full_name are required."
        ]);
    }
} catch (\Throwable $th) {
    echo json_encode([
        "success" => false,
        "message" => $th->getMessage()
    ]);
}

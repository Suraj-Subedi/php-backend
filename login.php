<?php
include 'connection.php';

try {
    if (isset($_POST["email"], $_POST["password"])) {

        $email = $_POST["email"];
        $password = $_POST["password"];


        $sql = "select * from users where email='$email'";

        $result = mysqli_query($con, $sql);


        $count = mysqli_num_rows($result);

        if ($count === 0) {
            echo json_encode([
                "success" => false,
                "message" => "Email is not registered!"
            ]);
            die();
        }


        $user = mysqli_fetch_assoc($result);

        $verify_password = password_verify($password, $user['password']);


        if (!$verify_password) {
            echo json_encode([
                "success" => false,
                "message" => "Incorrect password!"
            ]);
            die();
        }

        $token = bin2hex(random_bytes(16));
        $user_id = $user['user_id'];



        $sql = "insert into tokens (user_id, token) values ('$user_id', '$token')";

        $result = mysqli_query($con, $sql);


        if (!$result) {
            echo json_encode([
                "success" => false,
                "message" => "Failed to login user."
            ]);
            die();
        }


        echo json_encode([
            "success" => true,
            "message" => "User logged in successfully!",
            "token" => $token,
            "user_id" => $user_id,
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "email, password are required."
        ]);
    }
} catch (\Throwable $th) {
    echo json_encode([
        "success" => false,
        "message" => $th->getMessage()
    ]);
}

<?php
//function to return userId from token
// getUserIdFromToken

function getUserIdFromToken($token, $con)
{

    $sql = "SELECT user_id FROM tokens WHERE token = '$token'";

    $result = mysqli_query($con, $sql);

    if (!$result) {
        return null; // Query failed
    }

    if (mysqli_num_rows($result) === 0) {
        return null; // No token found
    }

    $row = mysqli_fetch_assoc($result);

    return $row['user_id']; // Return user_id associated with the token
}

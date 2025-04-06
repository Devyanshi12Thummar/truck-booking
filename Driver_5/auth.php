<?php
function session_setting($conn,$user_email,$password)
{
    $sql = "SELECT * FROM truck_driver WHERE driver_email = '$user_email' AND driver_password = '$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
    return $row['driver_id'];
}

function login($conn, $user_email, $password) {
    $response = array();

    $user_email = mysqli_real_escape_string($conn, $user_email); // Prevent SQL injection

    $sql = "SELECT * FROM truck_driver WHERE driver_email = '$user_email' AND driver_password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $code = "database_error";
        $mess = "Error in Database Query";
        $response["code"] = $code;
        $response["message"] = $mess;
    } else if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row["driver_email"];
        $password = $row["driver_password"];
        $code = 'login_successfully';
        $response["code"] = $code;
        $response["email"] = $email;
        $response["password"] = $password;
    } else {
        $code = "login_failed";
        $mess = "Invalid email and password";
        $response["code"] = $code;
        $response["message"] = $mess;
    }

    return $response;
}

function changePassword($conn, $email, $oldPassword, $newPassword, $confirmPassword) {
    $response = array();

    // Validate and sanitize user input
    $email = mysqli_real_escape_string($conn, $email);
    $oldPassword = mysqli_real_escape_string($conn, $oldPassword);
    $newPassword = mysqli_real_escape_string($conn, $newPassword);
    $confirmPassword = mysqli_real_escape_string($conn, $confirmPassword);

    // Check if passwords match
    if ($newPassword === $confirmPassword) {
        // Verify the old password (you should hash and salt passwords for security)
        $query = "SELECT * FROM truck_driver WHERE driver_email='$email' AND driver_password='$oldPassword'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            $code = "database_error";
            $mess = "Error in Database Query";
            $response["code"] = $code;
            $response["message"] = $mess;
        } elseif (mysqli_num_rows($result) === 1) {
            // Hash and salt the new password before storing it
            // $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password
            $updateQuery = "UPDATE truck_driver SET driver_password='$newPassword' WHERE driver_email='$email'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                $code = "password_changed";
                $mess = "Password updated successfully";
                $response["code"] = $code;
                $response["message"] = $mess;
            } else {
                $code = "database_error";
                $mess = "Failed to update password";
                $response["code"] = $code;
                $response["message"] = $mess;
            }
        } else {
            $code = "invalid_password";
            $mess = "Incorrect old password";
            $response["code"] = $code;
            $response["message"] = $mess;
        }
    } else {
        $code = "password_mismatch";
        $mess = "New passwords do not match";
        $response["code"] = $code;
        $response["message"] = $mess;
    }

    return $response;
}
?>

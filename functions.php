<?php 
$conn = mysqli_connect("localhost", "root", "", "tugas_besar");

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password1 = mysqli_real_escape_string($conn, $data["password1"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    if($password1 !== $password2) {
        echo "<script>alert('Konfirmasi password tidak sesuai')</script>";
        return false;
    }

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username telah terdaftar')</script>";
        return false;
    }

    $password1 = password_hash($password1, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users(username, password) VALUES ('$username', '$password1')");

    return mysqli_affected_rows($conn);
}
?>
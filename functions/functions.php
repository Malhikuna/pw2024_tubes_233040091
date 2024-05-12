<?php 
$conn = mysqli_connect("localhost", "root", "", "pw2024_tubes_233040091");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;

}

function registrasi($data) {
    global $conn;

    $email = strtolower($data["email"]);
    $username = ucwords(stripslashes($data["username"]));
    $password1 = mysqli_real_escape_string($conn, $data["password1"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    if($password1 !== $password2) {
        echo "<script>alert('Konfirmasi password tidak sesuai')</script>";
        return false;
    }

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    if(mysqli_fetch_assoc($result)) {
        echo "<script>alert('Email sudah terdaftar')</script>";
        return false;
    }

    $password1 = password_hash($password1, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users(email, username, password) VALUES ('$email', '$username', '$password1')");

    return mysqli_affected_rows($conn);
}


function upload($data) {
    global $conn;
    // ambil data dari tiap elemen dalam form
    $course_name = htmlspecialchars($data["course_name"]);
    $price = htmlspecialchars($data["price"]);
    $channel_name = htmlspecialchars($data["channel_name"]);
    $video_name = htmlspecialchars($data["video_name"]);
    $description = htmlspecialchars($data["description"]);

    // Cek Catagory
    switch($data["catagory"]) {
        case "Frontend Developer":
            $catagory = 1;
            break;
        case "Backend Developer":
            $catagory = 2;
            break;
    }

    // Upload gambar
    $thumbnail = uploadImage();
    if(!$thumbnail) {
        return false;
    }

    // Upload video
    $video = uploadVideo();
    if(!$video) {
        return false;
    }

    //  query insert data
    $query1 = "INSERT INTO courses(catagory_id, name, channel_name, thumbnail, price)
                VALUES
                ('$catagory', '$course_name', '$channel_name', '$thumbnail', '$price')
                ";

    mysqli_query($conn, $query1);
    
    if(mysqli_affected_rows($conn) > 0) {

        $course_id = query("SELECT id FROM courses WHERE name = '$course_name'");

        // $courseId = $course_id["id"];

        foreach($course_id as $id) {
            $courseId = $id["id"];
        }
     
        $query2 = "INSERT INTO course_video(video_name, description, courses_id)
                    VALUES
                    ('$video_name', '$description', '$courseId')";

        mysqli_query($conn, $query2);

        return mysqli_affected_rows($conn);      
    }

    return false;
}

function uploadImage() {
    $namaFile = $_FILES['thumbnail']['name'];
    $ukuranFile = $_FILES['thumbnail']['size'];
    $error = $_FILES['thumbnail']['error'];
    $tmpName = $_FILES['thumbnail']['tmp_name'];

    // Cek apakah tidak ada gambar yang diupload
    if( $error === 4) {
        echo "<script>
                alert('Pilih gambar terlebih dahulu!');
            </script>";
        return false;
    }

    // Cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('Yang anda upload bukan gambar!');
            </script>";
        return false;
    }

    // Cek jika ukurannya terlalu besar
    if( $ukuranFile > 1000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar!');
            </script>";
        return false;
    }

    // Generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    // Lolos pengecekan, gambar siap diupload
    move_uploaded_file($tmpName, '../img/' . $namaFileBaru);

    return $namaFileBaru;
}

function uploadVideo() {
    $namaFile = $_FILES['video']['name'];
    $ukuranFile = $_FILES['video']['size'];
    $error = $_FILES['video']['error'];
    $tmpName = $_FILES['video']['tmp_name'];

    // Cek apakah tidak ada video yang diupload
    if( $error === 4) {
        echo "<script>
                alert('Pilih video terlebih dahulu!');
            </script>";
        return false;
    }

    // Cek apakah yang diupload adalah video
    $ekstensiVideoValid = ['mp4', 'mpv'];
    $ekstensiVideo = explode('.', $namaFile);
    $ekstensiVideo = strtolower(end($ekstensiVideo));

    if(!in_array($ekstensiVideo, $ekstensiVideoValid)) {
        echo "<script>
                alert('Yang anda upload bukan video!');
            </script>";
        return false;
    }

    // Cek jika ukurannya terlalu besar
    if( $ukuranFile > 1000000) {
        echo "<script>
                alert('Uuran video terlalu besar!');
            </script>";
        return false;
    }

    // Generate nama video baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiVideo;

    // Lolos pengecekan, video siap diupload
    move_uploaded_file($tmpName, '../videos/' . $namaFileBaru);

    return $namaFileBaru;
}

function user($data) {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$data'");
    $row = mysqli_fetch_assoc(($result));
    $username = ucwords($row["username"]);

    return $username;
}

function search($keyword) {
    $query = "SELECT *, courses.id as courses_id FROM courses JOIN catagories ON (courses.catagory_id = catagories.id)
            WHERE
            name LIKE '%$keyword%' OR
            channel_name LIKE '%$keyword%'
    ";
    
    return query($query);
}

?>
<?php 
// $conn = mysqli_connect("localhost", "root", "", "pw2024_tubes_233040091");
$conn = mysqli_connect("localhost", "id22297404_malhikuna", "OhA0a#MYZakF*ymT", "id22297404_pw2024_tubes_233040091");

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

    $email = htmlspecialchars(strtolower($data["email"]));
    $phone = htmlspecialchars($data["phone"]);
    $username = htmlspecialchars(ucwords(stripslashes($data["username"])));
    $password1 = htmlspecialchars(mysqli_real_escape_string($conn, $data["password1"]));

    $password1 = password_hash($password1, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users(email, username, password, phone) VALUES ('$email', '$username', '$password1', '$phone')");

    if(mysqli_affected_rows($conn) > 0) {
        $userId = query("SELECT id FROM users WHERE email = '$email'")[0]["id"];

        mysqli_query($conn, "INSERT INTO profile(user_id) VALUES('$userId')");

        return mysqli_affected_rows($conn);
    }

    return false;
}


function uploadCourse($data) {
    global $conn;
    // ambil data dari tiap elemen dalam form
    $courseName = htmlspecialchars($data["courseName"]);
    $price = htmlspecialchars($data["price"]);
    $userId = htmlspecialchars($data["userId"]);
    $videoName = htmlspecialchars($data["videoName"]);
    $description = htmlspecialchars($data["description"]);
    $categoryId = $data["category"];

    // Upload gambar
    $thumbnail = uploadImage('thumbnail', '../img/thumbnail/');
    if(!$thumbnail) {
        return false;
    }

    // Upload video
    $video = uploadVideo();
    if(!$video) {
        return false;
    }

    //  query insert data
    $query1 = "INSERT INTO courses(category_id, user_id, name, thumbnail, price)
                VALUES
                ('$categoryId', '$userId', '$courseName', '$thumbnail', '$price')
                ";

    mysqli_query($conn, $query1);
    
    if(mysqli_affected_rows($conn) > 0) {

        $courseId = query("SELECT id FROM courses WHERE name = '$courseName'")[0]["id"];

        $query2 = "INSERT INTO videos(video_name, description, video, course_id)
            VALUES
            ('$videoName', '$description', '$video', '$courseId')";

        mysqli_query($conn, $query2);

        return mysqli_affected_rows($conn);      
    }

    return false;
}

function uploadImage($name, $folder) {
    $namaFile = $_FILES[$name]['name'];
    $ukuranFile = $_FILES[$name]['size'];
    $error = $_FILES[$name]['error'];
    $tmpName = $_FILES[$name]['tmp_name'];

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
    move_uploaded_file($tmpName, $folder . $namaFileBaru);

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
    if( $ukuranFile > 100000000000) {
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
    $result = mysqli_query($conn, "SELECT * 
                                    FROM users 
                                    WHERE email = '$data'");
    $row = mysqli_fetch_assoc(($result));
    $username = ucwords($row["username"]);

    return $username;
}

function search($keyword) {
    $jumlahDataPerHalaman = 9;
    $jumlahData = count(query("SELECT *, courses.id as courses_id 
                                FROM courses 
                                JOIN categories ON (courses.category_id = categories.id)
                                ORDER BY courses.id DESC"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
    $halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;

    $dataAwal = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

    $query = "SELECT *, courses.id as courseId, users.id as userId 
                FROM courses 
                JOIN categories ON (courses.category_id = categories.id) 
                JOIN users ON (courses.user_id = users.id)
                JOIN profile ON (users.id = profile.user_id)
                WHERE name 
                LIKE '%$keyword%' 
                OR username 
                LIKE '%$keyword%'
                ORDER BY courses.id DESC 
                LIMIT $dataAwal, $jumlahDataPerHalaman
    ";

    return query($query);
}

function updateCourse($data) {
    global $conn;
    // ambil data dari tiap elemen dalam form
    $id = $data["id"];
    $courseName = htmlspecialchars($data["courseName"]);
    $price = htmlspecialchars($data["price"]);
    $category = $data["category"];
    $oldThumbnail = ($data["oldThumbnail"]);

    // Cek apakah user pilih gambar baru atau tidak
    if( $_FILES['thumbnail']['error'] === 4) {
        $thumbnail = $oldThumbnail;
    } else {
        $thumbnail = uploadImage('thumbnail', '../img/thumbnail/');
    }

    //  query update data
    $query = "UPDATE courses 
                SET
                name = '$courseName',
                price = '$price',
                category_id = '$category',
                thumbnail = '$thumbnail'
                WHERE courses.id = $id 
                ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function delete($id, $videos) {
    global $conn;

    if($videos > 0) {
        mysqli_query($conn, "DELETE courses, videos
                             FROM courses
                             JOIN videos
                             ON courses.id = course_id
                             WHERE courses.id = $id");
    
        return mysqli_affected_rows($conn);
    } else {
        mysqli_query($conn, "DELETE
                             FROM courses
                             WHERE courses.id = $id");
    
        return mysqli_affected_rows($conn);
    }
}

// Dashboard Functions

function deleteVideo($id) {
    global $conn;
    mysqli_query($conn, "DELETE
                         FROM videos
                         WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function deleteCategory($id) {
    global $conn;
    mysqli_query($conn, "DELETE
                         FROM categories
                         WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function addCategory($data) {
    global $conn;

    $category = htmlspecialchars($data["category"]);

    $result = mysqli_query($conn, "SELECT * FROM categories WHERE category_name = '$category'");

    if(mysqli_fetch_assoc($result)) {
        return false;
    }

    mysqli_query($conn, "INSERT INTO categories
                                    (category_name)
                                    VALUES
                                    ('$category')");

    return mysqli_affected_rows($conn);
}

function updateCategory($data) {
    global $conn;

    $categoryName = htmlspecialchars($data["categoryName"]);
    $id = $data["id"];

    mysqli_query($conn, "UPDATE categories
                            SET category_name = '$categoryName' 
                            where categories.id = $id");
    return mysqli_affected_rows($conn);
}

function addVideo($data) {
    global $conn;

    $videoName = htmlspecialchars($data["videoName"]);
    $description = htmlspecialchars($data["description"]);
    $courseId = $data["courseId"];

    $video = uploadVideo();
    if(!$video) {
        return false;
    }
    
    $query = "INSERT INTO videos(video_name, description, video, course_id)
                VALUES
                ('$videoName', '$description', '$video', '$courseId')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updateVideo($data) {
    global $conn;
    // ambil data dari tiap elemen dalam form
    $videoId = $data["id"];
    $videoName = htmlspecialchars($data["videoName"]);
    $description = htmlspecialchars($data["description"]);
    $oldVideo = $data["oldVideo"];

    // Cek apakah user pilih video baru atau tidak
    if( $_FILES['video']['error'] === 4) {
        $video = $oldVideo;
    } else {
        $video = uploadVideo();
    } 

    //  query update data
    $query = "UPDATE videos 
                SET
                video_name = '$videoName',
                description = '$description',
                video = '$video'
                WHERE id = $videoId 
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function editProfile($data) {
    global $conn;

    $username = htmlspecialchars($data["username"]);
    $description = htmlspecialchars($data["description"]);
    $birth = htmlspecialchars($data["birth"]);
    $instagram = htmlspecialchars($data["instagram"]);
    $linkedin = htmlspecialchars($data["linkedin"]);
    $facebook = htmlspecialchars($data["facebook"]);
    $youtube = htmlspecialchars($data["youtube"]);
    $profilePicture = htmlspecialchars($data["oldProfilePicture"]);
    $userId = $data["userId"];
 
    mysqli_query($conn, "UPDATE profile 
                        JOIN users 
                        ON
                        (user_id = users.id)
                        SET 
                        users.username = '$username',
                        description = '$description',
                        birth = '$birth',
                        image = '$profilePicture',
                        instagram = '$instagram',
                        linkedin = '$linkedin',
                        facebook = '$facebook',
                        youtube = '$youtube' 
                        where user_id = $userId");

    return mysqli_affected_rows($conn);
}

function editProfilePicture($data) {
    global $conn;

    $oldProfilePicture = $data["oldProfilePicture"];
    $userId = $data["userId"];


    if( $_FILES['profilePicture']['error'] === 4) {
        $profilePicture = $oldProfilePicture;
    } else {
        $profilePicture = uploadImage('profilePicture', '../img/profile/');
    } 
 
    mysqli_query($conn, "UPDATE profile 
                        JOIN users 
                        ON
                        (user_id = users.id)
                        SET 
                        image = '$profilePicture' 
                        where user_id = $userId");

    return mysqli_affected_rows($conn);
}

function videoLiked($vId, $uId) {
    global $conn;

    $query = "INSERT INTO `video_likes` (`id`, `video_id`, `user_id`) VALUES (NULL, '$vId', '$uId')";

    mysqli_query($conn, $query);
}

function videoUnliked($vId, $uId) {
    global $conn;

    $query = "DELETE FROM video_likes WHERE video_id = $vId AND user_id = $uId";

    mysqli_query($conn, $query);
}

function jumlah($tabel) {
    global $conn;

    $result = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM $tabel"));

    return $result;
}

function saveTo($videoId, $playlistId) {
    global $conn;

    $query = "INSERT INTO video_playlist (video_id, playlist_id) VALUES ('$videoId', '$playlistId')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function unSave($videoId, $playlistId) {
    global $conn;

    $query = "DELETE FROM video_playlist 
                WHERE video_id = $videoId 
                AND playlist_id = $playlistId";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function addNewPlaylist($data) {
    global $conn;

    $videoId = $data["videoId"];
    $newPlaylist = htmlspecialchars($data["newPlaylist"]);
    $userId = $data["userId"];

    $query1 = "INSERT INTO playlist (user_id, name) VALUES ('$userId', '$newPlaylist')";

    $result = mysqli_query($conn ,"SELECT * FROM playlist WHERE user_id = $userId AND name = '$newPlaylist'");

    if(mysqli_fetch_assoc($result)) {
        return false;
    }

    mysqli_query($conn, $query1);

    if(mysqli_affected_rows($conn) > 0) {
        $playlistId = query("SELECT id FROM playlist WHERE user_id = $userId AND name = '$newPlaylist'")[0]["id"];

        $query2 = "INSERT INTO video_playlist (video_id, playlist_id) VALUES ('$videoId', '$playlistId')";

        mysqli_query($conn, $query2);

        return mysqli_affected_rows($conn);
    }

    return false;
}

function addToCart($uId, $cId) {
    global $conn;
    $userId = $uId;
    $courseId = $cId;

    $result = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $userId AND course_id = $courseId");
    if(mysqli_fetch_assoc($result)) {
        return false;
    }

    $query = "INSERT INTO cart (user_id, course_id) VALUES ('$userId', '$courseId')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function checkout($userId, $totalPrice) {
    global $conn;
    // $userId = $data["userId"];
    // $totalPrice = $data["totalPrice"];

    mysqli_query($conn, "INSERT INTO orders (user_id, total) VALUES ('$userId', '$totalPrice')");


    if(mysqli_affected_rows($conn) > 0) {
        $orders = query("SELECT *, 
                        cart.id AS cart_id
                        FROM order_summary
                        JOIN cart ON cart.id = cart_id
                        JOIN courses ON courses.id = course_id
                        WHERE order_summary.user_id = $userId 
                        ");
                        
        // Ambil id dari tabel order
        $orderId = query("SELECT id FROM orders WHERE user_id = $userId ORDER BY id DESC LIMIT 1")[0]["id"];

        foreach($orders as $ord) {
            $courseId = $ord["course_id"];
            $cartId = $ord["cart_id"];
            $price = $ord["price"];
    
            mysqli_query($conn, "INSERT INTO orders_detail (course_id, order_id, price, quantity) VALUES ('$courseId', '$orderId', '$price', '1')");
    
            if(mysqli_affected_rows($conn) > 0) {
                
                mysqli_query($conn, "DELETE cart, order_summary
                                 FROM cart
                                 JOIN order_summary
                                 ON cart.id = cart_id
                                 WHERE cart.id = $cartId");
                                 
            }
        }   
        return mysqli_affected_rows($conn);
    }
    return false;
}

function deleteCartList($id) {
    global $conn;

    $result =  mysqli_query($conn, "SELECT * FROM order_summary WHERE cart_id = $id");

    if(mysqli_fetch_assoc($result)) {
        mysqli_query($conn, "DELETE cart, order_summary
                                FROM cart
                                JOIN order_summary
                                ON cart.id = cart_id
                                WHERE cart.id = $id");

        return  mysqli_affected_rows($conn);
        
    } else {
        mysqli_query($conn, "DELETE 
                                FROM cart WHERE id = $id");
                                
        return  mysqli_affected_rows($conn);
    };

}

function deleteUser($id) {
    global $conn;
    mysqli_query($conn, "DELETE users, profile
                         FROM users JOIN profile ON user_id = users.id
                         WHERE users.id = $id");

    return mysqli_affected_rows($conn);

}

function follow($userId, $myUserId) {
    global $conn;

    mysqli_query($conn, "INSERT INTO followers(user_id, profile_id) VALUES ('$myUserId', '$userId')");

    return mysqli_affected_rows($conn);
}

function unFollow($userId, $myUserId) {
    global $conn;

    mysqli_query($conn, "DELETE FROM followers WHERE user_id = $myUserId AND profile_id = $userId");

    return mysqli_affected_rows($conn);
}
?>
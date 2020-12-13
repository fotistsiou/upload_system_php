<?php
    session_start();

    $username = "";
    $email = "";
    $errors = [];

    $db = mysqli_connect('localhost', 'root', '', 'upload_system');

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    if (isset($_POST['register'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($email)) {
            array_push($errors, "Email is required");
        }
        if (empty($password_1)) {
            array_push($errors, "Password is required");
        }
        if ($password_1 != $password_2) {
            array_push($errors, "The two password do not match");
        }

        if (count($errors) == 0) {
            $password = md5($password_1);
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            mysqli_query($db, $sql);
            $_SESSION['username'] = $username;
            $_SESSION['success'] = true;
            header('Location: login.php');
        }
    }

    if (isset($_POST['login'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($password)) {
            array_push($errors, "Password is required");  
        }
        if (count($errors) == 0) {
            $password = md5($password);
            $query = "SELECT id, username FROM users WHERE username='$username' AND password='$password' LIMIT 1;";
            $result = mysqli_query($db, $query);
            if(mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['success'] = true;
                header('Location: index.php');
            } else {
                array_push($errors, "Wrong username/password combination");
            }
        }
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['success']);
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
        header('Location: login.php');
    }

    if (isset($_POST['upload'])) {
        $destination = 'uploads/';
        $upload = $_FILES['file']['name'];
        if ( !$upload == "") {
            $sql = "INSERT INTO uploads (user_id, upload) VALUES ('".$_SESSION['user_id']."', '$upload')";
            mysqli_query($db, $sql);
            $destination .= $_FILES['file']['name'];
            $filename = $_FILES['file']['tmp_name'];
            move_uploaded_file ($filename, $destination);
            header('Location: index.php');
        } else {
            header('Location: index.php');
        }
    }

    if (isset($_GET['delete'])) {
        $up = $_GET['delete'];
        $del = "DELETE FROM uploads WHERE upload='$up'";
        mysqli_query($db, $del);
        header('Location: index.php');
    }
?>
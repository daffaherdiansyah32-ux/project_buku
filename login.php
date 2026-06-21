<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
session_start();
include 'config/koneksi.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = mysqli_query($conn,
    "SELECT * FROM users
     WHERE username='$username'
     AND password='$password'");

    if(mysqli_num_rows($query)>0){
        $_SESSION['login']=true;
        header("Location:index.php");
    }else{
        echo "Login gagal";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
<div class="card p-4">
<h3>Login Admin</h3>

<form method="POST">
<input type="text" name="username" class="form-control mb-2" placeholder="Username">

<input type="password" name="password" class="form-control mb-2" placeholder="Password">

<button name="login" class="btn btn-primary">
Login
</button>
</form>

</div>
</div>

</body>
</html>
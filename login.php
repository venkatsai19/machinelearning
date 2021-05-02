<!DOCTYPE html>
<?php
$conn=mysqli_connect("localhost","root","","user_register");
?>
<html>
<head>
<title>LOGIN</title>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
    h2{
        font-family: 'Overpass',sans-serif;
        font-weight: bold;
        color:#000;
        background-color: cyan;
    }
    .form-control,.btn{
        height:40px;
        border-radius: 0px;
        margin-top: 10px;
        font-family: 'Overpass',sans-serif;
        font-weight: bold;
        color:black;
        font-size: 25px;
        
    }
    body {
  background-image: url("cyber.jpg");
  background-color: #cccccc;
  height: 500px;
        
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
  margin-left: 500px;
    }
  
</style>
</head>
<body>
    <br><br>
    <div class="container">
        <div class ="row">
        
        <div class="col-sm-6">
            <form method="post">
            <h2 align ="center">LOGIN HERE</h2>
            <input type="email" name="email" class="form-control" placeholder="email addresss " required>
            <input type="password" name="password" class="form-control" placeholder="password" required>
            <button type="="submit" name="login" class="btn btn-info btn-block  ">login</button> 
            </form> 

        </div>
        </div>
    </div>
</body>
</html>
<?php
define('AES_256_CBC', 'aes-256-cbc');
$encryption_key=hash("sha256","rakshikaaes");
$iv = (openssl_cipher_iv_length(AES_256_CBC));
if(isset($_POST['register']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pass=$_POST['password'];
     $encrypted = openssl_encrypt($pass, AES_256_CBC, $encryption_key, 0, $iv);
     $encrypted = $encrypted . ':' . base64_encode($iv);
    $q=mysqli_query($conn,"INSERT INTO `register`( `name`, `email`, `password`) VALUES ('$name','$email','$encrypted')");
    if($q)
    {
        echo"<script>alert('registration succes')</script>";
        echo"<meta http-equiv='refresh' content='0'>";

    }
    else
    {
        echo"<script>alert('registration failed')</script>";
        echo"<meta http-equiv='refresh' content='0'>";
        
    }
    echo"<script>alert('registration succes')</script>";
    header("Location: about.html");
    exit(); 
        

}
if(isset($_POST['login']))
{
    $email=$_POST['email'];
    $pass=$_POST['password'];
    $q=mysqli_query($conn,"SELECT * FROM register WHERE  email='$email'");
    if($q)
    {
        $row=mysqli_fetch_array($q);
        $dbpass=$row['password'];
        $parts = explode(':', $dbpass);
        $decrypted = openssl_decrypt($parts[0], AES_256_CBC, $encryption_key, 0, base64_decode($parts[1]));
        if($row['email']==$email && $decrypted==$pass)
        {
            echo"<script>alert('login succes')</script>";
            echo"<meta http-equiv='refresh' content='0'>";
        }
        else
        {
            echo"<script>alert('login failed')</script>";
                echo"<meta http-equiv='refresh' content='0'>";
        }
         header("Location: about.html");
    exit(); 
    }
}
?>
<!DOCTYPE html>
<?php
$conn=mysqli_connect("localhost","root","","user_register");
?>
<html>
<head>
<title> REGISTRATION</title>


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
  background-image: url("padlock.jpg");
  background-color: #cccccc;
  height: 400px;
        
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
  align-content: center;
  margin-left: 500px;
    }
    .hi{
        font-size: 50px;
        color: white;
        
    }
   
</style>
</head>
<body>
    <br><br>
     
    <br><br><br><br><br>
    <div class="container">
        <div class ="row">
        <div class="col-sm-6">
            <form method="post">
            <h2 align ="center">REGISTRATION</h2>
            <input type="text" name="name" class="form-control" required placeholder="name">
            <input type="email" name="email" class="form-control" placeholder="email addresss " required>
            <input type="password" name="password" class="form-control" placeholder="password" required>
            <button type="submit" name="register" class="btn btn-info btn-block  ">register</button> 
            </form> 

        </div>
        <div class ="hi">
         <a href="login.php">login here</a>
        </div>
        </div>
        
        
    </div>
   
     
</body>
</html>
<?php
//$start = microtime(true);
define('AES_256_CBC', 'aes-256-cbc');
$aeskey="rakshikaaes";
$encryption_key=hash("sha256",$aeskey);
$iv = (openssl_cipher_iv_length(AES_256_CBC));
if(isset($_POST['register']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $pass=$_POST['password'];
     $encrypted = openssl_encrypt($pass, AES_256_CBC, $encryption_key, 0, $iv);
     $encrypted = $encrypted . ':' . base64_encode($iv);
     $end = microtime(true);
    $q=mysqli_query($conn,"INSERT INTO `register`( `name`, `email`, `password`) VALUES ('$name','$email','$encrypted')");
    if($q)
    {
        echo"<script>alert('registration succes')</script>";
        // $exec_time = ($end - $start);
//echo "<script>alert('The execution time of the PHP script is : ".$exec_time." sec')</script>";
        echo"<meta http-equiv='refresh' content='0'>";

    }
    else
    {
        echo"<script>alert('registration failed')</script>";
        echo"<meta http-equiv='refresh' content='0'>";
        
    }
    echo"<script>alert('registration succes')</script>";
    header("Location: filehome.php");
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
             header("Location: filehome.php");
        }
        else
        {
            echo"<script>alert('login failed')</script>";
                echo"<meta http-equiv='refresh' content='0'>";
        }
        
    exit();
    }
}
?>

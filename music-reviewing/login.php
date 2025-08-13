<?php
session_start();
$PASSWORD = "music_reviewing"; // Change this!

if(isset($_POST['password'])){
    if($_POST['password'] === $PASSWORD){
        $_SESSION['logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Wrong password!";
    }
}
?>
<form method="POST">
    <input type="password" name="password" placeholder="Password"/>
    <button type="submit">Login</button>
</form>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

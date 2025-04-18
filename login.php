<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = json_decode(file_get_contents("users.json"), true);
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (isset($users[$email]) && $users[$email]['password'] == $password) {
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
    } else {
        $msg = "Invalid login";
    }
}
?>
<form method="POST">
    <input name="email" placeholder="Email" required>
    <input name="password" placeholder="Password" type="password" required>
    <button>Login</button>
</form>
<?php if (isset($msg)) echo $msg; ?>
<a href="signup.php">Sign Up</a>

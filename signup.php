<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = json_decode(file_get_contents("users.json"), true);
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (isset($users[$email])) {
        $msg = "Email already exists!";
    } else {
        $users[$email] = ["password" => $password, "cashback" => 0];
        file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
        $msg = "Signup successful!";
    }
}
?>
<form method="POST">
    <input name="email" placeholder="Email" required>
    <input name="password" placeholder="Password" type="password" required>
    <button>Sign Up</button>
</form>
<?php if (isset($msg)) echo $msg; ?>
<a href="login.php">Login</a>

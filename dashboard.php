<?php
session_start();
if (!isset($_SESSION['email'])) header("Location: login.php");

$users = json_decode(file_get_contents("users.json"), true);
$email = $_SESSION['email'];

if (isset($_GET['offer'])) {
    $users[$email]['cashback'] += 50;
    file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
    $msg = "Cashback added!";
}
?>
<h2>Welcome, <?= $email ?></h2>
<p>Cashback Balance: ₹<?= $users[$email]['cashback'] ?></p>
<a href="?offer=1">Click here to complete an offer (Get ₹50)</a><br><br>
<a href="withdraw.php">Withdraw</a><br>
<a href="logout.php">Logout</a>
<?php if (isset($msg)) echo "<p>$msg</p>"; ?>

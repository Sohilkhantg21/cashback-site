<?php
session_start();
if (!isset($_SESSION['email'])) header("Location: login.php");

$users = json_decode(file_get_contents("users.json"), true);
$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($users[$email]['cashback'] >= 100) {
        $msg = "Withdrawal request of ₹" . $users[$email]['cashback'] . " sent!";
        $users[$email]['cashback'] = 0;
        file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
    } else {
        $msg = "Minimum ₹10 required to withdraw.";
    }
}
?>
<h3>Withdraw Cashback</h3>
<p>Current Balance: ₹<?= $users[$email]['cashback'] ?></p>
<form method="POST">
    <button>Withdraw</button>
</form>
<?php if (isset($msg)) echo "<p>$msg</p>"; ?>
<a href="dashboard.php">Back</a>

<?php
session_start();
$admin_pass = "sohilkhan.21"; // Change this!

if (!isset($_SESSION['admin'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['password'] == $admin_pass) {
            $_SESSION['admin'] = true;
            header("Location: admin.php");
            exit;
        } else {
            $msg = "Incorrect password!";
        }
    }
    ?>
    <h2>Admin Login</h2>
    <form method="POST">
        <input type="password" name="password" placeholder="Admin Password" required>
        <button>Login</button>
    </form>
    <?php if (isset($msg)) echo "<p>$msg</p>"; ?>
    <?php exit;
}

$users = json_decode(file_get_contents("users.json"), true);

if (isset($_POST['reset_user'])) {
    $email = $_POST['email'];
    if (isset($users[$email])) {
        $users[$email]['cashback'] = 0;
        file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
        $msg = "Balance reset for $email";
    }
}

if (isset($_POST['add_cashback'])) {
    $email = $_POST['email'];
    $amount = intval($_POST['amount']);
    if (isset($users[$email])) {
        $users[$email]['cashback'] += $amount;
        file_put_contents("users.json", json_encode($users, JSON_PRETTY_PRINT));
        $msg = "₹$amount added to $email";
    }
}
?>

<h2>Admin Panel</h2>
<?php if (isset($msg)) echo "<p>$msg</p>"; ?>

<h3>All Users</h3>
<table border="1" cellpadding="5">
    <tr><th>Email</th><th>Cashback</th></tr>
    <?php foreach ($users as $email => $data): ?>
        <tr><td><?= $email ?></td><td>₹<?= $data['cashback'] ?></td></tr>
    <?php endforeach; ?>
</table>

<h3>Reset User Cashback</h3>
<form method="POST">
    <input type="email" name="email" placeholder="User Email" required>
    <button name="reset_user">Reset</button>
</form>

<h3>Add Cashback to User</h3>
<form method="POST">
    <input type="email" name="email" placeholder="User Email" required><br>
    <input type="number" name="amount" placeholder="Amount (₹)" required>
    <button name="add_cashback">Add Cashback</button>
</form>
<br><a href="logout.php">Logout Admin</a>

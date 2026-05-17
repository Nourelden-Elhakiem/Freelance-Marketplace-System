<?php
require_once __DIR__ . '/../config/db.php';
$pageTitle = 'Edit Client | Freelance Marketplace System';
$id = intval($_GET['id'] ?? 0); $successMessage = ''; $errorMessage = '';
if ($id <= 0) { header('Location: clients.php?error=Invalid client ID.'); exit; }
$stmt = $conn->prepare("SELECT u.user_id, u.name, u.email, u.password, u.registration_date FROM `User` u INNER JOIN Client c ON u.user_id = c.client_id WHERE c.client_id = ?");
$stmt->bind_param('i', $id); $stmt->execute(); $client = $stmt->get_result()->fetch_assoc(); $stmt->close();
if (!$client) { header('Location: clients.php?error=Client not found.'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? ''); $email = trim($_POST['email'] ?? ''); $password = trim($_POST['password'] ?? ''); $regDate = trim($_POST['registration_date'] ?? '');
    if ($name === '' || $email === '' || $password === '' || $regDate === '') { $errorMessage = 'Please fill in all required fields.'; }
    else { $stmt = $conn->prepare("UPDATE `User` SET name = ?, email = ?, password = ?, registration_date = ? WHERE user_id = ?"); $stmt->bind_param('ssssi', $name, $email, $password, $regDate, $id); if ($stmt->execute()) { $successMessage = 'Client updated successfully.'; $client = array_merge($client, ['name'=>$name,'email'=>$email,'password'=>$password,'registration_date'=>$regDate]); } else { $errorMessage = ($conn->errno === 1062) ? 'This email address is already used by another user.' : 'Unable to update client.'; } $stmt->close(); }
}
include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/navbar.php';
?>
<section class="form-card"><span class="eyebrow">Edit Record</span><h2 class="page-title">Edit Client #<?php echo $id; ?></h2><p class="page-intro">Update the client's information in the User table.</p><?php if ($successMessage !== ''): ?><div class="message success"><?php echo htmlspecialchars($successMessage); ?></div><?php endif; ?><?php if ($errorMessage !== ''): ?><div class="message error"><?php echo htmlspecialchars($errorMessage); ?></div><?php endif; ?><form method="POST" action=""><div class="form-row"><div><label for="name">Full Name *</label><input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($client['name']); ?>"></div><div><label for="email">Email Address *</label><input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($client['email']); ?>"></div></div><div class="form-row"><div><label for="password">Password *</label><input type="text" id="password" name="password" required value="<?php echo htmlspecialchars($client['password']); ?>"></div><div><label for="registration_date">Registration Date *</label><input type="date" id="registration_date" name="registration_date" required value="<?php echo htmlspecialchars($client['registration_date']); ?>"></div></div><div class="form-actions"><button type="submit">Update Client</button><a class="btn btn-secondary" href="<?php echo $basePath; ?>/pages/clients.php">Cancel</a></div></form></section>
<?php include __DIR__ . '/../includes/footer.php'; $conn->close(); ?>
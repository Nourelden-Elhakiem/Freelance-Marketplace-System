<?php
require_once __DIR__ . '/../config/db.php';
$pageTitle = 'Add Client | Freelance Marketplace System';

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $regDate = trim($_POST['registration_date'] ?? '');

    if ($name === '' || $email === '' || $password === '' || $regDate === '') {
        $errorMessage = 'Please fill in all required fields.';
    } else {
        $stmt = $conn->prepare("INSERT INTO `User` (name, email, password, registration_date, user_type) VALUES (?, ?, ?, ?, 'Client')");
        $stmt->bind_param('ssss', $name, $email, $password, $regDate);
        if ($stmt->execute()) {
            $userId = $conn->insert_id;
            $stmt2 = $conn->prepare("INSERT INTO Client (client_id) VALUES (?)");
            $stmt2->bind_param('i', $userId);
            if ($stmt2->execute()) { $successMessage = 'Client added successfully (ID: ' . $userId . ').'; } else { $errorMessage = 'User created but failed to insert into Client table.'; }
            $stmt2->close();
        } else { $errorMessage = ($conn->errno === 1062) ? 'This email address is already registered.' : 'Unable to add client. Please try again.'; }
        $stmt->close();
    }
}
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="form-card sr-hidden">
    <span class="eyebrow"><i class="lucide-plus-circle"></i> New Record</span>
    <h2 class="page-title">Add New Client</h2>
    <p class="page-intro">Create a new user with the Client role. This inserts into both the User and Client tables.</p>

    <?php if ($successMessage !== ''): ?><div class="message success"><i class="lucide-check-circle"></i> <?php echo htmlspecialchars($successMessage); ?></div><?php endif; ?>
    <?php if ($errorMessage !== ''): ?><div class="message error"><i class="lucide-alert-circle"></i> <?php echo htmlspecialchars($errorMessage); ?></div><?php endif; ?>

    <form method="POST" action="">
        <div class="form-row">
            <div>
                <label for="name"><i class="lucide-user"></i> Full Name *</label>
                <input type="text" id="name" name="name" required placeholder="Enter full name">
            </div>
            <div>
                <label for="email"><i class="lucide-mail"></i> Email Address *</label>
                <input type="email" id="email" name="email" required placeholder="Enter email">
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="password"><i class="lucide-lock"></i> Password *</label>
                <input type="text" id="password" name="password" required placeholder="Enter password">
            </div>
            <div>
                <label for="registration_date"><i class="lucide-calendar"></i> Registration Date *</label>
                <input type="date" id="registration_date" name="registration_date" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit"><i class="lucide-check"></i> Add Client</button>
            <a class="btn btn-secondary" href="<?php echo $basePath; ?>/pages/clients.php"><i class="lucide-arrow-left"></i> Cancel</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; $conn->close(); ?>
<?php
require_once __DIR__ . '/../config/db.php';
$pageTitle = 'Add Freelancer | Freelance Marketplace System';
$successMessage = ''; $errorMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { $name=trim($_POST['name']??''); $email=trim($_POST['email']??''); $password=trim($_POST['password']??''); $regDate=trim($_POST['registration_date']??''); $bio=trim($_POST['bio']??''); if ($name===''||$email===''||$password===''||$regDate==='') { $errorMessage='Please fill in all required fields.'; } else { $stmt=$conn->prepare("INSERT INTO `User` (name, email, password, registration_date, user_type) VALUES (?, ?, ?, ?, 'Freelancer')"); $stmt->bind_param('ssss',$name,$email,$password,$regDate); if($stmt->execute()){ $userId=$conn->insert_id; $stmt2=$conn->prepare("INSERT INTO Freelancer (freelancer_id, bio) VALUES (?, ?)"); $stmt2->bind_param('is',$userId,$bio); $successMessage=$stmt2->execute()?'Freelancer added successfully (ID: '.$userId.').':'User created but failed to insert into Freelancer table.'; $stmt2->close(); } else { $errorMessage=($conn->errno===1062)?'This email address is already registered.':'Unable to add freelancer. Please try again.'; } $stmt->close(); } }
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="form-card sr-hidden">
    <span class="eyebrow"><i class="lucide-plus-circle"></i> New Record</span>
    <h2 class="page-title">Add New Freelancer</h2>
    <p class="page-intro">Create a new user with the Freelancer role. This inserts into both the User and Freelancer tables.</p>

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
        <div>
            <label for="bio"><i class="lucide-file-text"></i> Bio</label>
            <textarea id="bio" name="bio" placeholder="Enter freelancer bio (optional)"></textarea>
        </div>
        <div class="form-actions">
            <button type="submit"><i class="lucide-check"></i> Add Freelancer</button>
            <a class="btn btn-secondary" href="<?php echo $basePath; ?>/pages/freelancers.php"><i class="lucide-arrow-left"></i> Cancel</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; $conn->close(); ?>
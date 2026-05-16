<?php
require_once __DIR__ . '/../config/db.php';
$pageTitle='Add Project | Freelance Marketplace System'; $successMessage=''; $errorMessage='';
if($_SERVER['REQUEST_METHOD']==='POST'){ $title=trim($_POST['title']??''); $description=trim($_POST['description']??''); $budget=trim($_POST['budget']??''); $datePosted=trim($_POST['date_posted']??''); $status=trim($_POST['status']??''); $clientId=trim($_POST['client_id']??''); if($title===''||$budget===''||$datePosted===''||$status===''||$clientId===''){$errorMessage='Please fill in all required fields.';} else {$stmt=$conn->prepare('INSERT INTO Project (title, description, budget, date_posted, status, client_id) VALUES (?, ?, ?, ?, ?, ?)'); $stmt->bind_param('ssdssi',$title,$description,$budget,$datePosted,$status,$clientId); $successMessage=$stmt->execute()?'Project added successfully (ID: '.$conn->insert_id.').':'Unable to add project. Please check the client selection and try again.'; $stmt->close();}}
$clients=$conn->query("SELECT c.client_id, u.name FROM Client c INNER JOIN `User` u ON c.client_id = u.user_id ORDER BY u.name");
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="form-card sr-hidden">
    <span class="eyebrow"><i class="lucide-plus-circle"></i> New Record</span>
    <h2 class="page-title">Add New Project</h2>
    <p class="page-intro">Insert a new project into the Project table with a linked client.</p>

    <?php if($successMessage!==''):?><div class="message success"><i class="lucide-check-circle"></i> <?php echo htmlspecialchars($successMessage); ?></div><?php endif;?>
    <?php if($errorMessage!==''):?><div class="message error"><i class="lucide-alert-circle"></i> <?php echo htmlspecialchars($errorMessage); ?></div><?php endif;?>

    <form method="POST" action="">
        <div class="form-row">
            <div>
                <label for="title"><i class="lucide-type"></i> Project Title *</label>
                <input type="text" id="title" name="title" required placeholder="Enter project title">
            </div>
            <div>
                <label for="budget"><i class="lucide-dollar-sign"></i> Budget *</label>
                <input type="number" step="0.01" id="budget" name="budget" required placeholder="0.00">
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="date_posted"><i class="lucide-calendar"></i> Date Posted *</label>
                <input type="date" id="date_posted" name="date_posted" required>
            </div>
            <div>
                <label for="status"><i class="lucide-flag"></i> Status *</label>
                <select id="status" name="status" required>
                    <option value="Open">Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                </select>
            </div>
        </div>
        <div>
            <label for="client_id"><i class="lucide-briefcase"></i> Client *</label>
            <select id="client_id" name="client_id" required>
                <option value="">Select a client</option>
                <?php while($client=$clients->fetch_assoc()):?>
                    <option value="<?php echo $client['client_id']; ?>"><?php echo htmlspecialchars($client['name']); ?> (ID: <?php echo $client['client_id']; ?>)</option>
                <?php endwhile;?>
            </select>
        </div>
        <div>
            <label for="description"><i class="lucide-align-left"></i> Description</label>
            <textarea id="description" name="description" placeholder="Enter project description (optional)"></textarea>
        </div>
        <div class="form-actions">
            <button type="submit"><i class="lucide-check"></i> Add Project</button>
            <a class="btn btn-secondary" href="<?php echo $basePath; ?>/pages/projects.php"><i class="lucide-arrow-left"></i> Cancel</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; $conn->close(); ?>

<?php
require_once __DIR__ . '/../config/db.php';
$pageTitle='Assign Skill | Freelance Marketplace System'; $successMessage=''; $errorMessage='';
if($_SERVER['REQUEST_METHOD']==='POST'){ $freelancerId=trim($_POST['freelancer_id']??''); $skillId=trim($_POST['skill_id']??''); $proficiency=trim($_POST['proficiency_level']??''); if($freelancerId===''||$skillId===''||$proficiency===''){$errorMessage='Please fill in all required fields.';} else {$stmt=$conn->prepare("INSERT INTO Freelancer_Skill (freelancer_id, skill_id, proficiency_level) VALUES (?, ?, ?)"); $stmt->bind_param('iis',$freelancerId,$skillId,$proficiency); if($stmt->execute()){$successMessage='Skill assigned to freelancer successfully.';} else {$errorMessage=($conn->errno===1062)?'This freelancer already has this skill assigned. Please choose a different combination.':'Unable to assign skill. Please check the selections and try again.';} $stmt->close();}}
$freelancers=$conn->query("SELECT f.freelancer_id, u.name FROM Freelancer f INNER JOIN `User` u ON f.freelancer_id = u.user_id ORDER BY u.name"); $skills=$conn->query("SELECT skill_id, skill_name FROM Skill ORDER BY skill_name");
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="form-card sr-hidden">
    <span class="eyebrow"><i class="lucide-link"></i> New Assignment</span>
    <h2 class="page-title">Assign Skill to Freelancer</h2>
    <p class="page-intro">Create a new entry in the Freelancer_Skill junction table, linking a freelancer to a skill with a proficiency level.</p>

    <?php if($successMessage!==''):?><div class="message success"><i class="lucide-check-circle"></i> <?php echo htmlspecialchars($successMessage); ?></div><?php endif;?>
    <?php if($errorMessage!==''):?><div class="message error"><i class="lucide-alert-circle"></i> <?php echo htmlspecialchars($errorMessage); ?></div><?php endif;?>

    <form method="POST" action="">
        <div class="form-row">
            <div>
                <label for="freelancer_id"><i class="lucide-user-check"></i> Freelancer *</label>
                <select id="freelancer_id" name="freelancer_id" required>
                    <option value="">Select a freelancer</option>
                    <?php while($f=$freelancers->fetch_assoc()):?>
                        <option value="<?php echo $f['freelancer_id']; ?>"><?php echo htmlspecialchars($f['name']); ?> (ID: <?php echo $f['freelancer_id']; ?>)</option>
                    <?php endwhile;?>
                </select>
            </div>
            <div>
                <label for="skill_id"><i class="lucide-sparkles"></i> Skill *</label>
                <select id="skill_id" name="skill_id" required>
                    <option value="">Select a skill</option>
                    <?php while($s=$skills->fetch_assoc()):?>
                        <option value="<?php echo $s['skill_id']; ?>"><?php echo htmlspecialchars($s['skill_name']); ?> (ID: <?php echo $s['skill_id']; ?>)</option>
                    <?php endwhile;?>
                </select>
            </div>
        </div>
        <div>
            <label for="proficiency_level"><i class="lucide-bar-chart-3"></i> Proficiency Level *</label>
            <select id="proficiency_level" name="proficiency_level" required>
                <option value="">Select proficiency</option>
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
                    <option value="Expert">Expert</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit"><i class="lucide-check"></i> Assign Skill</button>
            <a class="btn btn-secondary" href="<?php echo $basePath; ?>/pages/skills.php"><i class="lucide-arrow-left"></i> Cancel</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; $conn->close(); ?>

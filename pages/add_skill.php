<?php
require_once __DIR__ . '/../config/db.php';
$isEdit = basename($_SERVER['SCRIPT_NAME']) === 'edit_skill.php';
$pageTitle = ($isEdit ? 'Edit Skill' : 'Add Skill') . ' | Freelance Marketplace System';
$id=intval($_GET['id']??0); $successMessage=''; $errorMessage=''; $skill=['skill_name'=>''];
if($isEdit){ if($id<=0){header('Location: skills.php?error=Invalid skill ID.'); exit;} $stmt=$conn->prepare("SELECT * FROM Skill WHERE skill_id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); $skill=$stmt->get_result()->fetch_assoc(); $stmt->close(); if(!$skill){header('Location: skills.php?error=Skill not found.'); exit;} }
if($_SERVER['REQUEST_METHOD']==='POST'){ $skillName=trim($_POST['skill_name']??''); if($skillName===''){$errorMessage='Please enter a skill name.';} else { if($isEdit){$stmt=$conn->prepare("UPDATE Skill SET skill_name = ? WHERE skill_id = ?"); $stmt->bind_param('si',$skillName,$id);} else {$stmt=$conn->prepare("INSERT INTO Skill (skill_name) VALUES (?)"); $stmt->bind_param('s',$skillName);} if($stmt->execute()){$successMessage=$isEdit?'Skill updated successfully.':'Skill added successfully (ID: '.$conn->insert_id.').'; $skill['skill_name']=$skillName;} else {$errorMessage=($conn->errno===1062)?'This skill name already exists.':($isEdit?'Unable to update skill.':'Unable to add skill.');} $stmt->close(); }}
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="form-card sr-hidden">
    <span class="eyebrow"><i class="lucide-<?php echo $isEdit?'pencil':'plus-circle'; ?>"></i> <?php echo $isEdit?'Edit Record':'New Record'; ?></span>
    <h2 class="page-title"><?php echo $isEdit?'Edit Skill #'.$id:'Add New Skill'; ?></h2>
    <p class="page-intro"><?php echo $isEdit?'Update the skill name.':'Insert a new skill into the Skill table.'; ?></p>

    <?php if($successMessage!==''):?><div class="message success"><i class="lucide-check-circle"></i> <?php echo htmlspecialchars($successMessage); ?></div><?php endif;?>
    <?php if($errorMessage!==''):?><div class="message error"><i class="lucide-alert-circle"></i> <?php echo htmlspecialchars($errorMessage); ?></div><?php endif;?>

    <form method="POST" action="">
        <div>
            <label for="skill_name"><i class="lucide-sparkles"></i> Skill Name *</label>
            <input type="text" id="skill_name" name="skill_name" required value="<?php echo htmlspecialchars($skill['skill_name']); ?>" placeholder="Enter skill name">
        </div>
        <div class="form-actions">
            <button type="submit"><i class="lucide-check"></i> <?php echo $isEdit?'Update Skill':'Add Skill'; ?></button>
            <a class="btn btn-secondary" href="<?php echo $basePath; ?>/pages/skills.php"><i class="lucide-arrow-left"></i> Cancel</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; $conn->close(); ?>
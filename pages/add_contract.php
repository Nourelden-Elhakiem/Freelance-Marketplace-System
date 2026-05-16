<?php
require_once __DIR__ . '/../config/db.php';
$isEdit = basename($_SERVER['SCRIPT_NAME']) === 'edit_contract.php';
$pageTitle = ($isEdit ? 'Edit Contract' : 'Add Contract') . ' | Freelance Marketplace System';
$id=intval($_GET['id']??0); $successMessage=''; $errorMessage=''; $contract=['start_date'=>'','end_date'=>'','status'=>'Active','proposal_id'=>''];
if($isEdit){ if($id<=0){header('Location: contracts.php?error=Invalid contract ID.'); exit;} $stmt=$conn->prepare("SELECT c.*, p.bid_amount, u.name AS freelancer_name, pr.title AS project_title FROM Contract c INNER JOIN Proposal p ON c.proposal_id=p.proposal_id INNER JOIN Freelancer f ON p.freelancer_id=f.freelancer_id INNER JOIN `User` u ON f.freelancer_id=u.user_id INNER JOIN Project pr ON p.project_id=pr.project_id WHERE c.contract_id=?"); $stmt->bind_param('i',$id); $stmt->execute(); $contract=$stmt->get_result()->fetch_assoc(); $stmt->close(); if(!$contract){header('Location: contracts.php?error=Contract not found.'); exit;} }
if($_SERVER['REQUEST_METHOD']==='POST'){ $startDate=trim($_POST['start_date']??''); $endDate=trim($_POST['end_date']??''); $status=trim($_POST['status']??''); $proposalId=trim($_POST['proposal_id']??$contract['proposal_id']); if($startDate===''||$status===''||(!$isEdit&&$proposalId==='')){$errorMessage='Please fill in all required fields.';} else {$endDateValue=$endDate!==''?$endDate:null; if($isEdit){$stmt=$conn->prepare("UPDATE Contract SET start_date = ?, end_date = ?, status = ? WHERE contract_id = ?"); $stmt->bind_param('sssi',$startDate,$endDateValue,$status,$id);} else {$stmt=$conn->prepare("INSERT INTO Contract (start_date, end_date, status, proposal_id) VALUES (?, ?, ?, ?)"); $stmt->bind_param('sssi',$startDate,$endDateValue,$status,$proposalId);} if($stmt->execute()){$successMessage=$isEdit?'Contract updated successfully.':'Contract added successfully (ID: '.$conn->insert_id.').'; $contract['start_date']=$startDate; $contract['end_date']=$endDateValue; $contract['status']=$status; $contract['proposal_id']=$proposalId;} else {$errorMessage=($conn->errno===1062)?'A contract already exists for this proposal (proposal_id must be unique).':'Unable to add contract. Please check the proposal selection.';} $stmt->close(); }}
$proposals=$conn->query("SELECT p.proposal_id, p.bid_amount, p.status AS proposal_status, u.name AS freelancer_name, pr.title AS project_title FROM Proposal p INNER JOIN Freelancer f ON p.freelancer_id=f.freelancer_id INNER JOIN `User` u ON f.freelancer_id=u.user_id INNER JOIN Project pr ON p.project_id=pr.project_id LEFT JOIN Contract c ON p.proposal_id=c.proposal_id WHERE c.contract_id IS NULL ORDER BY p.proposal_id");
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="form-card sr-hidden">
    <span class="eyebrow"><i class="lucide-<?php echo $isEdit?'pencil':'plus-circle'; ?>"></i> <?php echo $isEdit?'Edit Record':'New Record'; ?></span>
    <h2 class="page-title"><?php echo $isEdit?'Edit Contract #'.$id:'Add New Contract'; ?></h2>
    <p class="page-intro"><?php echo $isEdit?'Update contract dates and status. The linked proposal cannot be changed.':'Create a contract from a proposal. Only proposals without existing contracts are shown.'; ?></p>

    <?php if($successMessage!==''):?><div class="message success"><i class="lucide-check-circle"></i> <?php echo htmlspecialchars($successMessage); ?></div><?php endif;?>
    <?php if($errorMessage!==''):?><div class="message error"><i class="lucide-alert-circle"></i> <?php echo htmlspecialchars($errorMessage); ?></div><?php endif;?>

    <form method="POST" action="">
        <?php if(!$isEdit):?>
        <div>
            <label for="proposal_id"><i class="lucide-file-text"></i> Proposal *</label>
            <select id="proposal_id" name="proposal_id" required>
                <option value="">Select a proposal</option>
                <?php while($p=$proposals->fetch_assoc()):?>
                    <option value="<?php echo $p['proposal_id']; ?>">Proposal #<?php echo $p['proposal_id']; ?> &mdash; <?php echo htmlspecialchars($p['freelancer_name']); ?> for "<?php echo htmlspecialchars($p['project_title']); ?>" ($<?php echo number_format((float)$p['bid_amount'],2); ?>) [<?php echo htmlspecialchars($p['proposal_status']); ?>]</option>
                <?php endwhile;?>
            </select>
        </div>
        <?php endif;?>
        <div class="form-row">
            <div>
                <label for="start_date"><i class="lucide-calendar"></i> Start Date *</label>
                <input type="date" id="start_date" name="start_date" required value="<?php echo htmlspecialchars($contract['start_date']); ?>">
            </div>
            <div>
                <label for="end_date"><i class="lucide-calendar"></i> End Date</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($contract['end_date'] ?? ''); ?>">
            </div>
        </div>
        <div>
            <label for="status"><i class="lucide-flag"></i> Status *</label>
            <select id="status" name="status" required>
                <?php foreach(['Active','Completed','Cancelled'] as $st):?>
                    <option value="<?php echo $st; ?>" <?php echo $contract['status']===$st?'selected':''; ?>><?php echo $st; ?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit"><i class="lucide-check"></i> <?php echo $isEdit?'Update Contract':'Add Contract'; ?></button>
            <a class="btn btn-secondary" href="<?php echo $basePath; ?>/pages/contracts.php"><i class="lucide-arrow-left"></i> Cancel</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; $conn->close(); ?>
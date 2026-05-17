<?php
require_once __DIR__ . '/../config/db.php';
$fid=intval($_GET['fid']??0); $sid=intval($_GET['sid']??0); if($fid<=0||$sid<=0){header('Location: skills.php?error=Invalid freelancer or skill ID.'); exit;} $stmt=$conn->prepare("DELETE FROM Freelancer_Skill WHERE freelancer_id = ? AND skill_id = ?"); $stmt->bind_param('ii',$fid,$sid); $stmt->execute(); $stmt->close(); $conn->close(); header('Location: skills.php?success=Skill assignment removed successfully.'); exit;
?>
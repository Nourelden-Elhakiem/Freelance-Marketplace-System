<?php
require_once __DIR__ . '/../config/db.php';
$id=intval($_GET['id']??0); if($id<=0){header('Location: skills.php?error=Invalid skill ID.'); exit;} $del=$conn->prepare("DELETE FROM Freelancer_Skill WHERE skill_id = ?"); $del->bind_param('i',$id); $del->execute(); $del->close(); $stmt=$conn->prepare("DELETE FROM Skill WHERE skill_id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); $stmt->close(); $conn->close(); header('Location: skills.php?success=Skill and all related assignments deleted successfully.'); exit;
?>
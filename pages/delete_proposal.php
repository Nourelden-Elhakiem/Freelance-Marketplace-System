<?php
require_once __DIR__ . '/../config/db.php';
$id=intval($_GET['id']??0); if($id<=0){header('Location: proposals.php?error=Invalid proposal ID.'); exit;} $dc=$conn->prepare("DELETE FROM Contract WHERE proposal_id = ?"); $dc->bind_param('i',$id); $dc->execute(); $dc->close(); $stmt=$conn->prepare("DELETE FROM Proposal WHERE proposal_id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); $stmt->close(); $conn->close(); header('Location: proposals.php?success=Proposal and related contract deleted successfully.'); exit;
?>
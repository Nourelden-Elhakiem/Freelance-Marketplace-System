<?php
require_once __DIR__ . '/../config/db.php';
$id=intval($_GET['id']??0); if($id<=0){header('Location: contracts.php?error=Invalid contract ID.'); exit;} $stmt=$conn->prepare("DELETE FROM Contract WHERE contract_id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); $stmt->close(); $conn->close(); header('Location: contracts.php?success=Contract deleted successfully.'); exit;
?>
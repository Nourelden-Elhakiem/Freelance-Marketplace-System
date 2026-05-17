<?php
require_once __DIR__ . '/../config/db.php';
$id=intval($_GET['id']??0); if($id<=0){header('Location: freelancers.php?error=Invalid freelancer ID.'); exit;}
$del=$conn->prepare("DELETE FROM Freelancer_Skill WHERE freelancer_id = ?"); $del->bind_param('i',$id); $del->execute(); $del->close();
$check=$conn->prepare("SELECT proposal_id FROM Proposal WHERE freelancer_id = ?"); $check->bind_param('i',$id); $check->execute(); $res=$check->get_result(); while($r=$res->fetch_assoc()){ $dc=$conn->prepare("DELETE FROM Contract WHERE proposal_id = ?"); $dc->bind_param('i',$r['proposal_id']); $dc->execute(); $dc->close(); } $check->close();
$dp=$conn->prepare("DELETE FROM Proposal WHERE freelancer_id = ?"); $dp->bind_param('i',$id); $dp->execute(); $dp->close();
$stmt=$conn->prepare("DELETE FROM Freelancer WHERE freelancer_id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); $stmt->close();
$stmt=$conn->prepare("DELETE FROM `User` WHERE user_id = ?"); $stmt->bind_param('i',$id); $stmt->execute(); $stmt->close();
$conn->close(); header('Location: freelancers.php?success=Freelancer and all related records deleted successfully.'); exit;
?>
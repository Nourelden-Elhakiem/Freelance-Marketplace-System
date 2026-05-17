<?php
require_once __DIR__ . '/../config/db.php';
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: clients.php?error=Invalid client ID.'); exit; }
$check = $conn->prepare("SELECT COUNT(*) as c FROM Project WHERE client_id = ?"); $check->bind_param('i', $id); $check->execute(); $count = $check->get_result()->fetch_assoc()['c']; $check->close();
if ($count > 0) { header('Location: clients.php?error=Cannot delete this client because they have ' . $count . ' project(s). Delete the projects first.'); exit; }
$stmt = $conn->prepare("DELETE FROM Client WHERE client_id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); $stmt->close();
$stmt = $conn->prepare("DELETE FROM `User` WHERE user_id = ?"); $stmt->bind_param('i', $id); $stmt->execute(); $stmt->close();
$conn->close(); header('Location: clients.php?success=Client deleted successfully.'); exit;
?>
<?php
if (!isset($pageTitle)) {
    $pageTitle = 'Freelance Marketplace System';
}

require_once __DIR__ . '/icon.php';

$scriptDirectory = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$basePath = preg_replace('#/pages$#', '', $scriptDirectory);

if ($basePath === '.' || $basePath === '/') {
    $basePath = '';
}

$currentPage = basename($_SERVER['SCRIPT_NAME'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="icon" type="image/png" href="<?php echo $basePath; ?>/assets/icons/web_icon.png">
    <link rel="stylesheet" href="<?php echo $basePath; ?>/assets/css/style.css">
</head>
<body class="page-<?php echo htmlspecialchars($currentPage); ?>">
<div class="site-shell">
    <header class="site-header">
        <div class="container header-content">
            <a class="brand-mark" href="<?php echo $basePath; ?>/index.php" aria-label="Freelance Marketplace home">
                <span class="brand-icon brand-image"><img src="<?php echo $basePath; ?>/assets/icons/web_icon.png" alt="" aria-hidden="true"></span>
                <span>
                    <strong>Freelance Marketplace</strong>
                    <small>PHP + MySQL Database System</small>
                </span>
            </a>
            <div class="header-meta">
                <span>Database Systems 2026</span>
                <span>Developed by Nourelden Elhakiem</span>
            </div>
        </div>
    </header>

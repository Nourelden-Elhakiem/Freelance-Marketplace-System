<?php
$pageTitle = 'About | Freelance Marketplace System';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>
<section class="section-card about-hero reveal">
    <div class="about-hero-copy">
        <div class="project-brand-lockup project-brand-logo">
            <img src="<?php echo $basePath; ?>/assets/icons/web_icon.png" alt="Freelance Marketplace System icon">
            <span>Portfolio Database System</span>
        </div>
        <span class="eyebrow"><i class="lucide-info"></i> Project Overview</span>
        <h2 class="page-title">Freelance Marketplace System</h2>
        <p class="page-intro">A professional PHP and MySQL web application that models a simplified freelance marketplace through clean relational data design, CRUD workflows, and a polished presentation layer.</p>
        <p class="muted-text" style="margin-top:14px;">The system focuses on clients, freelancers, projects, proposals, contracts, skills, and the junction-table relationship between freelancers and skills.</p>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>

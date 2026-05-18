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

    <aside class="developer-card">
        <div class="identity-stage" data-identity-stage aria-hidden="true">
            <span class="identity-full-name" data-identity-full>Nourelden Hany Elhakiem</span>
        </div>
        <div class="developer-identity" data-identity-final>
            <div class="developer-avatar identity-badge" data-identity-badge><span>NHE</span></div>
            <div class="developer-content">
                <span class="developer-label">Project Author</span>
                <h3>Nourelden Elhakiem</h3>
                <strong class="developer-title">AI Engineer | Data Scientist</strong>
                <p>Designed and developed this project as a portfolio-ready database management system demonstrating PHP, MySQL, CRUD workflows, relational database design, ERD/EERD documentation, and deployment readiness.</p>
                <div class="social-links">
                    <a class="social-link" href="https://www.linkedin.com/in/NoureldenElhakiem" target="_blank" rel="noopener noreferrer">
                        <?php echo render_local_icon('linkedin', 'social-svg', 'LinkedIn'); ?>
                        <span>LinkedIn</span>
                    </a>
                    <a class="social-link" href="https://github.com/Nourelden-Elhakiem" target="_blank" rel="noopener noreferrer">
                        <?php echo render_local_icon('github', 'social-svg', 'GitHub'); ?>
                        <span>GitHub</span>
                    </a>
                </div>
            </div>
        </div>
    </aside>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>

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
<section class="info-card report-card reveal">
    <div>
        <span class="eyebrow"><i class="lucide-file-text"></i> Project Report</span>
        <h2 class="page-title">Full Documentation Report</h2>
        <p class="page-intro">The report covers database design, ERD/EERD diagrams, normalization, SQL implementation, and project documentation.</p>
    </div>
    <a class="btn report-btn" href="https://github.com/Nourelden-Elhakiem/Freelance-Marketplace-System/blob/main/docs/Freelance_Marketplace_System_Report.pdf" target="_blank" rel="noopener noreferrer">
        <i class="lucide-file-text"></i> View Full Project Report
    </a>
</section>
<div class="two-column">
    <section class="info-card reveal">
        <span class="eyebrow"><i class="lucide-target"></i> Purpose</span>
        <h2 class="page-title">What This Project Demonstrates</h2>
        <p class="page-intro">The project presents database concepts through a realistic marketplace workflow that is simple enough to explain and complete enough to test.</p>
        <ul class="feature-points">
            <li>Clients post projects with budget, status, and posting date.</li>
            <li>Freelancers submit proposals to projects.</li>
            <li>Accepted proposals can be converted into contracts.</li>
            <li>Freelancers can be connected to many skills with proficiency levels.</li>
            <li>CRUD pages allow the database to be tested directly from the website.</li>
        </ul>
    </section>
    <section class="info-card reveal">
        <span class="eyebrow"><i class="lucide-database"></i> Database Focus</span>
        <h2 class="page-title">Relational Coverage</h2>
        <div class="detail-list" style="margin-top:16px;">
            <div class="detail-item"><span class="detail-label">Core Tables</span><span class="detail-value">User, Client, Freelancer, Project, Proposal, Contract, Skill</span></div>
            <div class="detail-item"><span class="detail-label">Relationships</span><span class="detail-value">One-to-one, one-to-many, and many-to-many</span></div>
            <div class="detail-item"><span class="detail-label">Backend</span><span class="detail-value">PHP, MySQL, MySQLi prepared statements</span></div>
            <div class="detail-item"><span class="detail-label">Frontend</span><span class="detail-value">Responsive CSS, ES modules, local SVG icons, canvas hero</span></div>
        </div>
    </section>
</div>
<section class="section-card reveal">
    <span class="eyebrow"><i class="lucide-layers-3"></i> System Modules</span>
    <h2 class="page-title">Main Functional Areas</h2>
    <p class="page-intro">Each module maps to database tables and routes that support browsing, creation, editing, and deletion.</p>
    <div class="module-grid">
        <div class="module-card">
            <div class="module-icon module-icon-dashboard"><?php echo render_local_icon('dashboard', 'module-svg', 'Dashboard'); ?></div>
            <h3>Dashboard</h3>
            <p>Statistics, recent activity, quick actions, and a professional project overview.</p>
        </div>
        <div class="module-card">
            <div class="module-icon module-icon-users"><?php echo render_local_icon('users', 'module-svg', 'User Management'); ?></div>
            <h3>User Management</h3>
            <p>Client and freelancer creation through the shared User table.</p>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>

<?php
require_once __DIR__ . '/config/db.php';
$pageTitle = 'Home | Freelance Marketplace System';

$totalUsers = $conn->query("SELECT COUNT(*) as c FROM `User`")->fetch_assoc()['c'];
$totalClients = $conn->query("SELECT COUNT(*) as c FROM Client")->fetch_assoc()['c'];
$totalFreelancers = $conn->query("SELECT COUNT(*) as c FROM Freelancer")->fetch_assoc()['c'];
$totalProjects = $conn->query("SELECT COUNT(*) as c FROM Project")->fetch_assoc()['c'];
$totalProposals = $conn->query("SELECT COUNT(*) as c FROM Proposal")->fetch_assoc()['c'];
$totalContracts = $conn->query("SELECT COUNT(*) as c FROM Contract")->fetch_assoc()['c'];
$totalSkills = $conn->query("SELECT COUNT(*) as c FROM Skill")->fetch_assoc()['c'];

$recentProjects = $conn->query("
    SELECT p.project_id, p.title, p.status, p.budget, u.name AS client_name
    FROM Project p
    INNER JOIN Client c ON p.client_id = c.client_id
    INNER JOIN `User` u ON c.client_id = u.user_id
    ORDER BY p.date_posted DESC LIMIT 3
");

$recentProposals = $conn->query("
    SELECT pr.proposal_id, pr.bid_amount, pr.status, u.name AS freelancer_name, p.title AS project_title
    FROM Proposal pr
    INNER JOIN Freelancer f ON pr.freelancer_id = f.freelancer_id
    INNER JOIN `User` u ON f.freelancer_id = u.user_id
    INNER JOIN Project p ON pr.project_id = p.project_id
    ORDER BY pr.date_submitted DESC LIMIT 3
");

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<section class="dashboard-hero home-hero">
    <div class="hero-copy">
        <span class="eyebrow"><i class="lucide-graduation-cap"></i> Database Systems Final Project</span>
        <h2>Freelance Marketplace Management Dashboard</h2>
        <p>A polished PHP and MySQL application demonstrating relational entities, foreign keys, CRUD workflows, contracts, proposals, and many-to-many skill assignments.</p>
        <div class="hero-actions">
            <a class="btn" href="<?php echo $basePath; ?>/pages/projects.php"><i class="lucide-folder-kanban"></i> Browse Projects</a>
            <a class="btn btn-ghost" href="<?php echo $basePath; ?>/pages/about.php"><i class="lucide-info"></i> About This Project</a>
        </div>
        <div class="hero-visual three-marketplace-card" data-three-marketplace aria-label="Animated relational marketplace visual">
            <div class="three-marketplace-bg" aria-hidden="true"></div>
            <canvas class="three-marketplace-canvas"></canvas>
            <div class="three-marketplace-badge">
                <span aria-hidden="true"></span>
                Relational Marketplace Model
            </div>
        </div>
    </div>

    <aside class="hero-panel" aria-label="Quick actions">
        <div class="hero-panel-heading">
            <h3><?php echo render_local_icon('dashboard', 'quick-panel-icon', 'Quick Actions'); ?> Quick Actions</h3>
            <p>Open the main create pages quickly and keep the database easy to test during demos.</p>
        </div>
        <ul class="quick-actions-list">
            <li><a class="quick-action-link" href="<?php echo $basePath; ?>/pages/add_client.php"><span class="quick-action-icon qa-clients"></span><span class="quick-action-text">Add New Client</span></a></li>
            <li><a class="quick-action-link" href="<?php echo $basePath; ?>/pages/add_freelancer.php"><span class="quick-action-icon qa-freelancers"></span><span class="quick-action-text">Add New Freelancer</span></a></li>
            <li><a class="quick-action-link" href="<?php echo $basePath; ?>/pages/add_project.php"><span class="quick-action-icon qa-projects"></span><span class="quick-action-text">Post a Project</span></a></li>
            <li><a class="quick-action-link" href="<?php echo $basePath; ?>/pages/add_proposal.php"><span class="quick-action-icon qa-proposals"></span><span class="quick-action-text">Submit a Proposal</span></a></li>
            <li><a class="quick-action-link" href="<?php echo $basePath; ?>/pages/add_contract.php"><span class="quick-action-icon qa-contracts"></span><span class="quick-action-text">Create a Contract</span></a></li>
            <li><a class="quick-action-link" href="<?php echo $basePath; ?>/pages/add_skill.php"><span class="quick-action-icon qa-skills"></span><span class="quick-action-text">Add a Skill</span></a></li>
        </ul>
    </aside>
</section>

<section class="section-card reveal">
    <span class="eyebrow"><i class="lucide-bar-chart-3"></i> Live Statistics</span>
    <h2 class="page-title">Database Overview</h2>
    <p class="page-intro">A quick presentation layer for the current records stored in the MySQL database.</p>
    <div class="stats-grid enhanced-stats" style="margin-top:22px;">
        <div class="stat-box">
            <div class="stat-icon icon-users"><?php echo render_local_icon('users', 'stat-svg', 'Users'); ?></div>
            <p class="stat-number" data-count="<?php echo $totalUsers; ?>">0</p>
            <p class="stat-caption">Total Users</p>
        </div>
        <div class="stat-box">
            <div class="stat-icon icon-clients"><?php echo render_local_icon('clients', 'stat-svg', 'Clients'); ?></div>
            <p class="stat-number" data-count="<?php echo $totalClients; ?>">0</p>
            <p class="stat-caption">Clients</p>
        </div>
        <div class="stat-box">
            <div class="stat-icon icon-freelancers"><?php echo render_local_icon('freelancers', 'stat-svg', 'Freelancers'); ?></div>
            <p class="stat-number" data-count="<?php echo $totalFreelancers; ?>">0</p>
            <p class="stat-caption">Freelancers</p>
        </div>
        <div class="stat-box">
            <div class="stat-icon icon-projects"><?php echo render_local_icon('projects', 'stat-svg', 'Projects'); ?></div>
            <p class="stat-number" data-count="<?php echo $totalProjects; ?>">0</p>
            <p class="stat-caption">Projects</p>
        </div>
        <div class="stat-box">
            <div class="stat-icon icon-proposals"><?php echo render_local_icon('proposals', 'stat-svg', 'Proposals'); ?></div>
            <p class="stat-number" data-count="<?php echo $totalProposals; ?>">0</p>
            <p class="stat-caption">Proposals</p>
        </div>
        <div class="stat-box">
            <div class="stat-icon icon-contracts"><?php echo render_local_icon('contracts', 'stat-svg', 'Contracts'); ?></div>
            <p class="stat-number" data-count="<?php echo $totalContracts; ?>">0</p>
            <p class="stat-caption">Contracts</p>
        </div>
        <div class="stat-box">
            <div class="stat-icon icon-skills"><?php echo render_local_icon('skills', 'stat-svg', 'Skills'); ?></div>
            <p class="stat-number" data-count="<?php echo $totalSkills; ?>">0</p>
            <p class="stat-caption">Skills</p>
        </div>
    </div>
</section>

<div class="two-column">
    <section class="section-card reveal">
        <span class="eyebrow"><i class="lucide-activity"></i> Recent Activity</span>
        <h2 class="page-title" style="font-size:1.25rem;">Latest Projects</h2>
        <div class="mini-list" style="margin-top:16px;">
            <?php if ($recentProjects && $recentProjects->num_rows > 0): ?>
                <?php while ($rp = $recentProjects->fetch_assoc()): ?>
                    <div class="mini-list-item">
                        <div>
                            <h3><a class="text-link" href="<?php echo $basePath; ?>/pages/project_details.php?project_id=<?php echo $rp['project_id']; ?>"><?php echo htmlspecialchars($rp['title']); ?></a></h3>
                            <p>Client: <?php echo htmlspecialchars($rp['client_name']); ?></p>
                        </div>
                        <div class="mini-list-meta">
                            <?php
                            $statusClass = strtolower(str_replace(' ', '', $rp['status']));
                            ?>
                            <span class="badge badge-<?php echo $statusClass; ?>"><?php echo htmlspecialchars($rp['status']); ?></span>
                            <span class="price">$<?php echo number_format((float)$rp['budget'], 2); ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="muted-text">No projects yet.</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="section-card reveal">
        <span class="eyebrow"><i class="lucide-activity"></i> Recent Activity</span>
        <h2 class="page-title" style="font-size:1.25rem;">Latest Proposals</h2>
        <div class="mini-list" style="margin-top:16px;">
            <?php if ($recentProposals && $recentProposals->num_rows > 0): ?>
                <?php while ($proposal = $recentProposals->fetch_assoc()): ?>
                    <div class="mini-list-item">
                        <div>
                            <h3><?php echo htmlspecialchars($proposal['freelancer_name']); ?></h3>
                            <p>For: <?php echo htmlspecialchars($proposal['project_title']); ?></p>
                        </div>
                        <div class="mini-list-meta">
                            <span class="badge badge-<?php echo strtolower($proposal['status']); ?>"><?php echo htmlspecialchars($proposal['status']); ?></span>
                            <span class="price">$<?php echo number_format((float)$proposal['bid_amount'], 2); ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="muted-text">No proposals yet.</p>
            <?php endif; ?>
        </div>
    </section>
</div>

<section class="section-card reveal">
    <span class="eyebrow"><i class="lucide-compass"></i> System Navigation</span>
    <h2 class="page-title">Explore All Sections</h2>
    <p class="page-intro">Use these modules to browse, insert, update, and delete database records.</p>
    <div class="card-grid" style="margin-top:22px;">
        <a href="<?php echo $basePath; ?>/pages/clients.php" class="nav-card">
            <div class="nav-card-icon icon-clients"><?php echo render_local_icon('clients', 'card-svg', 'Clients'); ?></div>
            <h3>Clients</h3>
            <p>View, add, edit, and delete client records.</p>
        </a>
        <a href="<?php echo $basePath; ?>/pages/freelancers.php" class="nav-card">
            <div class="nav-card-icon icon-freelancers"><?php echo render_local_icon('freelancers', 'card-svg', 'Freelancers'); ?></div>
            <h3>Freelancers</h3>
            <p>Manage freelancer profiles and biographies.</p>
        </a>
        <a href="<?php echo $basePath; ?>/pages/projects.php" class="nav-card">
            <div class="nav-card-icon icon-projects"><?php echo render_local_icon('projects', 'card-svg', 'Projects'); ?></div>
            <h3>Projects</h3>
            <p>Browse and manage all posted projects.</p>
        </a>
        <a href="<?php echo $basePath; ?>/pages/proposals.php" class="nav-card">
            <div class="nav-card-icon icon-proposals"><?php echo render_local_icon('proposals', 'card-svg', 'Proposals'); ?></div>
            <h3>Proposals</h3>
            <p>Review freelancer bids and statuses.</p>
        </a>
        <a href="<?php echo $basePath; ?>/pages/contracts.php" class="nav-card">
            <div class="nav-card-icon icon-contracts"><?php echo render_local_icon('contracts', 'card-svg', 'Contracts'); ?></div>
            <h3>Contracts</h3>
            <p>Manage agreements from accepted proposals.</p>
        </a>
        <a href="<?php echo $basePath; ?>/pages/skills.php" class="nav-card">
            <div class="nav-card-icon icon-skills"><?php echo render_local_icon('skills', 'card-svg', 'Skills'); ?></div>
            <h3>Skills</h3>
            <p>View skills and freelancer-skill assignments.</p>
        </a>
    </div>
</section>

<?php
include __DIR__ . '/includes/footer.php';
$conn->close();
?>

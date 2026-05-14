<nav class="navbar" id="mainNav">
    <div class="container nav-inner">
        <ul class="nav-list" id="navList">
            <li><a href="<?php echo $basePath; ?>/index.php" class="<?php echo $currentPage === 'index' ? 'active' : ''; ?>"><i class="lucide-layout-dashboard"></i> Home</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/clients.php" class="<?php echo in_array($currentPage, ['clients','add_client','edit_client']) ? 'active' : ''; ?>"><i class="lucide-briefcase"></i> Clients</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/freelancers.php" class="<?php echo in_array($currentPage, ['freelancers','add_freelancer','edit_freelancer']) ? 'active' : ''; ?>"><i class="lucide-user-check"></i> Freelancers</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/projects.php" class="<?php echo in_array($currentPage, ['projects','add_project','edit_project','project_details']) ? 'active' : ''; ?>"><i class="lucide-folder-kanban"></i> Projects</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/proposals.php" class="<?php echo in_array($currentPage, ['proposals','add_proposal','edit_proposal']) ? 'active' : ''; ?>"><i class="lucide-file-text"></i> Proposals</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/contracts.php" class="<?php echo in_array($currentPage, ['contracts','add_contract','edit_contract']) ? 'active' : ''; ?>"><i class="lucide-file-signature"></i> Contracts</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/skills.php" class="<?php echo in_array($currentPage, ['skills','add_skill','edit_skill','add_freelancer_skill']) ? 'active' : ''; ?>"><i class="lucide-sparkles"></i> Skills</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/about.php" class="<?php echo $currentPage === 'about' ? 'active' : ''; ?>"><i class="lucide-info"></i> About</a></li>
        </ul>
        <button class="nav-toggle" id="navToggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
            <i class="lucide-menu icon-menu"></i>
            <i class="lucide-x icon-close"></i>
        </button>
    </div>
</nav>
<main>
    <div class="container page-frame">

<?php
require_once __DIR__ . '/../config/db.php';
$pageTitle = 'Clients | Freelance Marketplace System';

$search = trim($_GET['search'] ?? '');
$successMsg = $_GET['success'] ?? '';
$errorMsg = $_GET['error'] ?? '';

$query = "
    SELECT c.client_id, u.name, u.email, u.registration_date
    FROM Client c
    INNER JOIN `User` u ON c.client_id = u.user_id
";
if ($search !== '') {
    $query .= " WHERE u.name LIKE ? OR u.email LIKE ?";
}
$query .= " ORDER BY c.client_id";

if ($search !== '') {
    $stmt = $conn->prepare($query);
    $like = '%' . $search . '%';
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $clients = $stmt->get_result();
} else {
    $clients = $conn->query($query);
}

include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/navbar.php';
?>

<section class="table-card sr-hidden">
    <div class="section-heading">
        <div>
            <span class="eyebrow"><i class="lucide-briefcase"></i> Client Records</span>
            <h2 class="page-title">Clients</h2>
            <p class="page-intro">All registered clients in the system.</p>
        </div>
        <div class="section-actions">
            <a class="btn" href="<?php echo $basePath; ?>/pages/add_client.php"><i class="lucide-plus"></i> Add Client</a>
        </div>
    </div>

    <?php if ($successMsg !== ''): ?><div class="message success"><i class="lucide-check-circle"></i> <?php echo htmlspecialchars($successMsg); ?></div><?php endif; ?>
    <?php if ($errorMsg !== ''): ?><div class="message error"><i class="lucide-alert-circle"></i> <?php echo htmlspecialchars($errorMsg); ?></div><?php endif; ?>

    <form method="GET" action="" class="search-bar" style="display:flex;">
        <input type="text" name="search" placeholder="Search by name or email..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-secondary"><i class="lucide-search"></i> Search</button>
        <?php if ($search !== ''): ?><a href="<?php echo $basePath; ?>/pages/clients.php" class="btn btn-secondary"><i class="lucide-x"></i> Clear</a><?php endif; ?>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($clients && $clients->num_rows > 0): ?>
                    <?php while ($row = $clients->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['client_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['registration_date']); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-secondary" href="<?php echo $basePath; ?>/pages/edit_client.php?id=<?php echo $row['client_id']; ?>"><i class="lucide-pencil"></i> Edit</a>
                                    <a class="btn btn-sm btn-danger" href="<?php echo $basePath; ?>/pages/delete_client.php?id=<?php echo $row['client_id']; ?>" onclick="return confirm('Are you sure you want to delete this client?');"><i class="lucide-trash-2"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="lucide-inbox"></i>
                                <p>No clients found.</p>
                                <a class="btn" href="<?php echo $basePath; ?>/pages/add_client.php"><i class="lucide-plus"></i> Add the first client</a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; $conn->close(); ?>
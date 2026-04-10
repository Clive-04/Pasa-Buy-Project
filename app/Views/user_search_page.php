<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="profile-content-panel">
                <div class="page-top">
                    <div>
                        <span class="page-badge">Community Search</span>
                        <h1>Search Users</h1>
                        <p>Find users and open their profile to leave a rating.</p>
                    </div>
                </div>

                <?php if ($keyword === ''): ?>
                    <p>Type a name, username, or email in the navbar search.</p>
                <?php elseif (empty($users)): ?>
                    <p>No users found for <strong><?= esc($keyword) ?></strong>.</p>
                <?php else: ?>
                    <div class="user-search-grid">
                        <?php foreach ($users as $user): ?>
                            <a href="<?= base_url('users/' . $user['id']) ?>" class="user-search-card">
                                <div class="user-search-avatar">
                                    <?php if (!empty($user['profile_photo'])): ?>
                                        <img src="<?= base_url('uploads/profile_photos/' . $user['profile_photo']) ?>" alt="Profile Photo">
                                    <?php else: ?>
                                        <?= strtoupper(substr($user['first_name'] ?? 'U', 0, 1)) ?>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <h3><?= esc(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?></h3>
                                    <p>@<?= esc($user['username'] ?? 'username') ?></p>
                                    <small><?= esc($user['email'] ?? '') ?></small>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
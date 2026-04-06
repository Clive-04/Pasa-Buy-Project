<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="profile-content-panel">
                <div class="page-top">
                    <div>
                        <span class="page-badge">User Profile</span>
                        <h1>My Profile</h1>
                        <p>Manage your profile details, activity, and account settings.</p>
                    </div>
                </div>

                <div class="profile-layout">
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-avatar">
                                <?php if (!empty($user['profile_photo'])): ?>
                                    <img src="<?= base_url('uploads/profile_photos/' . $user['profile_photo']) ?>" alt="Profile Photo">
                                <?php else: ?>
                                    <span>👤</span>
                                <?php endif; ?>
                            </div>

                            <h2><?= esc(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''))) ?></h2>
                            <p>@<?= esc($user['username'] ?? 'username') ?></p>

                            <button class="status-btn">Active Status</button>
                        </div>

                        <div class="profile-stats">
                            <div class="profile-stat-box">
                                <h3><?= esc($totalRequests) ?></h3>
                                <p>Total Request(s)</p>
                            </div>

                            <div class="profile-stat-box">
                                <h3><?= esc($acceptedRequests) ?></h3>
                                <p>Accepted Request(s)</p>
                            </div>

                            <div class="profile-stat-box">
                                <h3><?= esc($rating) ?></h3>
                                <p>Rating: ★★★★★</p>
                            </div>
                        </div>

                        <div class="profile-about">
                            <h3>About Me</h3>
                            <p>
                                <?= !empty($user['about_me'])
                                    ? esc($user['about_me'])
                                    : 'You have not added an About Me yet.' ?>
                            </p>
                        </div>
                    </div>

                    <aside class="profile-settings">
                        <h3>Settings Menu</h3>

                        <button type="button" class="settings-link" onclick="openSettingsModal('profileSettingsModal')">
                            Profile Settings
                        </button>

                        <button type="button" class="settings-link" onclick="openSettingsModal('rateWebsiteModal')">
                            Rate Website
                        </button>

                        <button type="button" class="settings-link" onclick="openSettingsModal('referFriendModal')">
                            Refer a Friend
                        </button>
                    </aside>

                    <?= $this->include('includes/profile_settings_modals') ?>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
<aside class="dashboard-sidebar">
    <?php
    if (session()->has('user_id')) {
        $user_name = session('user_name');
        $first_name = explode(' ', $user_name)[0] ?? 'User';
        $avatar = strtoupper(substr($first_name, 0, 1));
    } else {
        $first_name = 'Guest';
        $avatar = 'G';
    }
    ?>
    <div class="dashboard-profile-card">
        <div class="profile-avatar"><?php echo $avatar; ?></div>
        <h3><?php echo $first_name; ?></h3>
        <p>Community User</p>
    </div>

    <nav class="dashboard-menu">
        <a href="<?= base_url('dashboard') ?>" class="dashboard-link">Dashboard</a>
        <a href="<?= base_url('post-request') ?>" class="dashboard-link">Post a Request</a>
        <a href="<?= base_url('browse-requests') ?>" class="dashboard-link">Browse Requests</a>
        <a href="<?= base_url('my-requests') ?>" class="dashboard-link">My Requests</a>
        <a href="<?= base_url('messages') ?>" class="dashboard-link">Messages</a>
        <a href="<?= base_url('notifications') ?>" class="dashboard-link">Notifications</a>
        <a href="#" class="dashboard-link disabled-link">Payments</a>
        <a href="#" class="dashboard-link disabled-link">Profile</a>
        <a href="<?= base_url('logout') ?>" class="dashboard-link logout-link">Logout</a>
    </nav>
</aside>
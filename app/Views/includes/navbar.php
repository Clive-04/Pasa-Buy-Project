<nav class="navbar">
    <!-- LEFT: LOGO -->
    <div class="nav-left">
        <a href="<?= session()->has('user_id') ? base_url('dashboard') : base_url('login') ?>" class="logo">
            <span class="logo-icon">🛍️</span>
            <span class="logo-text">Pasa-Buy</span>
        </a>
    </div>

    <!-- CENTER: SIMPLE LINKS -->
    <?php $current = uri_string(); ?>

    <div class="nav-center">
        <a href="<?= session()->has('user_id') ? base_url('dashboard') : base_url('login') ?>"
        class="nav-link <?= ($current == '' || $current == 'dashboard' || $current == 'login') ? 'active' : '' ?>">
            Home
        </a>

        <a href="<?= base_url('about') ?>"
        class="nav-link <?= ($current == 'about') ? 'active' : '' ?>">
            About
        </a>

        <a href="<?= base_url('contact') ?>"
        class="nav-link <?= ($current == 'contact') ? 'active' : '' ?>">
            Contact
        </a>
    </div>

    <!-- RIGHT: AUTH -->
    <div class="nav-right">
        <?php if (session()->has('user_id')): ?>
            <span class="nav-welcome">
                Welcome, <?= session('user_name') ? explode(' ', session('user_name'))[0] : 'User' ?>!
            </span>
        <?php else: ?>
            <a href="<?= base_url('login') ?>" class="nav-login">Login</a>
            <a href="<?= base_url('register') ?>" class="nav-signup">Sign Up</a>
        <?php endif; ?>
    </div>
</nav>
<nav class="navbar">
    <div class="nav-left">
        <a href="index.php" class="logo">
            <span class="logo-icon">🛍️</span>
            <span class="logo-text">Pasa-Buy</span>
        </a>
    </div>

    <div class="nav-center">
        <a href="<?= base_url('/') ?>" class="nav-link active">Home</a>
        <a href="#" class="nav-link">How It Works</a>
        <a href="#" class="nav-link">Features</a>
        <a href="#" class="nav-link">Community Shops</a>
        <a href="#" class="nav-link">Contact</a>
    </div>

    <div class="nav-right">
        <?php if (session()->has('user_id')): ?>
            <span class="nav-welcome">Welcome, <?= session('user_name') ? explode(' ', session('user_name'))[0] : 'User' ?>!</span>
        <?php else: ?>
            <a href="<?= base_url('login') ?>" class="nav-login">Login</a>
            <a href="<?= base_url('register') ?>" class="nav-signup">Sign Up</a>
        <?php endif; ?>
    </div>
</nav>
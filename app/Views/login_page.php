<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<main class="auth-page">
    <section class="auth-section">
        <div class="auth-container login-layout">
            <div class="auth-visual">
                <div class="visual-overlay"></div>
                <div class="visual-content">
                    <span class="visual-badge">Welcome Back</span>
                    <h1>Login to Pasa-Buy</h1>
                    <p>
                        Access your requests, track deliveries, message runners,
                        and manage your local errands in one place.
                    </p>

                    <div class="visual-features">
                        <div class="visual-feature-card">
                            <h3>Track Requests</h3>
                            <p>See live updates from accepted to delivered.</p>
                        </div>
                        <div class="visual-feature-card">
                            <h3>Message Runners</h3>
                            <p>Stay connected for faster coordination.</p>
                        </div>
                        <div class="visual-feature-card">
                            <h3>Secure Payments</h3>
                            <p>Manage transactions safely and easily.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-form-side">
                <div class="auth-card">
                    <div class="auth-header">
                        <h2>Sign In</h2>
                        <p>Enter your account details to continue.</p>
                    </div>

                    <form action="<?= base_url('login/process') ?>" method="POST" class="auth-form">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <div class="form-row form-row-between">
                            <label class="checkbox-group">
                                <input type="checkbox" name="remember_me">
                                <span>Remember me</span>
                            </label>

                            <a href="#" class="text-link">Forgot password?</a>
                        </div>

                        <button type="submit" class="auth-btn primary-btn">Login</button>

                        <div class="auth-divider">
                            <span>or</span>
                        </div>

                        <a href="#" class="auth-btn secondary-btn">Continue with Google</a>

                        <p class="auth-footer-text">
                            Don’t have an account?
                            <a href="register.php">Register here</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
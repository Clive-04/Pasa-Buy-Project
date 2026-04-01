<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="auth-page">
    <section class="auth-section">
        <div class="auth-container register-layout">
            <div class="auth-form-side">
                <div class="auth-card register-card">
                    <div class="auth-header">
                        <h2>Create Account</h2>
                        <p>Join Pasa-Buy and start requesting or delivering nearby items.</p>
                    </div>

                    <form action="<?= base_url('register/process') ?>" method="POST" class="auth-form" enctype="multipart/form-data">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Create a password" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="address">Address / Barangay</label>
                            <input type="text" id="address" name="address" placeholder="Enter your address or barangay" required>
                        </div>
                    </div>

                    <label class="checkbox-group terms-check">
                        <input type="checkbox" name="terms" required>
                        <span>I agree to the Terms and Conditions and Privacy Policy.</span>
                    </label>

                    <button type="submit" class="auth-btn primary-btn">Create Account</button>

                    <p class="auth-footer-text">
                        Already have an account?
                        <a href="<?= base_url('login') ?>">Login here</a>
                    </p>
                </form>
                </div>
            </div>

            <div class="auth-visual register-visual">
                <div class="visual-overlay"></div>
                <div class="visual-content">
                    <span class="visual-badge">Join the Community</span>
                    <h1>Start using Pasa-Buy today</h1>
                    <p>
                        Help your community by requesting or delivering urgent items
                        faster, easier, and more securely.
                    </p>

                    <div class="visual-features">
                        <div class="visual-feature-card">
                            <h3>Post Requests</h3>
                            <p>Request items from nearby stores in a clear and organized way.</p>
                        </div>
                        <div class="visual-feature-card">
                            <h3>Become a Runner</h3>
                            <p>Accept nearby requests and earn from helping others.</p>
                        </div>
                        <div class="visual-feature-card">
                            <h3>Community First</h3>
                            <p>Support local stores and connect with nearby residents.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?= $this->include('includes/footer') ?>
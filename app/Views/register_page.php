<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('public/css/landing.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/auth.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div class="nav-left">
        <a href="<?= base_url('/') ?>" class="logo">
            <span class="logo-icon">🛍️</span>
            <span class="logo-text">Pasa-Buy</span>
        </a>
    </div>

    <div class="nav-center">
        <a href="<?= base_url('/') ?>" class="nav-link">Home</a>
        <a href="#" class="nav-link">How It Works</a>
        <a href="#" class="nav-link">Features</a>
        <a href="#" class="nav-link">Community Shops</a>
        <a href="#" class="nav-link">Contact</a>
    </div>

    <div class="nav-right">
        <a href="<?= base_url('login') ?>" class="nav-login">Login</a>
        <a href="<?= base_url('register') ?>" class="nav-signup">Sign Up</a>
    </div>
</nav>

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
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" placeholder="Choose a username" required>
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

                        <div class="form-group">
                            <label for="user_type">User Type</label>
                            <select id="user_type" name="user_type" required>
                                <option value="">Select user type</option>
                                <option value="requester">Requester</option>
                                <option value="runner">Runner</option>
                                <option value="both">Both</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="valid_id">Upload Valid ID</label>
                            <input type="file" id="valid_id" name="valid_id">
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

</body>
</html>
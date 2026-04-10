<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="profile-content-panel">
                <div class="page-top">
                    <div>
                        <span class="page-badge">Community Profile</span>
                        <h1>User Profile</h1>
                        <p>View this user and leave a rating.</p>
                    </div>
                </div>

                <div class="profile-layout">
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-avatar">
                                <?php if (!empty($profileUser['profile_photo'])): ?>
                                    <img src="<?= base_url('uploads/profile_photos/' . $profileUser['profile_photo']) ?>" alt="Profile Photo">
                                <?php else: ?>
                                    <span>👤</span>
                                <?php endif; ?>
                            </div>

                            <h2><?= esc(trim(($profileUser['first_name'] ?? '') . ' ' . ($profileUser['last_name'] ?? ''))) ?></h2>
                            <p>@<?= esc($profileUser['username'] ?? 'username') ?></p>
                        </div>

                        <div class="profile-stats">
                            <div class="profile-stat-box">
                                <h3><?= esc($totalRequests) ?></h3>
                                <p>Total Request(s)</p>
                            </div>

                            <div class="profile-stat-box">
                                <h3><?= esc($averageRating) ?></h3>
                                <p>User Rating</p>
                            </div>
                        </div>

                        <div class="profile-about">
                            <h3>About Me</h3>
                            <p>
                                <?= !empty($profileUser['about_me'])
                                    ? esc($profileUser['about_me'])
                                    : 'This user has not added an About Me yet.' ?>
                            </p>
                        </div>
                    </div>

                    <aside class="profile-settings">
                        <h3>Rate This User</h3>

                        <?php if ($isOwnProfile): ?>
                            <p>You cannot rate your own account.</p>
                        <?php else: ?>
                            <form action="<?= base_url('users/' . $profileUser['id'] . '/rate') ?>" method="POST" class="modal-form">
                                <div class="form-group">
                                    <label for="rating">Your Rating</label>
                                    <select id="rating" name="rating" required>
                                        <option value="">Select rating</option>
                                        <option value="5" <?= (!empty($myRating) && $myRating['rating'] == 5) ? 'selected' : '' ?>>5 - Excellent</option>
                                        <option value="4" <?= (!empty($myRating) && $myRating['rating'] == 4) ? 'selected' : '' ?>>4 - Very Good</option>
                                        <option value="3" <?= (!empty($myRating) && $myRating['rating'] == 3) ? 'selected' : '' ?>>3 - Good</option>
                                        <option value="2" <?= (!empty($myRating) && $myRating['rating'] == 2) ? 'selected' : '' ?>>2 - Fair</option>
                                        <option value="1" <?= (!empty($myRating) && $myRating['rating'] == 1) ? 'selected' : '' ?>>1 - Poor</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="feedback">Feedback</label>
                                    <textarea id="feedback" name="feedback" rows="4"><?= esc($myRating['feedback'] ?? '') ?></textarea>
                                </div>

                                <button type="submit" class="auth-btn primary-btn">
                                    <?= !empty($myRating) ? 'Update Rating' : 'Submit Rating' ?>
                                </button>
                            </form>
                        <?php endif; ?>
                    </aside>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
<!-- PROFILE SETTINGS MODAL -->
<div id="profileSettingsModal" class="settings-modal">
    <div class="settings-modal-box">
        <button class="modal-close" onclick="closeSettingsModal('profileSettingsModal')">&times;</button>
        <h2>Profile Settings</h2>

        <form action="<?= base_url('profile/update') ?>" method="POST" enctype="multipart/form-data" class="modal-form">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name"
                    value="<?= esc(trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''))) ?>">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username"
                    value="<?= esc($user['username'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="about_me">About Me</label>
                <textarea id="about_me" name="about_me" rows="4"><?= esc($user['about_me'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label for="profile_photo">Profile Photo</label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
            </div>

            <button type="submit" class="auth-btn primary-btn">Save Changes</button>
        </form>
    </div>
</div>

<!-- RATE WEBSITE MODAL -->
<div id="rateWebsiteModal" class="settings-modal">
    <div class="settings-modal-box">
        <button class="modal-close" onclick="closeSettingsModal('rateWebsiteModal')">&times;</button>
        <h2>Rate Website</h2>

        <form action="<?= base_url('profile/rate-website') ?>" method="POST" class="modal-form">
            <div class="form-group">
                <label for="rating">Your Rating</label>
                <select id="rating" name="rating" required>
                    <option value="">Select rating</option>
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Very Good</option>
                    <option value="3">3 - Good</option>
                    <option value="2">2 - Fair</option>
                    <option value="1">1 - Poor</option>
                </select>
            </div>

            <div class="form-group">
                <label for="feedback">Feedback</label>
                <textarea id="feedback" name="feedback" rows="4" placeholder="Share your feedback..."></textarea>
            </div>

            <button type="submit" class="auth-btn primary-btn">Submit Rating</button>
        </form>
    </div>
</div>

<!-- REFER A FRIEND MODAL -->
<div id="referFriendModal" class="settings-modal">
    <div class="settings-modal-box">
        <button class="modal-close" onclick="closeSettingsModal('referFriendModal')">&times;</button>
        <h2>Refer a Friend</h2>

        <form action="<?= base_url('profile/refer-friend') ?>" method="POST" class="modal-form">
            <div class="form-group">
                <label for="friend_name">Friend's Name</label>
                <input type="text" id="friend_name" name="friend_name" placeholder="Enter your friend's name" required>
            </div>

            <div class="form-group">
                <label for="friend_email">Friend's Email</label>
                <input type="email" id="friend_email" name="friend_email" placeholder="Enter your friend's email" required>
            </div>

            <button type="submit" class="auth-btn primary-btn">Send Invite</button>
        </form>
    </div>
</div>

<script>
    function openSettingsModal(modalId) {
        document.getElementById(modalId).classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSettingsModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    window.addEventListener('click', function (e) {
        document.querySelectorAll('.settings-modal').forEach(function(modal) {
            if (e.target === modal) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });
    });
</script>
<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="messages-page-panel">
                <div class="page-top">
                    <div>
                        <span class="page-badge">Updates</span>
                        <h1>Notifications</h1>
                        <p>Stay informed about requests, deliveries, and message updates.</p>
                    </div>

                    <a href="<?= base_url('dashboard') ?>" class="page-back-btn">Back to Dashboard</a>
                </div>

                <div class="notifications-list">
                    <div class="notification-card unread">
                        <div class="notification-icon">📦</div>
                        <div class="notification-content">
                            <h3>Your request was accepted</h3>
                            <p>John D. accepted your request for 1 Ream Bond Paper.</p>
                            <span>2 minutes ago</span>
                        </div>
                    </div>

                    <div class="notification-card unread">
                        <div class="notification-icon">💬</div>
                        <div class="notification-content">
                            <h3>New message received</h3>
                            <p>Bea R. sent you a message about your item request.</p>
                            <span>5 minutes ago</span>
                        </div>
                    </div>

                    <div class="notification-card">
                        <div class="notification-icon">🚚</div>
                        <div class="notification-content">
                            <h3>Order is on the way</h3>
                            <p>Your Bottled Water Pack is now on the way to your address.</p>
                            <span>20 minutes ago</span>
                        </div>
                    </div>

                    <div class="notification-card">
                        <div class="notification-icon">✅</div>
                        <div class="notification-content">
                            <h3>Delivery completed</h3>
                            <p>Your Paracetamol 500mg request was marked as delivered.</p>
                            <span>1 hour ago</span>
                        </div>
                    </div>

                    <div class="notification-card">
                        <div class="notification-icon">💳</div>
                        <div class="notification-content">
                            <h3>Payment confirmed</h3>
                            <p>Your payment for the request has been successfully recorded.</p>
                            <span>3 hours ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
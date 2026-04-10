<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="dashboard-hero">
                <div>
                    <span class="dashboard-badge">Welcome Back</span>
                    <h1>Pasa-Buy Dashboard</h1>
                    <p>
                        Manage your local requests, track deliveries, and stay updated with your community errands.
                    </p>
                </div>

                <div class="dashboard-hero-actions">
                    <a href="<?= base_url('post-request') ?>" class="dashboard-btn primary-btn">Post a Request</a>
                    <a href="<?= base_url('browse-requests') ?>" class="dashboard-btn secondary-btn">Browse Requests</a>
                </div>
            </div>

            <div class="dashboard-stats">
                <div class="stat-box">
                    <span class="stat-label">Active Requests</span>
                    <h2><?= esc($activeRequests ?? 0) ?></h2>
                    <p>Requests currently in progress</p>
                </div>

                <div class="stat-box">
                    <span class="stat-label">Accepted Tasks</span>
                    <h2><?= esc($acceptedTasks ?? 0) ?></h2>
                    <p>Errands you are currently handling</p>
                </div>

                <div class="stat-box">
                    <span class="stat-label">Completed Orders</span>
                    <h2><?= esc($completedOrders ?? 0) ?></h2>
                    <p>Successfully delivered requests</p>
                </div>

                <div class="stat-box">
                    <span class="stat-label">Wallet Balance</span>
                    <h2>₱<?= number_format((float) ($walletBalance ?? 0), 2) ?></h2>
                    <p>Available wallet funds</p>
                </div>
            </div>

            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>My Active Requests</h3>
                        <a href="<?= base_url('my-requests') ?>">View All</a>
                    </div>

                    <div class="request-list">
                        <?php if (!empty($myActiveRequests)): ?>
                            <?php foreach ($myActiveRequests as $request): ?>
                                <div class="request-item">
                                    <div>
                                        <h4><?= esc($request['item_name']) ?></h4>
                                        <p><?= esc($request['store_name']) ?> • <?= ucfirst(str_replace('_', ' ', $request['status'])) ?></p>
                                    </div>
                                    <a href="<?= base_url('request-details/' . $request['id']) ?>" class="status-badge <?= esc($request['status']) ?>">
                                        <?= ucfirst(str_replace('_', ' ', $request['status'])) ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="request-item">
                                <div>
                                    <h4>No active requests yet</h4>
                                    <p>Your active requests will appear here.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Available Requests</h3>
                        <a href="<?= base_url('browse-requests') ?>">Browse</a>
                    </div>

                    <div class="request-list">
                        <?php if (!empty($availableRequests)): ?>
                            <?php foreach ($availableRequests as $request): ?>
                                <div class="request-item">
                                    <div>
                                        <h4><?= esc($request['item_name']) ?></h4>
                                        <p>Fee: ₱<?= number_format((float) ($request['service_fee'] ?? 0), 2) ?></p>
                                    </div>
                                    <a href="<?= base_url('request-details/' . $request['id']) ?>" class="mini-btn">View</a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="request-item">
                                <div>
                                    <h4>No available requests</h4>
                                    <p>New nearby requests will appear here.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="dashboard-card wide-card">
                    <div class="card-header">
                        <h3>Recent Notifications</h3>
                        <a href="<?= base_url('notifications') ?>">See More</a>
                    </div>

                    <div class="activity-timeline">
                        <?php if (!empty($recentActivity)): ?>
                            <?php foreach ($recentActivity as $activity): ?>
                                <div class="activity-item">
                                    <div class="activity-dot"></div>
                                    <div>
                                        <h4><?= esc($activity['title']) ?></h4>
                                        <p><?= esc($activity['content']) ?></p>
                                        <small><?= date('M j, Y g:i A', strtotime($activity['created_at'])) ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="activity-item">
                                <div class="activity-dot"></div>
                                <div>
                                    <h4>No notifications yet</h4>
                                    <p>Your request and payment updates will appear here.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Quick Actions</h3>
                    </div>

                    <div class="quick-actions">
                        <a href="<?= base_url('post-request') ?>" class="quick-action-card">
                            <span>📝</span>
                            <p>Post New Request</p>
                        </a>

                        <a href="<?= base_url('browse-requests') ?>" class="quick-action-card">
                            <span>📍</span>
                            <p>Browse Requests</p>
                        </a>

                        <a href="<?= base_url('wallet') ?>" class="quick-action-card">
                            <span>💰</span>
                            <p>Open Wallet</p>
                        </a>

                        <a href="<?= base_url('notifications') ?>" class="quick-action-card">
                            <span>🔔</span>
                            <p>View Notifications</p>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
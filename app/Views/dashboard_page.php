<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <aside class="dashboard-sidebar">
            <div class="dashboard-profile-card">
                <div class="profile-avatar">C</div>
                <h3>Clive Benito</h3>
                <p>Community User</p>
            </div>

            <nav class="dashboard-menu">
                <a href="<?= base_url('dashboard') ?>" class="dashboard-link active">Dashboard</a>
                <a href="#" class="dashboard-link">Post Request</a>
                <a href="#" class="dashboard-link">Browse Requests</a>
                <a href="#" class="dashboard-link">My Requests</a>
                <a href="#" class="dashboard-link">Messages</a>
                <a href="#" class="dashboard-link">Payments</a>
                <a href="#" class="dashboard-link">Profile</a>
                <a href="<?= base_url('logout') ?>" class="dashboard-link logout-link">Logout</a>
            </nav>
        </aside>

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
                    <a href="#" class="dashboard-btn primary-btn">Post a Request</a>
                    <a href="#" class="dashboard-btn secondary-btn">Browse Requests</a>
                </div>
            </div>

            <div class="dashboard-stats">
                <div class="stat-box">
                    <span class="stat-label">Active Requests</span>
                    <h2>04</h2>
                    <p>Requests currently in progress</p>
                </div>

                <div class="stat-box">
                    <span class="stat-label">Accepted Tasks</span>
                    <h2>02</h2>
                    <p>Errands you are currently handling</p>
                </div>

                <div class="stat-box">
                    <span class="stat-label">Completed Orders</span>
                    <h2>18</h2>
                    <p>Successfully delivered requests</p>
                </div>

                <div class="stat-box">
                    <span class="stat-label">Wallet Balance</span>
                    <h2>₱520</h2>
                    <p>Available earnings and balance</p>
                </div>
            </div>

            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>My Active Requests</h3>
                        <a href="#">View All</a>
                    </div>

                    <div class="request-list">
                        <div class="request-item">
                            <div>
                                <h4>Paracetamol 500mg</h4>
                                <p>Mercury Drug • Urgent</p>
                            </div>
                            <span class="status-badge pending">Pending</span>
                        </div>

                        <div class="request-item">
                            <div>
                                <h4>1 Ream Bond Paper</h4>
                                <p>National Bookstore • Accepted</p>
                            </div>
                            <span class="status-badge accepted">Accepted</span>
                        </div>

                        <div class="request-item">
                            <div>
                                <h4>Bottled Water Pack</h4>
                                <p>Local Grocery • On the Way</p>
                            </div>
                            <span class="status-badge delivery">On the Way</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Nearby Requests</h3>
                        <a href="#">Browse</a>
                    </div>

                    <div class="request-list">
                        <div class="request-item">
                            <div>
                                <h4>Notebook and Ballpen</h4>
                                <p>0.8 km away • Fee: ₱25</p>
                            </div>
                            <a href="#" class="mini-btn">Accept</a>
                        </div>

                        <div class="request-item">
                            <div>
                                <h4>Baby Milk Formula</h4>
                                <p>1.1 km away • Fee: ₱40</p>
                            </div>
                            <a href="#" class="mini-btn">Accept</a>
                        </div>

                        <div class="request-item">
                            <div>
                                <h4>Snack Pack</h4>
                                <p>0.5 km away • Fee: ₱20</p>
                            </div>
                            <a href="#" class="mini-btn">Accept</a>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card wide-card">
                    <div class="card-header">
                        <h3>Recent Activity</h3>
                        <a href="#">See More</a>
                    </div>

                    <div class="activity-timeline">
                        <div class="activity-item">
                            <div class="activity-dot"></div>
                            <div>
                                <h4>Your request for Paracetamol was posted</h4>
                                <p>2 minutes ago</p>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot"></div>
                            <div>
                                <h4>John accepted your Bond Paper request</h4>
                                <p>12 minutes ago</p>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-dot"></div>
                            <div>
                                <h4>Your bottled water order is now on the way</h4>
                                <p>25 minutes ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Quick Actions</h3>
                    </div>

                    <div class="quick-actions">
                        <a href="#" class="quick-action-card">
                            <span>📝</span>
                            <p>Post New Request</p>
                        </a>

                        <a href="#" class="quick-action-card">
                            <span>📍</span>
                            <p>Find Nearby Runners</p>
                        </a>

                        <a href="#" class="quick-action-card">
                            <span>💬</span>
                            <p>Open Messages</p>
                        </a>

                        <a href="#" class="quick-action-card">
                            <span>💳</span>
                            <p>Check Payments</p>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
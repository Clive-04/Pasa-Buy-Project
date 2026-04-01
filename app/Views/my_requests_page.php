<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="request-content-panel">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success" style="padding: 12px; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 20px;">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-error" style="padding: 12px; background: #fee2e2; color: #b91c1c; border-radius: 8px; margin-bottom: 20px;">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="page-top">
                    <div>
                        <span class="page-badge">Request History</span>
                        <h1>My Requests</h1>
                        <p>Track your posted requests and monitor their current status.</p>
                    </div>

                    <a href="<?= base_url('post-request') ?>" class="page-back-btn">New Request</a>
                </div>

                <div class="request-tabs">
                    <button class="tab-btn active">All</button>
                    <button class="tab-btn">Pending</button>
                    <button class="tab-btn">Accepted</button>
                    <button class="tab-btn">On the Way</button>
                    <button class="tab-btn">Delivered</button>
                </div>

                <div class="my-request-list">
                    <?php if (!empty($requests)): ?>
                        <?php foreach ($requests as $request): ?>
                            <div class="my-request-card">
                                <div class="my-request-main">
                                    <h3><?= esc($request['item_name']) ?> (<?= $request['quantity'] ?>)</h3>
                                    <p><?= esc($request['store_name']) ?> • Posted <?= date('M j, Y g:i A', strtotime($request['created_at'])) ?></p>
                                </div>
                                <div class="my-request-meta">
                                    <span class="request-tag <?= $request['urgency'] ?>"><?= ucfirst($request['urgency']) ?></span>
                                    <span class="status-pill <?= $request['status'] ?>"><?= ucfirst(str_replace('_', ' ', $request['status'])) ?></span>
                                    <a href="<?= base_url('request-details/' . $request['id']) ?>" class="btn-light">View</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-requests">
                            <p>You haven't posted any requests yet.</p>
                            <a href="<?= base_url('post-request') ?>" class="btn-primary">Post Your First Request</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="request-content-panel">
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
                    <div class="my-request-card">
                        <div class="my-request-main">
                            <h3>Paracetamol 500mg</h3>
                            <p>Mercury Drug • Posted 10 mins ago</p>
                        </div>
                        <div class="my-request-meta">
                            <span class="request-tag urgent">Urgent</span>
                            <span class="status-pill pending">Pending</span>
                            <a href="<?= base_url('request-details/1') ?>" class="btn-light">View</a>
                        </div>
                    </div>

                    <div class="my-request-card">
                        <div class="my-request-main">
                            <h3>1 Ream Bond Paper</h3>
                            <p>National Bookstore • Posted 1 hour ago</p>
                        </div>
                        <div class="my-request-meta">
                            <span class="request-tag normal">Normal</span>
                            <span class="status-pill accepted">Accepted</span>
                            <a href="<?= base_url('request-details/2') ?>" class="btn-light">View</a>
                        </div>
                    </div>

                    <div class="my-request-card">
                        <div class="my-request-main">
                            <h3>Bottled Water Pack</h3>
                            <p>Nearby Grocery • Posted 2 hours ago</p>
                        </div>
                        <div class="my-request-meta">
                            <span class="request-tag asap">ASAP</span>
                            <span class="status-pill delivery">On the Way</span>
                            <a href="<?= base_url('request-details/3') ?>" class="btn-light">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
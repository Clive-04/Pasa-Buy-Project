<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="request-content-panel">
                <div class="page-top">
                    <div>
                        <span class="page-badge">Community Feed</span>
                        <h1>Browse Requests</h1>
                        <p>Find nearby requests you can accept and complete.</p>
                    </div>

                    <a href="<?= base_url('dashboard') ?>" class="page-back-btn">Back to Dashboard</a>
                </div>

                <div class="filter-bar">
                    <input type="text" placeholder="Search item or store">
                    <select>
                        <option>All Categories</option>
                        <option>Food</option>
                        <option>Medicine</option>
                        <option>School Supplies</option>
                        <option>Household</option>
                    </select>
                    <select>
                        <option>All Urgency</option>
                        <option>Normal</option>
                        <option>Urgent</option>
                        <option>ASAP</option>
                    </select>
                    <select>
                        <option>Sort by Latest</option>
                        <option>Nearest</option>
                        <option>Highest Fee</option>
                    </select>
                </div>

                <div class="request-card-grid">
                    <div class="request-card">
                        <div class="request-card-top">
                            <span class="request-tag urgent">Urgent</span>
                            <span class="request-distance">0.8 km away</span>
                        </div>
                        <h3>Paracetamol 500mg</h3>
                        <p>Store: Mercury Drug</p>
                        <p>Fee Offer: ₱35</p>
                        <p>Posted: 5 mins ago</p>
                        <div class="request-card-actions">
                            <a href="<?= base_url('request-details/1') ?>" class="btn-light">View Details</a>
                            <a href="#" class="btn-gradient">Accept</a>
                        </div>
                    </div>

                    <div class="request-card">
                        <div class="request-card-top">
                            <span class="request-tag normal">Normal</span>
                            <span class="request-distance">1.2 km away</span>
                        </div>
                        <h3>1 Ream Bond Paper</h3>
                        <p>Store: National Bookstore</p>
                        <p>Fee Offer: ₱25</p>
                        <p>Posted: 12 mins ago</p>
                        <div class="request-card-actions">
                            <a href="<?= base_url('request-details/2') ?>" class="btn-light">View Details</a>
                            <a href="#" class="btn-gradient">Accept</a>
                        </div>
                    </div>

                    <div class="request-card">
                        <div class="request-card-top">
                            <span class="request-tag asap">ASAP</span>
                            <span class="request-distance">0.5 km away</span>
                        </div>
                        <h3>Bottled Water Pack</h3>
                        <p>Store: Nearby Grocery</p>
                        <p>Fee Offer: ₱20</p>
                        <p>Posted: 2 mins ago</p>
                        <div class="request-card-actions">
                            <a href="<?= base_url('request-details/3') ?>" class="btn-light">View Details</a>
                            <a href="#" class="btn-gradient">Accept</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
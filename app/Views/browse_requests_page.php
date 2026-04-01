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
                    <?php if (!empty($requests)): ?>
                        <?php foreach ($requests as $request): ?>
                            <?php
                            $posted = strtotime($request['created_at']);
                            $now = time();
                            $diff = $now - $posted;
                            if ($diff < 60) {
                                $time = $diff . ' secs ago';
                            } elseif ($diff < 3600) {
                                $time = floor($diff / 60) . ' mins ago';
                            } elseif ($diff < 86400) {
                                $time = floor($diff / 3600) . ' hours ago';
                            } else {
                                $time = floor($diff / 86400) . ' days ago';
                            }
                            ?>
                            <div class="request-card">
                                <div class="request-card-top">
                                    <span class="request-tag <?php echo strtolower($request['urgency']); ?>"><?php echo ucfirst($request['urgency']); ?></span>
                                    <span class="request-distance">Nearby</span>
                                </div>
                                <h3><?php echo $request['item_name']; ?></h3>
                                <p>Store: <?php echo $request['store_name']; ?></p>
                                <p>Fee Offer: ₱<?php echo $request['service_fee']; ?></p>
                                <p>Posted: <?php echo $time; ?></p>
                                <div class="request-card-actions">
                                    <a href="<?= base_url('request-details/' . $request['id']) ?>" class="btn-light">View Details</a>
                                    <form action="<?= base_url('request/accept/' . $request['id']) ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn-gradient">Accept</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No requests available at the moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
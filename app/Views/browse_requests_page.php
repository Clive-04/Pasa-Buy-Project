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

               <form method="get" action="<?= base_url('browse-requests') ?>" class="filter-bar" id="filterForm">
                    <input type="text" name="search" placeholder="Search item or store"
                        value="<?= esc($_GET['search'] ?? '') ?>"
                        onkeyup="debounceSubmit()">

                    <select name="category" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <option value="food" <?= (($_GET['category'] ?? '') === 'food') ? 'selected' : '' ?>>Food</option>
                        <option value="medicine" <?= (($_GET['category'] ?? '') === 'medicine') ? 'selected' : '' ?>>Medicine</option>
                        <option value="school_supplies" <?= (($_GET['category'] ?? '') === 'school_supplies') ? 'selected' : '' ?>>
                            School Supplies
                        </option>
                        <option value="household" <?= (($_GET['category'] ?? '') === 'household') ? 'selected' : '' ?>>Household</option>
                        <option value="personal_care" <?= (($_GET['category'] ?? '') === 'personal_care') ? 'selected' : '' ?>>
                            Personal Care
                        </option>
                        <option value="other" <?= (($_GET['category'] ?? '') === 'other') ? 'selected' : '' ?>>
                            Other
                        </option>
                    </select>

                    <select name="urgency" onchange="this.form.submit()">
                        <option value="">All Urgency</option>
                        <option value="normal" <?= (($_GET['urgency'] ?? '') === 'normal') ? 'selected' : '' ?>>Normal</option>
                        <option value="urgent" <?= (($_GET['urgency'] ?? '') === 'urgent') ? 'selected' : '' ?>>Urgent</option>
                        <option value="asap" <?= (($_GET['urgency'] ?? '') === 'asap') ? 'selected' : '' ?>>ASAP</option>
                    </select>

                    <select name="sort" onchange="this.form.submit()">
                        <option value="latest">Sort by Latest</option>
                        <option value="highest_fee" <?= (($_GET['sort'] ?? '') === 'highest_fee') ? 'selected' : '' ?>>Highest Fee</option>
                    </select>
            </form>

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
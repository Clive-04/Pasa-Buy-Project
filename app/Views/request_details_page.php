<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="request-content-panel">
                <div class="page-top">
                    <div>
                        <span class="page-badge">Request Information</span>
                        <h1>Request Details</h1>
                        <p>Review the full request information before accepting.</p>
                    </div>

                    <a href="<?= base_url('browse-requests') ?>" class="page-back-btn">Back to Browse</a>
                </div>

                <div class="details-layout">
                    <section class="details-card">
                        <div class="details-section">
                            <h2>Request Summary</h2>
                            <div class="details-grid">
                                <div><span>Request ID</span><strong>#<?= esc($request['id'] ?? '001') ?></strong></div>
                                <div><span>Status</span><strong class="detail-status <?= $request['status'] ?? 'open' ?>"><?= ucfirst(str_replace('_', ' ', $request['status'] ?? 'pending')) ?></strong></div>
                                <div><span>Urgency</span><strong class="detail-status <?= $request['urgency'] ?? 'normal' ?>"><?= ucfirst($request['urgency'] ?? 'normal') ?></strong></div>
                                <div><span>Category</span><strong><?= ucfirst(str_replace('_', ' ', $request['category'] ?? 'other')) ?></strong></div>
                            </div>
                        </div>

                        <div class="details-section">
                            <h2>Item Details</h2>
                            <div class="details-grid">
                                <div><span>Item Name</span><strong><?= esc($request['item_name'] ?? 'Not specified') ?></strong></div>
                                <div><span>Quantity</span><strong><?= $request['quantity'] ?? 1 ?> <?= $request['quantity'] == 1 ? 'item' : 'items' ?></strong></div>
                                <div><span>Preferred Brand</span><strong><?= esc($request['brand'] ?? 'Any') ?></strong></div>
                                <div><span>Estimated Price</span><strong>₱<?= number_format($request['estimated_price'] ?? 0, 2) ?></strong></div>
                            </div>
                            <?php if (!empty($request['item_notes'])): ?>
                                <p class="details-note"><?= esc($request['item_notes']) ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="details-section">
                            <h2>Store and Delivery</h2>
                            <div class="details-grid">
                                <div><span>Preferred Store</span><strong><?= esc($request['store_name'] ?? 'Not specified') ?></strong></div>
                                <div><span>Alternative Store</span><strong><?= esc($request['alt_store'] ?? 'None') ?></strong></div>
                                <div><span>Store Address</span><strong><?= esc($request['store_address'] ?? 'Not specified') ?></strong></div>
                                <div><span>Delivery Address</span><strong><?= esc($request['delivery_address'] ?? 'Not specified') ?></strong></div>
                                <div><span>Landmark</span><strong><?= esc($request['landmark'] ?? 'None') ?></strong></div>
                                <div><span>Contact Number</span><strong><?= esc($request['contact_number'] ?? 'Not provided') ?></strong></div>
                            </div>
                            <?php if (!empty($request['delivery_notes'])): ?>
                                <p class="details-note">Delivery Notes: <?= esc($request['delivery_notes']) ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="details-section">
                            <h2>Payment</h2>
                            <div class="details-grid">
                                <div><span>Payment Method</span><strong><?= ucfirst(str_replace('_', ' ', $request['payment_method'] ?? 'not specified')) ?></strong></div>
                                <div><span>Service Fee</span><strong>₱<?= number_format($request['service_fee'] ?? 0, 2) ?></strong></div>
                                <div><span>Total Estimated</span><strong>₱<?= number_format(($request['estimated_price'] ?? 0) + ($request['service_fee'] ?? 0), 2) ?></strong></div>
                            </div>
                        </div>
                    </section>

                    <aside class="details-side-card">
                        <h2>Requester Profile</h2>
                        <div class="profile-mini">
                            <div class="profile-mini-avatar"><?= strtoupper(substr($requester['first_name'] ?? 'U', 0, 1)) ?></div>
                            <div>
                                <h3><?= esc($requester['first_name'] ?? 'Unknown') ?> <?= esc($requester['last_name'] ?? 'User') ?></h3>
                                <p>Community User</p>
                            </div>
                        </div>

                        <div class="details-side-info">
                            <div class="summary-row">
                                <span>Posted</span>
                                <strong><?= date('M j, Y g:i A', strtotime($request['created_at'] ?? 'now')) ?></strong>
                            </div>
                            <div class="summary-row">
                                <span>Location</span>
                                <strong><?= esc($requester['address'] ?? 'Not specified') ?></strong>
                            </div>
                            <div class="summary-row">
                                <span>Contact</span>
                                <strong><?= esc($request['contact_number'] ?? 'Not provided') ?></strong>
                            </div>
                        </div>

                        <div class="details-side-actions">
                            <a href="#" class="btn-gradient full-btn">Accept Request</a>
                            <a href="#" class="btn-light full-btn">Message Requester</a>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
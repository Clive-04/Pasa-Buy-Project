<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="request-content-panel">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success" style="padding:12px; background:#d1fae5; color:#065f46; border-radius:8px; margin-bottom:16px;">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-error" style="padding:12px; background:#fee2e2; color:#991b1b; border-radius:8px; margin-bottom:16px;">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="page-top">
                    <div>
                        <span class="page-badge">Request Information</span>
                        <h1>Request Details</h1>
                        <p>Review the full request information before accepting or paying.</p>
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
                                <div><span>Quantity</span><strong><?= $request['quantity'] ?? 1 ?> <?= ($request['quantity'] ?? 1) == 1 ? 'item' : 'items' ?></strong></div>
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
                                <div><span>Payment Status</span><strong><?= ucfirst(str_replace('_', ' ', $request['payment_status'] ?? 'unpaid')) ?></strong></div>
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

                        <?php
                            $loggedInUserId = (string) session('user_id');
                            $requestOwnerId = (string) ($request['user_id'] ?? '');
                            $acceptedRunnerId = (string) ($acceptedInfo['runner_id'] ?? '');
                            $isRequester = $loggedInUserId !== '' && $requestOwnerId === $loggedInUserId;
                            $isRunner = $loggedInUserId !== '' && $acceptedRunnerId === $loggedInUserId;
                            $canPayRunner = $isRequester
                                && in_array(($request['status'] ?? ''), ['accepted', 'on_the_way'], true)
                                && ($request['payment_method'] ?? '') !== 'cod'
                                && ($request['payment_status'] ?? 'unpaid') !== 'paid';
                        ?>

                        <?php if ($loggedInUserId !== '' && $requestOwnerId !== $loggedInUserId && ($request['status'] ?? 'pending') === 'pending'): ?>
                            <div class="details-side-actions">
                                <form action="<?= base_url('request/accept/' . $request['id']) ?>" method="post">
                                    <button type="submit" class="btn-gradient full-btn">Accept Request</button>
                                </form>
                            </div>
                        <?php elseif ($isRunner): ?>
                            <div class="details-side-actions">
                                <a href="<?= base_url('accepted-requests') ?>" class="btn-gradient full-btn">Manage in Accepted Requests</a>
                            </div>
                        <?php endif; ?>

                        <?php if ($canPayRunner): ?>
                            <div class="details-side-actions" style="margin-top:14px;">
                                <button type="button" class="btn-gradient full-btn" onclick="openPayRunnerModal()">
                                    Pay Runner from Wallet
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if ($isRequester && ($request['payment_method'] ?? '') === 'cod'): ?>
                            <div class="details-side-actions" style="margin-top:14px;">
                                <div style="padding:12px; background:#fff7ed; border-radius:12px; color:#9a3412;">
                                    COD request: payment will be confirmed by the runner upon delivery.
                                </div>
                            </div>
                        <?php endif; ?>
                    </aside>
                </div>
            </div>
        </section>
    </div>
</main>

<?php if ($canPayRunner): ?>
<div id="payRunnerModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,.55); z-index:9999; align-items:center; justify-content:center; padding:20px;">
    <div style="width:100%; max-width:520px; background:#fff; border-radius:24px; padding:24px; box-shadow:0 25px 60px rgba(15,23,42,.18);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
            <div>
                <h2 style="margin:0;">Confirm Payment</h2>
                <p style="margin:6px 0 0; color:#6b7280;">This will pay the runner from your wallet before delivery.</p>
            </div>
            <button type="button" onclick="closePayRunnerModal()" style="border:none; background:none; font-size:28px; cursor:pointer;">&times;</button>
        </div>

        <div style="margin-bottom:18px;">
            <p><strong>Estimated Item Price:</strong> ₱<?= number_format((float) ($request['estimated_price'] ?? 0), 2) ?></p>
            <p><strong>Service Fee:</strong> ₱<?= number_format((float) ($request['service_fee'] ?? 0), 2) ?></p>
            <p><strong>Total to Pay:</strong> ₱<?= number_format((float) (($request['estimated_price'] ?? 0) + ($request['service_fee'] ?? 0)), 2) ?></p>
        </div>

        <form action="<?= base_url('request/pay-runner/' . $request['id']) ?>" method="post">
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <button type="button" onclick="closePayRunnerModal()" class="dashboard-btn secondary-btn">Cancel</button>
                <button type="submit" class="dashboard-btn primary-btn">Confirm Payment</button>
            </div>
        </form>
    </div>
</div>

<script>
function openPayRunnerModal() {
    document.getElementById('payRunnerModal').style.display = 'flex';
}
function closePayRunnerModal() {
    document.getElementById('payRunnerModal').style.display = 'none';
}
window.addEventListener('click', function (e) {
    const modal = document.getElementById('payRunnerModal');
    if (modal && e.target === modal) {
        closePayRunnerModal();
    }
});
</script>
<?php endif; ?>

<?= $this->include('includes/footer') ?>
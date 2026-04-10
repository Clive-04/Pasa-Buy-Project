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
                        <span class="page-badge">Runner Dashboard</span>
                        <h1>Accepted Requests</h1>
                        <p>Manage accepted requests and delivery progress.</p>
                    </div>

                    <a href="<?= base_url('browse-requests') ?>" class="page-back-btn">Find More Requests</a>
                </div>

                <div class="request-tabs">
                    <a href="<?= base_url('accepted-requests') ?>" class="tab-btn <?= empty($currentStatus) ? 'active' : '' ?>">All</a>
                    <a href="<?= base_url('accepted-requests?status=accepted') ?>" class="tab-btn <?= ($currentStatus === 'accepted') ? 'active' : '' ?>">Accepted</a>
                    <a href="<?= base_url('accepted-requests?status=on_the_way') ?>" class="tab-btn <?= ($currentStatus === 'on_the_way') ? 'active' : '' ?>">On the Way</a>
                    <a href="<?= base_url('accepted-requests?status=delivered') ?>" class="tab-btn <?= ($currentStatus === 'delivered') ? 'active' : '' ?>">Delivered</a>
                </div>

                <div class="my-request-list">
                    <?php if (!empty($acceptedRequests)): ?>
                        <?php foreach ($acceptedRequests as $request): ?>
                            <?php
                                $isCod = ($request['payment_method'] ?? '') === 'cod';
                                $isPaidNonCod = ($request['payment_status'] ?? '') === 'paid';
                            ?>
                            <div class="my-request-card accepted-request-card">
                                <div class="my-request-main">
                                    <h3><?= esc($request['item_name']) ?> (<?= esc($request['quantity']) ?>)</h3>
                                    <p>
                                        Requester: <?= esc(trim(($request['first_name'] ?? '') . ' ' . ($request['last_name'] ?? ''))) ?>
                                        • Store: <?= esc($request['store_name']) ?>
                                    </p>
                                    <p>
                                        Payment: <?= ucfirst(str_replace('_', ' ', $request['payment_method'] ?? 'not set')) ?>
                                        • Status: <?= ucfirst(str_replace('_', ' ', $request['payment_status'] ?? 'unpaid')) ?>
                                    </p>
                                    <p>
                                        Accepted <?= !empty($request['accepted_at']) ? date('M j, Y g:i A', strtotime($request['accepted_at'])) : 'recently' ?>
                                    </p>
                                </div>

                                <div class="my-request-meta accepted-request-meta">
                                    <span class="request-tag <?= esc($request['urgency']) ?>"><?= ucfirst(esc($request['urgency'])) ?></span>
                                    <span class="status-pill <?= esc($request['accepted_status']) ?>"><?= ucfirst(str_replace('_', ' ', esc($request['accepted_status']))) ?></span>

                                    <a href="<?= base_url('request-details/' . $request['request_id']) ?>" class="btn-light">View</a>

                                    <a href="<?= base_url('messages?user_id=' . $request['user_id'] . '&request_id=' . $request['request_id']) ?>" class="btn-light">
                                        Message Requester
                                    </a>

                                    <?php if ($request['accepted_status'] === 'accepted'): ?>
                                        <form action="<?= base_url('request/status/' . $request['request_id']) ?>" method="post" style="display:inline;">
                                            <input type="hidden" name="status" value="on_the_way">
                                            <button type="submit" class="btn-gradient">Mark On the Way</button>
                                        </form>

                                    <?php elseif ($request['accepted_status'] === 'on_the_way'): ?>
                                        <?php if ($isCod): ?>
                                            <button type="button" class="btn-gradient" onclick="openCodModal('<?= $request['request_id'] ?>')">
                                                Mark Delivered
                                            </button>
                                        <?php else: ?>
                                            <?php if ($isPaidNonCod): ?>
                                                <form action="<?= base_url('request/status/' . $request['request_id']) ?>" method="post" style="display:inline;">
                                                    <input type="hidden" name="status" value="delivered">
                                                    <button type="submit" class="btn-gradient">Mark Delivered</button>
                                                </form>
                                            <?php else: ?>
                                                <button type="button" class="btn-light" disabled style="opacity:.6; cursor:not-allowed;">
                                                    Waiting for Requester Payment
                                                </button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="delivered-note">Completed</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-requests">
                            <?php if (empty($currentStatus) || $currentStatus === 'all'): ?>
                                <p>You have not accepted any requests yet.</p>
                                <a href="<?= base_url('browse-requests') ?>" class="btn-primary">Browse Requests</a>
                            <?php else: ?>
                                <p>No <?= ucfirst(str_replace('_', ' ', $currentStatus)) ?> accepted requests found.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
</main>

<div id="codModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,.55); z-index:9999; align-items:center; justify-content:center; padding:20px;">
    <div style="width:100%; max-width:520px; background:#fff; border-radius:24px; padding:24px; box-shadow:0 25px 60px rgba(15,23,42,.18);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
            <div>
                <h2 style="margin:0;">Confirm COD Payment</h2>
                <p style="margin:6px 0 0; color:#6b7280;">Please confirm that the requester already paid in cash on delivery.</p>
            </div>
            <button type="button" onclick="closeCodModal()" style="border:none; background:none; font-size:28px; cursor:pointer;">&times;</button>
        </div>

        <form id="codDeliverForm" method="post">
            <input type="hidden" name="status" value="delivered">
            <input type="hidden" name="cod_confirmed" value="1">

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <button type="button" onclick="closeCodModal()" class="dashboard-btn secondary-btn">Cancel</button>
                <button type="submit" class="dashboard-btn primary-btn">Yes, Payment Received</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCodModal(requestId) {
    const form = document.getElementById('codDeliverForm');
    form.action = "<?= base_url('request/status') ?>/" + requestId;
    document.getElementById('codModal').style.display = 'flex';
}
function closeCodModal() {
    document.getElementById('codModal').style.display = 'none';
}
window.addEventListener('click', function (e) {
    const modal = document.getElementById('codModal');
    if (e.target === modal) {
        closeCodModal();
    }
});
</script>

<?= $this->include('includes/footer') ?>
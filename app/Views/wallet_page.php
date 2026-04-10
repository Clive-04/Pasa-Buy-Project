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
                        <span class="page-badge">Funds</span>
                        <h1>My Wallet</h1>
                        <p>Track your balance and transaction history.</p>
                    </div>

                    <button type="button" class="page-back-btn" onclick="openTopUpModal()">Top Up</button>
                </div>

                <div class="dashboard-stats" style="margin-bottom:24px;">
                    <div class="stat-box" style="max-width: 320px;">
                        <span class="stat-label">Current Balance</span>
                        <h2>₱<?= number_format((float) ($user['wallet_balance'] ?? 0), 2) ?></h2>
                        <p>Your available wallet balance</p>
                    </div>
                </div>

                <div class="dashboard-card">
                    <div class="card-header">
                        <h3>Transaction History</h3>
                    </div>

                    <div class="request-list">
                        <?php if (!empty($transactions)): ?>
                            <?php foreach ($transactions as $transaction): ?>
                                <div class="request-item">
                                    <div>
                                        <h4><?= esc($transaction['description']) ?></h4>
                                        <p>
                                            <?= ucfirst(str_replace('_', ' ', $transaction['type'])) ?>
                                            <?php if (!empty($transaction['source'])): ?>
                                                • <?= ucfirst(str_replace('_', ' ', $transaction['source'])) ?>
                                            <?php endif; ?>
                                            <?php if (!empty($transaction['request_id'])): ?>
                                                • Request #<?= esc($transaction['request_id']) ?>
                                            <?php endif; ?>
                                        </p>
                                        <small><?= date('M j, Y g:i A', strtotime($transaction['created_at'])) ?></small>
                                    </div>

                                    <div style="font-weight:700; color:#111827;">
                                        ₱<?= number_format((float) ($transaction['amount'] ?? 0), 2) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="request-item">
                                <div>
                                    <h4>No transactions yet</h4>
                                    <p>Your wallet activity will appear here.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<div id="topUpModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,.55); z-index:9999; align-items:center; justify-content:center; padding:20px;">
    <div style="width:100%; max-width:520px; background:#fff; border-radius:24px; padding:24px; box-shadow:0 25px 60px rgba(15,23,42,.18);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
            <div>
                <h2 style="margin:0;">Top Up Wallet</h2>
                <p style="margin:6px 0 0; color:#6b7280;">Choose where the top-up will come from.</p>
            </div>
            <button type="button" onclick="closeTopUpModal()" style="border:none; background:none; font-size:28px; cursor:pointer;">&times;</button>
        </div>

        <form action="<?= base_url('wallet/top-up') ?>" method="post">
            <div style="margin-bottom:14px;">
                <label for="amount" style="display:block; margin-bottom:8px; font-weight:600;">Amount</label>
                <input
                    type="number"
                    step="0.01"
                    min="1"
                    name="amount"
                    id="amount"
                    placeholder="Enter amount"
                    required
                    style="width:100%; padding:12px 14px; border:1px solid #d1d5db; border-radius:12px;"
                >
            </div>

            <div style="margin-bottom:14px;">
                <label for="source" style="display:block; margin-bottom:8px; font-weight:600;">Top-Up Method</label>
                <select
                    name="source"
                    id="source"
                    required
                    style="width:100%; padding:12px 14px; border:1px solid #d1d5db; border-radius:12px;"
                >
                    <option value="">Select top-up method</option>
                    <option value="gcash">GCash</option>
                    <option value="maya">Maya</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>

            <div style="margin-bottom:20px;">
                <label for="reference_no" style="display:block; margin-bottom:8px; font-weight:600;">Reference Number (Optional)</label>
                <input
                    type="text"
                    name="reference_no"
                    id="reference_no"
                    placeholder="Enter reference number"
                    style="width:100%; padding:12px 14px; border:1px solid #d1d5db; border-radius:12px;"
                >
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <button type="button" onclick="closeTopUpModal()" class="dashboard-btn secondary-btn">Cancel</button>
                <button type="submit" class="dashboard-btn primary-btn">Confirm Top Up</button>
            </div>
        </form>
    </div>
</div>

<script>
function openTopUpModal() {
    document.getElementById('topUpModal').style.display = 'flex';
}
function closeTopUpModal() {
    document.getElementById('topUpModal').style.display = 'none';
}
window.addEventListener('click', function (e) {
    const modal = document.getElementById('topUpModal');
    if (e.target === modal) {
        closeTopUpModal();
    }
});
</script>

<?= $this->include('includes/footer') ?>
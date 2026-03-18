<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="request-page">
    <div class="request-container">
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
                        <div><span>Request ID</span><strong>#<?= esc($requestId ?? '001') ?></strong></div>
                        <div><span>Status</span><strong>Open</strong></div>
                        <div><span>Urgency</span><strong>Urgent</strong></div>
                        <div><span>Category</span><strong>Medicine</strong></div>
                    </div>
                </div>

                <div class="details-section">
                    <h2>Item Details</h2>
                    <div class="details-grid">
                        <div><span>Item Name</span><strong>Paracetamol 500mg</strong></div>
                        <div><span>Quantity</span><strong>2 boxes</strong></div>
                        <div><span>Preferred Brand</span><strong>Biogesic</strong></div>
                        <div><span>Estimated Price</span><strong>₱120.00</strong></div>
                    </div>
                    <p class="details-note">Please check expiration date and make sure the item is sealed properly.</p>
                </div>

                <div class="details-section">
                    <h2>Store and Delivery</h2>
                    <div class="details-grid">
                        <div><span>Preferred Store</span><strong>Mercury Drug</strong></div>
                        <div><span>Alternative Store</span><strong>Watsons</strong></div>
                        <div><span>Delivery Address</span><strong>Barangay San Isidro, Lucban</strong></div>
                        <div><span>Landmark</span><strong>Near Barangay Hall</strong></div>
                    </div>
                </div>

                <div class="details-section">
                    <h2>Payment</h2>
                    <div class="details-grid">
                        <div><span>Payment Method</span><strong>GCash</strong></div>
                        <div><span>Service Fee</span><strong>₱35.00</strong></div>
                    </div>
                </div>
            </section>

            <aside class="details-side-card">
                <h2>Requester Profile</h2>
                <div class="profile-mini">
                    <div class="profile-mini-avatar">C</div>
                    <div>
                        <h3>Clive Benito</h3>
                        <p>Verified Community User</p>
                    </div>
                </div>

                <div class="details-side-info">
                    <div class="summary-row">
                        <span>Posted</span>
                        <strong>5 mins ago</strong>
                    </div>
                    <div class="summary-row">
                        <span>Distance</span>
                        <strong>0.8 km</strong>
                    </div>
                    <div class="summary-row">
                        <span>Contact</span>
                        <strong>0912 345 6789</strong>
                    </div>
                </div>

                <div class="details-side-actions">
                    <a href="#" class="btn-gradient full-btn">Accept Request</a>
                    <a href="#" class="btn-light full-btn">Message Requester</a>
                </div>
            </aside>
        </div>
    </div>
</main>

<?= $this->include('includes/footer') ?>
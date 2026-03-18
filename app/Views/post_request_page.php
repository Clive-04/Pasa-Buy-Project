<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="post-request-page">
    <div class="post-request-container">
        <div class="post-request-header">
            <div>
                <span class="page-badge">Create Request</span>
                <h1>Post a Request</h1>
                <p>Fill in the item, store, delivery, and payment details for your request.</p>
            </div>

            <a href="<?= base_url('dashboard') ?>" class="page-back-btn">Back to Dashboard</a>
        </div>

        <div class="post-request-grid">
            <section class="post-request-form-card">
                <form action="#" method="POST" class="post-request-form">
                    <div class="form-section">
                        <h2>Item Details</h2>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="item_name">Item Name</label>
                                <input type="text" id="item_name" name="item_name" placeholder="Enter item name">
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select id="category" name="category">
                                    <option value="">Select category</option>
                                    <option value="food">Food</option>
                                    <option value="medicine">Medicine</option>
                                    <option value="school_supplies">School Supplies</option>
                                    <option value="household">Household</option>
                                    <option value="personal_care">Personal Care</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" id="quantity" name="quantity" min="1" placeholder="Enter quantity">
                            </div>

                            <div class="form-group">
                                <label for="brand">Preferred Brand</label>
                                <input type="text" id="brand" name="brand" placeholder="Optional brand">
                            </div>

                            <div class="form-group full-width">
                                <label for="item_notes">Item Notes</label>
                                <textarea id="item_notes" name="item_notes" rows="4" placeholder="Add flavor, size, color, or other notes"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Store Details</h2>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="store_name">Preferred Store</label>
                                <input type="text" id="store_name" name="store_name" placeholder="Enter store name">
                            </div>

                            <div class="form-group">
                                <label for="alt_store">Alternative Store</label>
                                <input type="text" id="alt_store" name="alt_store" placeholder="Optional alternative store">
                            </div>

                            <div class="form-group full-width">
                                <label for="store_address">Store Address</label>
                                <input type="text" id="store_address" name="store_address" placeholder="Enter store address or landmark">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Delivery Details</h2>

                        <div class="form-grid">
                            <div class="form-group full-width">
                                <label for="delivery_address">Delivery Address / Barangay</label>
                                <input type="text" id="delivery_address" name="delivery_address" placeholder="Enter delivery address">
                            </div>

                            <div class="form-group">
                                <label for="contact_number">Contact Number</label>
                                <input type="text" id="contact_number" name="contact_number" placeholder="Enter contact number">
                            </div>

                            <div class="form-group">
                                <label for="landmark">Landmark</label>
                                <input type="text" id="landmark" name="landmark" placeholder="Optional landmark">
                            </div>

                            <div class="form-group full-width">
                                <label for="delivery_notes">Delivery Notes</label>
                                <textarea id="delivery_notes" name="delivery_notes" rows="3" placeholder="Instructions for the runner"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Payment and Urgency</h2>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="estimated_price">Estimated Item Price</label>
                                <input type="number" id="estimated_price" name="estimated_price" step="0.01" min="0" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="service_fee">Service Fee Offer</label>
                                <input type="number" id="service_fee" name="service_fee" step="0.01" min="0" placeholder="0.00">
                            </div>

                            <div class="form-group">
                                <label for="payment_method">Payment Method</label>
                                <select id="payment_method" name="payment_method">
                                    <option value="">Select payment method</option>
                                    <option value="cod">Cash on Delivery</option>
                                    <option value="gcash">GCash</option>
                                    <option value="maya">Maya</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="urgency">Urgency</label>
                                <select id="urgency" name="urgency">
                                    <option value="">Select urgency</option>
                                    <option value="normal">Normal</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="asap">ASAP</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="form-btn secondary-btn">Save Draft</button>
                        <button type="submit" class="form-btn primary-btn">Post Request</button>
                    </div>
                </form>
            </section>

            <aside class="request-summary-card">
                <h2>Request Summary</h2>

                <div class="summary-box">
                    <div class="summary-row">
                        <span>Item</span>
                        <strong>Not set</strong>
                    </div>
                    <div class="summary-row">
                        <span>Quantity</span>
                        <strong>0</strong>
                    </div>
                    <div class="summary-row">
                        <span>Store</span>
                        <strong>Not set</strong>
                    </div>
                    <div class="summary-row">
                        <span>Estimated Price</span>
                        <strong>₱0.00</strong>
                    </div>
                    <div class="summary-row">
                        <span>Service Fee</span>
                        <strong>₱0.00</strong>
                    </div>
                    <div class="summary-row">
                        <span>Urgency</span>
                        <strong>Not set</strong>
                    </div>
                    <div class="summary-row">
                        <span>Payment</span>
                        <strong>Not set</strong>
                    </div>
                </div>

                <div class="summary-note">
                    <h3>Reminder</h3>
                    <p>Be specific with your item details and location so nearby runners can accept your request faster.</p>
                </div>
            </aside>
        </div>
    </div>
</main>

<?= $this->include('includes/footer') ?>
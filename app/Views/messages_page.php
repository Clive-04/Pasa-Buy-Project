<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="messages-page-panel">
                <div class="page-top">
                    <div>
                        <span class="page-badge">Communication</span>
                        <h1>Messages</h1>
                        <p>Coordinate with requesters and runners through direct chat.</p>
                    </div>

                    <a href="<?= base_url('dashboard') ?>" class="page-back-btn">Back to Dashboard</a>
                </div>

                <div class="messages-layout">
                    <aside class="conversations-panel">
                        <div class="conversations-header">
                            <h2>Chats</h2>
                        </div>

                        <div class="conversation-search">
                            <input type="text" placeholder="Search conversation">
                        </div>

                        <div class="conversation-list">
                            <div class="conversation-item active">
                                <div class="conversation-avatar">B</div>
                                <div class="conversation-info">
                                    <div class="conversation-top">
                                        <h3>Bea R.</h3>
                                        <span>4m ago</span>
                                    </div>
                                    <p>Hey! At the store now. Did you still need blue folder?</p>
                                </div>
                            </div>

                            <div class="conversation-item">
                                <div class="conversation-avatar">M</div>
                                <div class="conversation-info">
                                    <div class="conversation-top">
                                        <h3>Marjhelly P.</h3>
                                        <span>5m ago</span>
                                    </div>
                                    <p>Okay, I’ll buy it and send you the receipt later.</p>
                                </div>
                            </div>

                            <div class="conversation-item">
                                <div class="conversation-avatar">J</div>
                                <div class="conversation-info">
                                    <div class="conversation-top">
                                        <h3>John D.</h3>
                                        <span>12m ago</span>
                                    </div>
                                    <p>I’m on the way now.</p>
                                </div>
                            </div>
                        </div>
                    </aside>

                    <section class="chat-panel">
                        <div class="chat-header">
                            <div class="chat-user">
                                <div class="conversation-avatar">B</div>
                                <div>
                                    <h2>Bea R.</h2>
                                    <p>Active now</p>
                                </div>
                            </div>
                        </div>

                        <div class="chat-body">
                            <div class="chat-date">Today 6:00 PM</div>

                            <div class="message-row received">
                                <div class="message-bubble">
                                    <p>Hey! At the store now. Did you still need blue folder?</p>
                                    <span class="message-time">6:01 PM</span>
                                </div>
                            </div>

                            <div class="message-row sent">
                                <div class="message-bubble">
                                    <p>Yes, thanks!</p>
                                    <span class="message-time">6:02 PM</span>
                                </div>
                            </div>

                            <div class="message-row received">
                                <div class="message-bubble">
                                    <p>Okay, I’ll check the available brands first.</p>
                                    <span class="message-time">6:03 PM</span>
                                </div>
                            </div>

                            <div class="message-row sent">
                                <div class="message-bubble">
                                    <p>Please send a photo before buying.</p>
                                    <span class="message-time">6:04 PM</span>
                                </div>
                            </div>
                        </div>

                        <div class="chat-input-bar">
                            <button type="button" class="attach-btn" title="Attach file">📎</button>
                            <input type="text" placeholder="Type message...">
                            <button type="button" class="send-btn">Send</button>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
</main>

<?= $this->include('includes/footer') ?>
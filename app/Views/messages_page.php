<?= $this->include('includes/header') ?>
<?= $this->include('includes/navbar') ?>

<main class="dashboard-page">
    <div class="dashboard-container">
        <?= $this->include('includes/sidebar2') ?>

        <section class="dashboard-main">
            <div class="messages-page-panel">
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

                        <form method="get" action="<?= base_url('messages') ?>" class="conversation-search">
                            <?php if (!empty($selectedUserId)): ?>
                                <input type="hidden" name="user_id" value="<?= esc($selectedUserId) ?>">
                            <?php endif; ?>
                            <?php if (!empty($requestId)): ?>
                                <input type="hidden" name="request_id" value="<?= esc($requestId) ?>">
                            <?php endif; ?>

                            <input
                                type="text"
                                name="search"
                                placeholder="Search conversation"
                                value="<?= esc($search ?? '') ?>"
                            >
                        </form>

                        <div class="conversation-list">
                            <?php if (!empty($conversations)): ?>
                                <?php foreach ($conversations as $conversation): ?>
                                    <?php
                                        $isActive = ((string) $selectedUserId === (string) $conversation['user_id']);
                                        $avatarLetter = strtoupper(substr($conversation['first_name'] ?? 'U', 0, 1));
                                        $previewText = !empty($conversation['message'])
                                            ? $conversation['message']
                                            : (!empty($conversation['attachment_name']) ? '[Attachment] ' . $conversation['attachment_name'] : 'No messages yet.');

                                        $hasUnread = ((int) ($conversation['unread_count'] ?? 0)) > 0;
                                    ?>

                                    <a href="<?= base_url('messages?user_id=' . $conversation['user_id'] . (!empty($conversation['request_id']) ? '&request_id=' . $conversation['request_id'] : '')) ?>"
                                       class="conversation-item <?= $isActive ? 'active' : '' ?> <?= $hasUnread ? 'has-unread' : '' ?>"
                                       style="text-decoration:none;">
                                        <div class="conversation-avatar"><?= esc($avatarLetter) ?></div>

                                        <div class="conversation-info">
                                            <div class="conversation-top">
                                                <h3 class="<?= $hasUnread ? 'unread-name' : '' ?>">
                                                    <?= esc(trim(($conversation['first_name'] ?? '') . ' ' . ($conversation['last_name'] ?? ''))) ?>
                                                </h3>
                                                <span><?= !empty($conversation['created_at']) ? date('g:i A', strtotime($conversation['created_at'])) : '' ?></span>
                                            </div>

                                            <p class="<?= $hasUnread ? 'unread-text' : '' ?>">
                                                <?= esc($previewText) ?>
                                            </p>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="conversation-item">
                                    <div class="conversation-info">
                                        <p>No conversations found.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </aside>

                    <section class="chat-panel">
                        <?php if (!empty($selectedUser)): ?>
                            <div class="chat-header">
                                <div class="chat-user">
                                    <div class="conversation-avatar">
                                        <?= strtoupper(substr($selectedUser['first_name'] ?? 'U', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <h2><?= esc(trim(($selectedUser['first_name'] ?? '') . ' ' . ($selectedUser['last_name'] ?? ''))) ?></h2>
                                        <?php if (!empty($requestId)): ?>
                                            <p>Regarding Request #<?= esc($requestId) ?></p>
                                        <?php else: ?>
                                            <p>Conversation</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="chat-body" id="chatBody">
                                <?php if (!empty($messages)): ?>
                                    <?php
                                        $currentDate = '';
                                        $loggedInUserId = session('user_id');
                                    ?>

                                    <?php foreach ($messages as $msg): ?>
                                        <?php
                                            $msgDate = date('F j, Y', strtotime($msg['created_at']));
                                            $isSent = ((string) $msg['sender_id'] === (string) $loggedInUserId);
                                        ?>

                                        <?php if ($msgDate !== $currentDate): ?>
                                            <?php $currentDate = $msgDate; ?>
                                            <div class="chat-date"><?= esc($currentDate) ?></div>
                                        <?php endif; ?>

                                        <div class="message-row <?= $isSent ? 'sent' : 'received' ?>">
                                            <div class="message-bubble">
                                                <?php if (!empty($msg['message'])): ?>
                                                    <p><?= esc($msg['message']) ?></p>
                                                <?php endif; ?>

                                                <?php if (!empty($msg['attachment_path'])): ?>
                                                    <div style="margin-top:8px;">
                                                        <a href="<?= base_url($msg['attachment_path']) ?>" target="_blank" class="btn-light">
                                                            Open Attachment: <?= esc($msg['attachment_name']) ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>

                                                <span class="message-time"><?= date('g:i A', strtotime($msg['created_at'])) ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="chat-date">No messages yet</div>
                                <?php endif; ?>
                            </div>

                            <form action="<?= base_url('messages/send') ?>" method="post" enctype="multipart/form-data" class="chat-input-bar">
                                <input type="hidden" name="receiver_id" value="<?= esc($selectedUserId) ?>">
                                <input type="hidden" name="request_id" value="<?= esc($requestId ?? '') ?>">

                                <label for="attachment" class="attach-btn" title="Attach file" style="cursor:pointer;">📎</label>
                                <input type="file" name="attachment" id="attachment" style="display:none;">

                                <input type="text" name="message" placeholder="Type message...">
                                <button type="submit" class="send-btn">Send</button>
                            </form>
                        <?php else: ?>
                            <div class="chat-header">
                                <div class="chat-user">
                                    <div>
                                        <h2>Select a conversation</h2>
                                        <p>Choose a requester or runner from the left panel.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="chat-body" id="chatBody">
                                <div class="chat-date">No conversation selected</div>
                            </div>
                        <?php endif; ?>
                    </section>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
function scrollChatToLatest() {
    const chat = document.getElementById('chatBody');
    const lastMessage = chat ? chat.querySelector('.message-row:last-child') : null;

    if (chat && lastMessage) {
        lastMessage.scrollIntoView({
            block: 'end',
            behavior: 'auto'
        });
    } else if (chat) {
        chat.scrollTop = chat.scrollHeight;
    }
}

window.addEventListener('load', function () {
    scrollChatToLatest();
    setTimeout(scrollChatToLatest, 100);
    setTimeout(scrollChatToLatest, 300);
    setTimeout(scrollChatToLatest, 600);
});
</script>

<?= $this->include('includes/footer') ?>
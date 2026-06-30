<?php
// Extracted data: $post
$isLiked = false; // Will be dynamic later
?>
<div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition mb-6">
    <!-- Header: Author info -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">
                <?= substr($post['author_name'] ?? 'U', 0, 1) ?>
            </div>
            <div>
                <h4 class="font-bold text-gray-800"><?= e($post['author_name']) ?></h4>
                <p class="text-xs text-gray-500"><?= date('M j, Y g:i A', strtotime($post['created_at'])) ?></p>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="mb-4">
        <?php if (!empty($post['cover_image'])): ?>
            <div class="w-full h-64 bg-gray-100 mb-4 rounded-lg overflow-hidden">
                <img src="<?= e($post['cover_image']) ?>" class="w-full h-full object-cover">
            </div>
        <?php endif; ?>
        <h3 class="text-xl font-bold text-gray-900 mb-2"><?= e($post['title']) ?></h3>
        <div class="text-gray-700 prose prose-sm max-w-none">
            <?= $post['content'] ?>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="flex items-center justify-between pt-4 border-t border-gray-100 text-gray-500">
        <button class="flex items-center gap-2 hover:text-blue-600 transition like-btn" data-post-id="<?= $post['id'] ?>">
            <svg class="w-5 h-5 <?= $isLiked ? 'text-blue-600 fill-current' : 'fill-none' ?>" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
            </svg>
            <span class="like-count"><?= $post['like_count'] ?? 0 ?></span>
        </button>
        <button class="flex items-center gap-2 hover:text-blue-600 transition" onclick="toggleComments(<?= $post['id'] ?>)">
            <svg class="w-5 h-5 fill-none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <span><?= $post['comment_count'] ?? 0 ?></span>
        </button>
    </div>

    <!-- Comments Section (Hidden by default) -->
    <div id="comments-<?= $post['id'] ?>" class="hidden mt-4 pt-4 border-t border-gray-100">
        <div class="comments-list mb-4 space-y-3">
            <div class="text-center text-sm text-gray-400">Loading comments...</div>
        </div>
        
        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="flex gap-2">
            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center font-bold text-xs shrink-0">
                <?= substr($_SESSION['user_name'] ?? 'U', 0, 1) ?>
            </div>
            <input type="text" class="comment-input flex-grow bg-gray-100 rounded-full px-4 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Write a comment..." data-post-id="<?= $post['id'] ?>" onkeypress="submitComment(event, this)">
        </div>
        <?php endif; ?>
    </div>
</div>

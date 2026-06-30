<?php
// Extracted data: $comment, $replies (optional)
$replies = $replies ?? [];
?>
<div class="flex gap-4">
    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-500 shrink-0">
        <?= substr($comment['user_name'] ?? 'U', 0, 1) ?>
    </div>
    <div class="flex-grow">
        <div class="flex items-center justify-between mb-1">
            <div class="font-bold text-gray-900 text-sm"><?= e($comment['user_name']) ?></div>
            <div class="text-xs text-gray-400"><?= date('M j, Y', strtotime($comment['created_at'])) ?></div>
        </div>
        <div class="text-gray-700 text-sm leading-relaxed mb-2"><?= e($comment['content']) ?></div>
        
        <div class="flex items-center gap-4 text-xs font-semibold text-gray-500 mb-4">
            <button class="hover:text-indigo-600 transition flex items-center gap-1" onclick="toggleCommentLike(<?= $comment['id'] ?>, this)">
                <svg class="w-3.5 h-3.5 <?= !empty($comment['user_has_liked']) ? 'text-indigo-600 fill-current' : 'fill-none' ?>" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg> 
                <span class="like-count <?= !empty($comment['user_has_liked']) ? 'text-indigo-600' : '' ?>"><?= $comment['like_count'] ?? 0 ?></span> Like
            </button>
            <button class="hover:text-indigo-600 transition flex items-center gap-1" onclick="toggleReplyBox(<?= $comment['id'] ?>)">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg> Reply
            </button>
        </div>

        <!-- Reply Input Box (Hidden) -->
        <div id="reply-box-<?= $comment['id'] ?>" class="hidden mt-3 mb-6 bg-gray-50 rounded-lg p-3 border border-gray-100">
            <div class="flex gap-3">
                <div class="flex-grow">
                    <textarea class="w-full bg-transparent border-b border-gray-200 pb-2 focus:border-indigo-600 focus:outline-none resize-none transition text-gray-700 text-sm placeholder-gray-400" rows="1" placeholder="Write a reply..." data-post-id="<?= $comment['post_id'] ?>" data-parent-id="<?= $comment['id'] ?>" onkeypress="submitReply(event, this)"></textarea>
                    <div class="flex justify-end mt-2 gap-2">
                        <button class="text-xs font-semibold text-gray-500 hover:text-gray-700 py-1.5 px-3" onclick="toggleReplyBox(<?= $comment['id'] ?>)">Cancel</button>
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold py-1.5 px-4 rounded-full transition" onclick="submitReply({key:'Enter'}, this.parentElement.previousElementSibling)">Reply</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Render Nested Replies -->
        <?php if (!empty($replies)): ?>
            <div class="ml-4 pl-4 border-l-2 border-gray-100 space-y-4 mt-4">
                <?php foreach ($replies as $reply): ?>
                    <div class="flex gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-500 shrink-0 text-xs">
                            <?= substr($reply['user_name'] ?? 'U', 0, 1) ?>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center gap-2 mb-0.5">
                                <div class="font-bold text-gray-900 text-[13px]"><?= e($reply['user_name']) ?></div>
                                <div class="text-[11px] text-gray-400"><?= date('M j, Y', strtotime($reply['created_at'])) ?></div>
                            </div>
                            <div class="text-gray-700 text-[13px] leading-relaxed"><?= e($reply['content']) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

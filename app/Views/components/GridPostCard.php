<?php
// Extracted data: $post
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition flex flex-col h-full cursor-pointer" onclick="if(!event.target.closest('button') && !event.target.closest('.comment-area')) window.location.href='/post/<?= e($post['slug']) ?>'">
    <!-- Cover Image -->
    <div class="w-full h-40 bg-indigo-50 relative overflow-hidden">
        <?php if (!empty($post['cover_image'])): ?>
            <img src="<?= e($post['cover_image']) ?>" class="w-full h-full object-cover transition duration-500" alt="Cover">
        <?php else: ?>
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold opacity-80 transition duration-500">
                BlogSite
            </div>
        <?php endif; ?>
    </div>

    <div class="p-5 flex flex-col flex-grow">
        <!-- Title -->
        <h3 class="text-[17px] font-bold text-gray-900 leading-snug mb-3 transition">
            <?= e($post['title']) ?>
        </h3>
        
        <!-- Excerpt -->
        <p class="text-sm text-gray-600 line-clamp-3 mb-6 flex-grow">
            <?= strip_tags($post['content']) ?>
        </p>

        <!-- Author Info & Actions -->
        <div class="flex flex-col gap-4 mt-auto pt-4 border-t border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-orange-600 text-white flex items-center justify-center font-bold text-sm shadow-sm shrink-0">
                    <?= substr($post['author_name'] ?? 'U', 0, 1) ?>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-gray-900 text-sm"><?= e($post['author_name']) ?></span>
                    <span class="text-gray-500 text-xs"><?= date('M j, Y', strtotime($post['created_at'])) ?></span>
                </div>
            </div>
            
            <div class="flex items-center justify-between text-gray-500 text-sm">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 fill-none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                        </svg>
                        <span class="font-medium"><?= $post['like_count'] ?? 0 ?></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 fill-none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span class="font-medium"><?= $post['comment_count'] ?? 0 ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

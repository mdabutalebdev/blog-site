<?php
// Extracted data: $post
?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col cursor-pointer" onclick="window.location.href='/post/<?= e($post['slug']) ?>'">
    <div class="h-48 bg-gray-100 flex items-center justify-center overflow-hidden">
        <?php if ($post['cover_image']): ?>
            <img src="<?= e($post['cover_image']) ?>" class="w-full h-full object-cover" alt="Cover">
        <?php else: ?>
            <div class="text-gray-400 font-medium">No Image</div>
        <?php endif; ?>
    </div>
    <div class="p-6 flex flex-col flex-grow">
        <span class="text-xs font-bold text-blue-600 mb-2 uppercase tracking-wider"><?= e($post['category'] ?? 'General') ?></span>
        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2"><?= e($post['title']) ?></h3>
        <p class="text-gray-600 text-sm line-clamp-3 mb-6 flex-grow">
            <?= strip_tags($post['content']) ?>
        </p>
        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600 text-xs">
                    <?= substr($post['author_name'] ?? 'U', 0, 1) ?>
                </div>
                <span class="text-sm font-medium text-gray-800"><?= e($post['author_name']) ?></span>
            </div>
            <span class="text-xs text-gray-500"><?= date('M j', strtotime($post['created_at'])) ?></span>
        </div>
    </div>
</div>

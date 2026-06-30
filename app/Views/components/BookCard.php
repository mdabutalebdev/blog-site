<?php
// Extracted data: $book
?>
<a href="/books/view?id=<?= $book['id'] ?>" target="_blank" class="block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition flex flex-col h-full">
    <!-- Cover Area -->
    <div class="h-56 bg-indigo-50/50 flex items-center justify-center relative overflow-hidden border-b border-gray-50">
        <?php if (!empty($book['cover_image'])): ?>
            <img src="<?= e($book['cover_image']) ?>" class="w-full h-full object-cover" alt="<?= e($book['title']) ?> Cover">
        <?php else: ?>
            <svg class="w-12 h-12 text-indigo-200" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
            </svg>
        <?php endif; ?>
    </div>
    
    <!-- Details Area -->
    <div class="p-5 flex flex-col flex-grow">
        <h3 class="font-bold text-gray-900 text-[15px] mb-2 line-clamp-2 leading-snug">
            <?= e($book['title']) ?>
        </h3>
        <div class="mt-auto pt-3 flex items-center justify-between text-xs text-gray-500 font-medium">
            <span class="flex items-center gap-1.5 bg-gray-100 px-2 py-1 rounded-md">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg> 
                <?= $book['total_pages'] ?> Pages
            </span>
            <span class="text-blue-600 bg-blue-50 px-2 py-1 rounded-md">PDF</span>
        </div>
    </div>
</a>

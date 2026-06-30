<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Search Bar & Filters (Matches Image 1) -->
    <div class="mb-10 max-w-full mx-auto">
        <!-- Search Input -->
        <form action="/" method="GET" class="relative mb-6">
            <?php if (!empty($currentCategory)): ?>
                <input type="hidden" name="category" value="<?= e($currentCategory) ?>">
            <?php endif; ?>
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" name="q" value="<?= e($currentSearch ?? '') ?>" class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm transition" placeholder="Search by keyword, tags, or author...">
        </form>

        <!-- Dynamic Category Pills -->
        <div class="flex flex-wrap items-center gap-2.5">
            <?php $isAllActive = empty($currentCategory); ?>
            <a href="/" class="inline-flex items-center gap-1.5 px-4 py-1.5 <?= $isAllActive ? 'bg-gray-900 text-white shadow-sm hover:opacity-90' : 'bg-white text-gray-700 border border-gray-200 hover:border-blue-400 hover:text-blue-600 shadow-sm' ?> rounded-lg text-sm font-semibold transition">
                All <span class="<?= $isAllActive ? 'bg-white text-gray-900' : 'bg-gray-100 text-gray-600' ?> px-1.5 py-0.5 rounded text-[11px] leading-none"><?= $totalPosts ?></span>
            </a>
            <?php foreach ($categories as $cat): ?>
                <?php $isActive = (!empty($currentCategory) && strtolower($currentCategory) === strtolower($cat['category'])); ?>
                <a href="/category/<?= e(slugify($cat['category'])) ?>" class="inline-flex items-center gap-1.5 px-4 py-1.5 <?= $isActive ? 'bg-gray-900 text-white shadow-sm hover:opacity-90' : 'bg-white text-gray-700 border border-gray-200 hover:border-blue-400 hover:text-blue-600 shadow-sm' ?> rounded-lg text-sm font-medium transition">
                    <?= e(ucfirst($cat['category'])) ?> <span class="<?= $isActive ? 'bg-white text-gray-900' : 'bg-gray-100 text-gray-600' ?> px-1.5 py-0.5 rounded text-[11px] leading-none"><?= $cat['count'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Top Header matches the educative image exactly -->
    <div class="flex justify-between items-end border-b border-gray-200 pb-4 mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">blogsite</h1>
        
    </div>

    <?php if (empty($posts)): ?>
        <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-lg">No posts published yet.</p>
        </div>
    <?php else: ?>
        <!-- Grid Section for All Posts -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($posts as $post): ?>
                <?= component('GridPostCard', ['post' => $post]) ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
/* Custom scrollbar for trending section */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

<div class="mb-10 text-center">
    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-4">Our Blog</h1>
    <p class="text-lg text-gray-500 max-w-2xl mx-auto">Discover stories, thinking, and expertise from writers on any topic.</p>
</div>

<!-- Category Pills -->
<div class="flex flex-wrap justify-center gap-3 mb-10">
    <a href="#" class="px-5 py-2 bg-blue-600 text-white rounded-full text-sm font-medium shadow-sm hover:shadow transition">All</a>
    <a href="#" class="px-5 py-2 bg-white text-gray-600 rounded-full text-sm font-medium border border-gray-200 hover:border-blue-300 hover:text-blue-600 transition">Technology</a>
    <a href="#" class="px-5 py-2 bg-white text-gray-600 rounded-full text-sm font-medium border border-gray-200 hover:border-blue-300 hover:text-blue-600 transition">Programming</a>
    <a href="#" class="px-5 py-2 bg-white text-gray-600 rounded-full text-sm font-medium border border-gray-200 hover:border-blue-300 hover:text-blue-600 transition">Design</a>
</div>

<?php if (empty($posts)): ?>
    <div class="text-center py-20 bg-white rounded-2xl shadow-sm">
        <p class="text-gray-500 text-lg">No posts published yet.</p>
    </div>
<?php else: ?>
    <!-- Hero Post (First Post) -->
    <?php $hero = $posts[0]; ?>
    <div class="mb-12 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition flex flex-col md:flex-row group cursor-pointer" onclick="window.location.href='/post/<?= e($hero['slug']) ?>'">
        <div class="md:w-1/2 bg-gray-100 h-64 md:h-auto flex items-center justify-center overflow-hidden">
            <?php if ($hero['cover_image']): ?>
                <img src="<?= e($hero['cover_image']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="Cover">
            <?php else: ?>
                <div class="text-gray-400 font-medium">No Image</div>
            <?php endif; ?>
        </div>
        <div class="md:w-1/2 p-8 flex flex-col justify-center">
            <span class="text-sm font-bold text-blue-600 mb-2 uppercase tracking-wider"><?= e($hero['category'] ?? 'General') ?></span>
            <h2 class="text-3xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition"><?= e($hero['title']) ?></h2>
            <div class="text-gray-600 mb-6 line-clamp-3 text-lg leading-relaxed">
                <?= strip_tags($hero['content']) ?>
            </div>
            <div class="flex items-center gap-3 mt-auto">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-600">
                    <?= substr($hero['author_name'] ?? 'U', 0, 1) ?>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800"><?= e($hero['author_name']) ?></h4>
                    <p class="text-sm text-gray-500"><?= date('M j, Y', strtotime($hero['created_at'])) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Posts -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php for ($i = 1; $i < count($posts); $i++): ?>
            <?= component('PostCard', ['post' => $posts[$i]]) ?>
        <?php endfor; ?>
    </div>
<?php endif; ?>

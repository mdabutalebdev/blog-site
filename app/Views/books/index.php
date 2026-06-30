<div class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">E-Library</h1>
        <p class="text-gray-500 mt-2">Browse and download educational resources.</p>
    </div>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/books/upload" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-bold transition shadow hover:shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Upload Book
        </a>
    <?php else: ?>
        <a href="/login" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-full font-bold transition">Log in to Upload</a>
    <?php endif; ?>
</div>

<?php if (empty($books)): ?>
    <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        <p class="text-gray-500 text-lg">No books available yet.</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($books as $book): ?>
            <?= component('BookCard', ['book' => $book]) ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

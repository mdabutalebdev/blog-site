<?php
// Extracted data: $post
?>
<div class="bg-white min-h-screen pt-6 pb-12">
    <!-- Main 3-Column Layout -->
    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8 flex justify-center items-stretch">
        
        <!-- 1. Left Sidebar (Table of Contents) - Sticky -->
        <div class="hidden lg:block w-[280px] shrink-0 border-r border-gray-200 pr-8 mr-8">
            <div class="sticky top-24 max-h-[calc(100vh-7rem)] overflow-y-auto custom-scrollbar pr-2 pt-2">
                <h3 class="font-bold text-gray-900 text-lg mb-4">Table of Contents</h3>
                <ul class="space-y-4 text-[14px] font-medium text-gray-600">
                    <?php if (empty($toc)): ?>
                        <li class="text-gray-400 italic">No table of contents</li>
                    <?php else: ?>
                        <?php foreach ($toc as $item): ?>
                            <?php if ($item['tag'] === 'h2'): ?>
                                <li>
                                    <a href="#<?= e($item['id']) ?>" class="toc-link hover:text-indigo-600 transition block border-l-2 border-transparent pl-3">
                                        <?= e($item['text']) ?>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="pl-4 mt-2 ml-1">
                                    <a href="#<?= e($item['id']) ?>" class="toc-link hover:text-indigo-600 transition block font-normal text-[13px] border-l-2 border-transparent pl-3">
                                        <?= e($item['text']) ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- 2. Center Content - Scrollable -->
        <div class="flex-1 min-w-0 max-w-[850px] py-2">
            
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-[13px] text-gray-500 mb-6">
                <a href="/" class="text-indigo-600 hover:text-indigo-800">Home</a>
                <span>/</span>
                <a href="/blog" class="text-indigo-600 hover:text-indigo-800">Blog</a>
                <span>/</span>
                <a href="/category/<?= e(slugify($post['category'])) ?>" class="text-indigo-600 hover:text-indigo-800"><?= e($post['category']) ?></a>
                <span>/</span>
                <span class="text-gray-900 truncate max-w-xs"><?= e($post['title']) ?></span>
            </div>
            
            <!-- Title -->
            <h1 class="text-2xl md:text-[34px] font-bold text-gray-900 tracking-tight leading-[1.2] mb-6">
                <?= e($post['title']) ?>
            </h1>
            
       
            
            <!-- Metadata -->
            <div class="flex items-center gap-4 text-sm text-gray-600 mb-8 font-medium">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>11 mins read</span>
                </div>
                <div class="flex items-center gap-1.5 border-l border-gray-300 pl-4">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <?= date('M j, Y', strtotime($post['created_at'])) ?>
                </div>
            </div>

            <!-- Cover Image -->
            <?php if (!empty($post['cover_image'])): ?>
                <div class="w-full mb-10 overflow-hidden rounded-md">
                    <img src="<?= e($post['cover_image']) ?>" class="w-full h-auto object-cover" alt="Cover">
                </div>
            <?php endif; ?>
            
            <!-- Rich Content -->
            <div class="prose prose-lg prose-indigo max-w-none text-gray-800 leading-relaxed mb-12">
                <?= $post['content'] ?>
            </div>

            <!-- Action Bar (Like & Comment) -->
            <div class="border-t border-b border-gray-200 py-4 my-8 flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <button class="flex items-center gap-2 text-gray-500 hover:text-indigo-600 transition group like-btn" data-post-id="<?= $post['id'] ?>">
                        <div class="p-2 rounded-full group-hover:bg-indigo-50 transition">
                            <svg class="w-6 h-6 <?= (false) ? 'text-indigo-600 fill-current' : 'fill-none' ?>" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                        </div>
                        <span class="like-count font-medium text-lg"><?= $post['like_count'] ?? 0 ?></span>
                    </button>
                    <button class="flex items-center gap-2 text-gray-500 hover:text-indigo-600 transition group" onclick="document.getElementById('comments-section').scrollIntoView({behavior: 'smooth'})">
                        <div class="p-2 rounded-full group-hover:bg-indigo-50 transition">
                            <svg class="w-6 h-6 fill-none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-lg"><?= $post['comment_count'] ?? 0 ?></span>
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Share buttons placeholder -->
                    <button class="text-gray-400 hover:text-gray-900 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    </button>
                    <button class="text-gray-400 hover:text-gray-900 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Author Bio Section at the bottom -->
            <div class="mb-12 flex gap-6 items-start bg-gray-50 p-6 rounded-2xl">
                <div class="w-16 h-16 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-2xl shrink-0">
                    <?= substr($post['author_name'] ?? 'U', 0, 1) ?>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-lg mb-1">Written by <?= e($post['author_name']) ?></h4>
                    <p class="text-gray-600 text-sm leading-relaxed">Software Developer and passionate writer exploring technology, system design, and best practices in modern web development.</p>
                </div>
            </div>

            <!-- Comments Section -->
            <div id="comments-section" class="mt-16">
                <h3 class="text-2xl font-bold text-gray-900 mb-8">Comments (<?= $post['comment_count'] ?? 0 ?>)</h3>
                
                <!-- Comment Input -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm mb-10">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm shadow-sm shrink-0">
                            <?= substr($_SESSION['user_name'] ?? 'U', 0, 1) ?>
                        </div>
                        <div class="flex-grow">
                            <textarea class="comment-input w-full bg-transparent border-b border-gray-200 pb-2 focus:border-indigo-600 focus:outline-none resize-none transition text-gray-700 placeholder-gray-400" rows="1" placeholder="What are your thoughts?" data-post-id="<?= $post['id'] ?>" onkeypress="submitComment(event, this)"></textarea>
                            <div class="flex justify-between items-center mt-3">
                                <span class="text-xs text-gray-400">Press Enter to post</span>
                                <button class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-1.5 px-4 rounded-full transition" onclick="submitComment({key:'Enter'}, this.parentElement.previousElementSibling)">Comment</button>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Join the conversation</h4>
                        <p class="text-gray-500 text-sm mb-4">You need to be logged in to leave a comment.</p>
                        <a href="/login" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-6 rounded-full transition">Log In to Comment</a>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Comments List -->
                <div id="comments-<?= $post['id'] ?>">
                    <div class="comments-list space-y-6">
                        <!-- Comments will be loaded via AJAX using toggleComments logic or on load -->
                        <div class="text-center text-gray-400 text-sm py-8">Loading comments...</div>
                    </div>
                </div>
            </div>

            <!-- Auto load comments -->
            <script>
                document.addEventListener('DOMContentLoaded', async () => {
                    const postId = <?= $post['id'] ?>;
                    const list = document.querySelector('#comments-' + postId + ' .comments-list');
                    try {
                        const res = await fetch('/api/comments?post_id=' + postId);
                        const data = await res.json();
                        if (data.success) {
                            list.innerHTML = data.html || '<div class="text-center text-gray-400 italic">No comments yet. Be the first to share your thoughts!</div>';
                        }
                    } catch(e) {
                        list.innerHTML = '<div class="text-red-500 text-center">Failed to load comments.</div>';
                    }
                });

                // Scrollspy for Table of Contents
                document.addEventListener('DOMContentLoaded', () => {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                document.querySelectorAll('.toc-link').forEach((link) => {
                                    link.classList.remove('text-indigo-600', 'border-indigo-600', 'font-bold');
                                    link.classList.add('border-transparent');
                                    if (link.getAttribute('href') === '#' + entry.target.id) {
                                        link.classList.add('text-indigo-600', 'border-indigo-600', 'font-bold');
                                        link.classList.remove('border-transparent', 'font-normal');
                                    }
                                });
                            }
                        });
                    }, { rootMargin: "-100px 0px -70% 0px" });

                    document.querySelectorAll('.prose h2, .prose h3').forEach((section) => {
                        observer.observe(section);
                    });
                });
            </script>
            
        </div>

        <!-- 3. Right Sidebar (Related Courses / Blogs) - Sticky -->
        <div class="hidden xl:block w-[340px] shrink-0 border-l border-gray-200 pl-8 ml-8">
            <div class="sticky top-24 max-h-[calc(100vh-7rem)] overflow-y-auto custom-scrollbar pl-2 pt-2">
                
                <!-- Related Blogs Box -->
                <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <h3 class="font-bold text-gray-900 text-[17px] mb-4">Related Blogs</h3>
                    <div class="space-y-4">
                        <?php if (empty($relatedPosts)): ?>
                            <div class="text-sm text-gray-500 italic">No related blogs found.</div>
                        <?php else: ?>
                            <?php foreach ($relatedPosts as $index => $rPost): ?>
                                <a href="/post/<?= e($rPost['slug']) ?>" class="block group">
                                    <h4 class="text-sm font-medium text-gray-700 group-hover:text-indigo-600 leading-snug">
                                        <?= e($rPost['title']) ?>
                                    </h4>
                                </a>
                                <?php if ($index < count($relatedPosts) - 1): ?>
                                    <div class="border-t border-gray-100"></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
</div>

<style>
    /* Override MainLayout container and body for full-width white design */
    body {
        background-color: #ffffff !important;
    }
    main.container {
        max-width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    /* Styling to make the content look closer to educative's clean typography */
    .prose h1, .prose h2, .prose h3 {
        color: #111827;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-top: 2em;
        margin-bottom: 0.8em;
    }
    .prose p {
        margin-top: 1.2em;
        margin-bottom: 1.2em;
        font-size: 1.125rem; /* 18px */
    }
    .prose img {
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }
    .prose blockquote {
        border-left: none !important;
        padding-left: 0 !important;
        font-style: normal !important;
        color: inherit !important;
    }
    /* Custom thin scrollbars for sidebars */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

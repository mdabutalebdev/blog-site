<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSite Blog Platform</title>
    <!-- Tailwind CSS (CDN for development, consider compiling for prod) -->
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <!-- Quill.js for Rich Text -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <?= component('Navbar') ?>
    
    <main class="flex-grow container mx-auto px-4 py-8">
        {{content}}
    </main>

    <?= component('Footer') ?>

    <script>
        // Profile Dropdown Toggle
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('profile-menu-btn');
            const dropdown = document.getElementById('profile-dropdown');
            
            if (btn && dropdown) {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });
                
                document.addEventListener('click', (e) => {
                    if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }
        });

        // Like Functionality
        document.addEventListener('click', async function(e) {
            const likeBtn = e.target.closest('.like-btn');
            if (likeBtn) {
                const postId = likeBtn.dataset.postId;
                const icon = likeBtn.querySelector('svg');
                const countSpan = likeBtn.querySelector('.like-count');
                
                try {
                    const res = await fetch('/api/like', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({post_id: postId})
                    });
                    const data = await res.json();
                    
                    if (data.error === 'Unauthorized') {
                        window.location.href = '/login';
                        return;
                    }
                    
                    if (data.success) {
                        let count = parseInt(countSpan.innerText);
                        if (data.status === 'liked') {
                            icon.classList.add('text-blue-600', 'fill-current');
                            countSpan.innerText = count + 1;
                        } else {
                            icon.classList.remove('text-blue-600', 'fill-current');
                            countSpan.innerText = Math.max(0, count - 1);
                        }
                    }
                } catch(err) { console.error(err); }
            }
        });

        // Comment Functionality
        async function toggleComments(postId) {
            const container = document.getElementById('comments-' + postId);
            container.classList.toggle('hidden');
            
            if (!container.classList.contains('hidden')) {
                const list = container.querySelector('.comments-list');
                const res = await fetch('/api/comments?post_id=' + postId);
                const data = await res.json();
                if (data.success) {
                    list.innerHTML = data.html;
                }
            }
        }

        async function submitComment(e, input) {
            if (e.key === 'Enter' && input.value.trim() !== '') {
                const postId = input.dataset.postId;
                const content = input.value.trim();
                
                try {
                    const res = await fetch('/api/comments', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({post_id: postId, content: content})
                    });
                    const data = await res.json();
                    
                    if (data.error === 'Unauthorized') {
                        window.location.href = '/login';
                        return;
                    }
                    
                    if (data.success) {
                        input.value = '';
                        // Reload comments
                        const list = document.getElementById('comments-' + postId).querySelector('.comments-list');
                        const commentsRes = await fetch('/api/comments?post_id=' + postId);
                        const commentsData = await commentsRes.json();
                        list.innerHTML = commentsData.html || '<div class="text-center text-gray-400 italic">No comments yet.</div>';
                    }
                } catch(err) { console.error(err); }
            }
        }

        // Reply Functionality
        function toggleReplyBox(commentId) {
            const box = document.getElementById('reply-box-' + commentId);
            if (box) box.classList.toggle('hidden');
        }

        async function submitReply(e, input) {
            if (e.key === 'Enter' && input.value.trim() !== '') {
                if (e.preventDefault) e.preventDefault(); // Prevent new line in textarea
                const postId = input.dataset.postId;
                const parentId = input.dataset.parentId;
                const content = input.value.trim();
                
                try {
                    const res = await fetch('/api/comments', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({post_id: postId, parent_id: parentId, content: content})
                    });
                    const data = await res.json();
                    
                    if (data.error === 'Unauthorized') {
                        window.location.href = '/login';
                        return;
                    }
                    
                    if (data.success) {
                        input.value = '';
                        // Reload all comments for the post
                        const list = document.getElementById('comments-' + postId).querySelector('.comments-list');
                        const commentsRes = await fetch('/api/comments?post_id=' + postId);
                        const commentsData = await commentsRes.json();
                        list.innerHTML = commentsData.html;
                    }
                } catch(err) { console.error(err); }
            }
        }

        async function toggleCommentLike(commentId, btn) {
            try {
                const res = await fetch('/api/comments/like', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({comment_id: commentId})
                });
                const data = await res.json();
                
                if (data.error === 'Unauthorized') {
                    window.location.href = '/login';
                    return;
                }
                
                if (data.success) {
                    const svg = btn.querySelector('svg');
                    const countSpan = btn.querySelector('.like-count');
                    let count = parseInt(countSpan.innerText);
                    
                    if (data.status === 'liked') {
                        svg.classList.remove('fill-none');
                        svg.classList.add('text-indigo-600', 'fill-current');
                        countSpan.innerText = count + 1;
                        countSpan.classList.add('text-indigo-600');
                    } else {
                        svg.classList.add('fill-none');
                        svg.classList.remove('text-indigo-600', 'fill-current');
                        countSpan.innerText = count - 1;
                        countSpan.classList.remove('text-indigo-600');
                    }
                }
            } catch(err) { console.error(err); }
        }
    </script>
</body>
</html>

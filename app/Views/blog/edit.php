<?php
$title = "Edit Post | BlogSite";
?>
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm p-8 mt-6 border border-gray-100">
    <div class="flex justify-between items-center mb-6 border-b border-gray-50 pb-4">
        <h1 class="text-2xl font-bold text-gray-900">Edit Blog</h1>
        <a href="/my-blogs" class="text-sm font-semibold text-gray-500 hover:text-gray-700 transition">Cancel</a>
    </div>
    
    <div id="error-message" class="hidden bg-red-50 text-red-600 p-3 rounded mb-6 text-sm"></div>

    <form id="post-form" onsubmit="submitPost(event)">
        <input type="hidden" id="post_id" value="<?= $post['id'] ?>">
        
        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2">Cover Image (Optional)</label>
            <?php if (!empty($post['cover_image'])): ?>
                <div class="mb-3">
                    <img src="<?= e($post['cover_image']) ?>" alt="Current Cover" class="h-32 rounded object-cover border border-gray-200">
                    <p class="text-xs text-gray-500 mt-1">Leave file input blank to keep the current image.</p>
                </div>
            <?php endif; ?>
            <input type="file" id="cover_image" accept="image/*" class="shadow-sm border border-gray-200 rounded-lg w-full py-2.5 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
            <input type="text" id="title" value="<?= e($post['title']) ?>" class="shadow-sm border border-gray-200 rounded-lg w-full py-2.5 px-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
        </div>
        
        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
            <select id="category" class="shadow-sm border border-gray-200 rounded-lg w-full py-2.5 px-3 text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <option value="" disabled>Select a category...</option>
                <?php
                $categories = [
                    'Technology & Gadgets', 'Programming & Coding', 'Web & App Development',
                    'Artificial Intelligence & ML', 'System Design', 'DevOps & Cloud', 'Data Science & Analytics',
                    'Startup & Business', 'Personal Finance & Investing', 'Marketing & SEO',
                    'Health & Wellness', 'Food & Cooking', 'Travel & Tourism', 'Lifestyle & Fashion',
                    'Entertainment & Pop Culture', 'Sports & Gaming', 'Science & Environment',
                    'Education & Learning', 'Art, Design & Photography', 'Self-Improvement'
                ];
                foreach ($categories as $cat) {
                    $selected = ($post['category'] == $cat) ? 'selected' : '';
                    echo "<option value=\"$cat\" $selected>$cat</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Content</label>
            <div id="editor-container" class="h-96 rounded-b border border-gray-200"></div>
            <!-- Hidden input to hold existing content for quill init -->
            <div id="existing-content" class="hidden"><?= $post['content'] ?></div>
        </div>
        
        <div class="flex justify-end pt-4 border-t border-gray-50">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-full transition shadow-sm hover:shadow" id="submit-btn">
                Update Blog
            </button>
        </div>
    </form>
</div>

<script>
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Compose an epic...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['image', 'code-block', 'blockquote'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['clean']
            ]
        }
    });

    // Load existing content
    quill.root.innerHTML = document.getElementById('existing-content').innerHTML;

    async function submitPost(e) {
        e.preventDefault();
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerText = 'Updating...';

        const postId = document.getElementById('post_id').value;
        const title = document.getElementById('title').value;
        const category = document.getElementById('category').value;
        const content = quill.root.innerHTML;

        try {
            const formData = new FormData();
            formData.append('title', title);
            formData.append('category', category);
            formData.append('content', content);
            
            const coverImage = document.getElementById('cover_image').files[0];
            if (coverImage) {
                formData.append('cover_image', coverImage);
            }

            const res = await fetch('/post/update/' + postId, {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                document.getElementById('error-message').innerText = data.error || 'Something went wrong';
                document.getElementById('error-message').classList.remove('hidden');
                btn.disabled = false;
                btn.innerText = 'Update Blog';
            }
        } catch (err) {
            console.error(err);
            document.getElementById('error-message').innerText = 'Connection error.';
            document.getElementById('error-message').classList.remove('hidden');
            btn.disabled = false;
            btn.innerText = 'Update Blog';
        }
    }
</script>

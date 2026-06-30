<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm p-8 mt-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Write a New Post</h1>
    
    <div id="error-message" class="hidden bg-red-50 text-red-600 p-3 rounded mb-6 text-sm"></div>

    <form id="post-form" onsubmit="submitPost(event)">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Cover Image (Optional)</label>
            <input type="file" id="cover_image" accept="image/*" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Title</label>
            <input type="text" id="title" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
            <select id="category" class="shadow-sm border rounded w-full py-2 px-3 text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                <option value="" disabled selected>Select a category...</option>
                <!-- Technology & Dev -->
                <option value="Technology & Gadgets">Technology & Gadgets</option>
                <option value="Programming & Coding">Programming & Coding</option>
                <option value="Web & App Development">Web & App Development</option>
                <option value="Artificial Intelligence & ML">Artificial Intelligence & ML</option>
                <option value="System Design">System Design</option>
                <option value="DevOps & Cloud">DevOps & Cloud</option>
                <option value="Data Science & Analytics">Data Science & Analytics</option>
                <!-- Business & Finance -->
                <option value="Startup & Business">Startup & Business</option>
                <option value="Personal Finance & Investing">Personal Finance & Investing</option>
                <option value="Marketing & SEO">Marketing & SEO</option>
                <!-- Life & Culture -->
                <option value="Health & Wellness">Health & Wellness</option>
                <option value="Food & Cooking">Food & Cooking</option>
                <option value="Travel & Tourism">Travel & Tourism</option>
                <option value="Lifestyle & Fashion">Lifestyle & Fashion</option>
                <option value="Entertainment & Pop Culture">Entertainment & Pop Culture</option>
                <option value="Sports & Gaming">Sports & Gaming</option>
                <!-- Others -->
                <option value="Science & Environment">Science & Environment</option>
                <option value="Education & Learning">Education & Learning</option>
                <option value="Art, Design & Photography">Art, Design & Photography</option>
                <option value="Self-Improvement">Self-Improvement</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Content</label>
            <div id="editor-container" class="h-64 rounded-b border"></div>
        </div>
        
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full transition shadow-sm hover:shadow" id="submit-btn">
            Publish Post
        </button>
    </form>
</div>

<script>
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Compose an epic...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }]
            ]
        }
    });

    async function submitPost(e) {
        e.preventDefault();
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerText = 'Publishing...';

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

            const res = await fetch('/post/store', {
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
                btn.innerText = 'Publish Post';
            }
        } catch (err) {
            console.error(err);
            btn.disabled = false;
            btn.innerText = 'Publish Post';
        }
    }
</script>

<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm p-6 mt-8 border border-gray-100">
    <div class="flex items-center gap-3 mb-6 border-b pb-3">
        <a href="/books" class="text-gray-400 hover:text-blue-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Upload Book</h2>
    </div>
    
    <?php if (isset($error)): ?>
        <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-5 text-sm font-medium border border-red-100">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <form action="/books/store" method="POST" enctype="multipart/form-data">
        
        <!-- Text Inputs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-gray-700 text-[13px] font-bold mb-1.5" for="title">Book Name</label>
                <input class="appearance-none border border-gray-200 rounded-lg w-full py-2.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                       id="title" name="title" type="text" placeholder="e.g. Clean Code" required>
            </div>
            <div>
                <label class="block text-gray-700 text-[13px] font-bold mb-1.5" for="total_pages">Total Pages</label>
                <input class="appearance-none border border-gray-200 rounded-lg w-full py-2.5 px-3 text-sm text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                       id="total_pages" name="total_pages" type="number" min="1" placeholder="e.g. 450" required>
            </div>
        </div>

        <!-- File Uploads Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            
            <!-- Cover Image Upload -->
            <div>
                <label class="block text-gray-700 text-[13px] font-bold mb-1.5" for="cover_image">Cover Image (Optional)</label>
                <div class="flex justify-center px-4 py-4 border-2 border-gray-200 border-dashed rounded-lg hover:border-blue-500 hover:bg-blue-50 transition relative group bg-gray-50/50">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-400 group-hover:text-blue-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-[13px] text-gray-600 justify-center mt-2">
                            <span class="font-medium text-blue-600">Upload Image</span>
                            <input id="cover_image" name="cover_image" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                        </div>
                        <p class="text-[11px] text-gray-400">JPG, PNG up to 5MB</p>
                    </div>
                </div>
            </div>

            <!-- PDF File Upload -->
            <div>
                <label class="block text-gray-700 text-[13px] font-bold mb-1.5" for="pdf_file">PDF File <span class="text-red-500">*</span></label>
                <div class="flex justify-center px-4 py-4 border-2 border-gray-200 border-dashed rounded-lg hover:border-blue-500 hover:bg-blue-50 transition relative group bg-gray-50/50">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-400 group-hover:text-blue-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-[13px] text-gray-600 justify-center mt-2">
                            <span class="font-medium text-blue-600">Upload PDF</span>
                            <input id="pdf_file" name="pdf_file" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="application/pdf" required>
                        </div>
                        <p class="text-[11px] text-gray-400">PDF up to 20MB</p>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="flex justify-end pt-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 px-8 rounded-lg transition shadow-sm hover:shadow" type="submit">
                Upload to Library
            </button>
        </div>
    </form>
</div>

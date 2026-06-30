<div class="max-w-md mx-auto bg-white rounded-xl shadow-sm overflow-hidden p-8 mt-10">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Create an Account</h2>
    
    <?php if (isset($error)): ?>
        <div class="bg-red-50 text-red-600 p-3 rounded mb-6 text-sm">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <form action="/register" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Full Name</label>
            <input class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                   id="name" name="name" type="text" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email Address</label>
            <input class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                   id="email" name="email" type="email" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
            <div class="relative">
                <input class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition pr-10" 
                       id="password" name="password" type="password" required>
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none" onclick="togglePassword('password', 'eyeIconRegPass')">
                    <svg id="eyeIconRegPass" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Confirm Password</label>
            <div class="relative">
                <input class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition pr-10" 
                       id="password_confirmation" name="password_confirmation" type="password" required>
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none" onclick="togglePassword('password_confirmation', 'eyeIconRegConf')">
                    <svg id="eyeIconRegConf" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            <p id="password-match-msg" class="text-xs font-semibold mt-2 hidden"></p>
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full transition shadow-sm hover:shadow" type="submit">
                Register
            </button>
        </div>
        <div class="mt-4 text-center">
            <span class="text-gray-600 text-sm">Already have an account? </span>
            <a class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800" href="/login">
                Login here
            </a>
        </div>
    </form>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const pass = document.getElementById('password');
    const conf = document.getElementById('password_confirmation');
    const msg = document.getElementById('password-match-msg');

    function checkMatch() {
        if (conf.value.length > 0) {
            msg.classList.remove('hidden');
            if (pass.value === conf.value) {
                msg.textContent = '✓ Passwords match';
                msg.className = 'text-xs font-semibold mt-2 text-green-600';
            } else {
                msg.textContent = '✗ Passwords do not match';
                msg.className = 'text-xs font-semibold mt-2 text-red-600';
            }
        } else {
            msg.classList.add('hidden');
        }
    }

    pass.addEventListener('input', checkMatch);
    conf.addEventListener('input', checkMatch);
});
</script>

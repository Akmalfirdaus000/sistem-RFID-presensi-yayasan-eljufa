<!-- SETUP ALERT NOTIFIKASI ERROR ATAU SUKSES -->
<div class="fixed z-40 w-full max-w-sm md:max-w-md lg:max-w-lg left-1/2 -translate-x-1/2 top-5 px-4">

    @if(session('error'))
        <div id="alert-error" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 relative flex flex-col">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-800" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <h3 class="text-lg font-medium">Peringatan!</h3>
            </div>
            <p class="mt-2 text-sm">{{ session('error') }}</p>
            <button class="absolute top-2 right-2 text-red-800 hover:text-red-900" onclick="this.parentNode.remove()">
                ✖
            </button>
        </div>
    @endif

    @if(session('message'))
        <div id="alert-success" class="p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 relative flex flex-col">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <h3 class="text-lg font-medium">Success!</h3>
            </div>
            <p class="mt-2 text-sm">{{ session('message') }}</p>
            <button class="absolute top-2 right-2 text-green-800 hover:text-green-900" onclick="this.parentNode.remove()">
                ✖
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div id="alert-errors" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 relative flex flex-col">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-800" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <h3 class="text-lg font-medium">Peringatan!</h3>
            </div>
            <ul class="mt-2 text-sm list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="absolute top-2 right-2 text-red-800 hover:text-red-900" onclick="this.parentNode.remove()">
                ✖
            </button>
        </div>
    @endif

</div>

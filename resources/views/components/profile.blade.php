<div class="relative flex items-center gap-3" x-data="{ open: false }">
    <p>{{ Auth::user()->name }}</p>
    <button @click="open = !open" class="flex items-center gap-1 focus:outline-none">
        <img src="{{ Auth::user()->foto_profil_url }}" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover border">
        <svg class="w-4 h-4 text-black-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        x-transition
        class="absolute top-full right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50"
    >
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit Foto Profil</a>
    </div>
</div>

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('pets.index')" :active="request()->routeIs('pets.index')">
                        {{ __('Jouw Huisdieren') }}
                    </x-nav-link>
                    <x-nav-link :href="route('pets.all')" :active="request()->routeIs('pets.all')">
                        {{ __('Alle Huisdieren') }}
                    </x-nav-link>
                    <x-nav-link :href="route('oppassers')" :active="request()->routeIs('oppassers')">
                        {{ __('Alle Oppassers') }}
                    </x-nav-link>
                    <!-- "Mijn Aanvragen" (link to aanvragen.index) -->
                    <x-nav-link :href="route('aanvragen.index')" :active="request()->routeIs('aanvragen.index')">
                        {{ __('Mijn Aanvragen') }}
                    </x-nav-link>
                    <!-- "Mijn Diensten" (link to aanvragen.geaccepteerd) -->
                    <x-nav-link :href="route('aanvragen.geaccepteerd')" :active="request()->routeIs('aanvragen.geaccepteerd')">
                        {{ __('Mijn Diensten') }}
                    </x-nav-link>
                    <!-- Add Reviews Link -->
                    <x-nav-link :href="route('reviews.index')" :active="request()->routeIs('reviews.index')">
                        {{ __('Reviews') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Admin Link (Moved to the right) -->
            <div class="flex items-center">
                <x-nav-link :href="route('admin')" :active="request()->routeIs('admin')">
                    {{ __('Admin') }}
                </x-nav-link>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pets.index')" :active="request()->routeIs('pets.index')">
                {{ __('Jouw Huisdieren') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pets.all')" :active="request()->routeIs('pets.all')">
                {{ __('Alle Huisdieren') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('oppassers')" :active="request()->routeIs('oppassers')">
                {{ __('Alle Oppassers') }}
            </x-responsive-nav-link>
            <!-- "Mijn Aanvragen" (link to aanvragen.index) -->
            <x-responsive-nav-link :href="route('aanvragen.index')" :active="request()->routeIs('aanvragen.index')">
                {{ __('Mijn Aanvragen') }}
            </x-responsive-nav-link>
            <!-- "Mijn Diensten" (link to aanvragen.geaccepteerd) -->
            <x-responsive-nav-link :href="route('aanvragen.geaccepteerd')" :active="request()->routeIs('aanvragen.geaccepteerd')">
                {{ __('Mijn Diensten') }}
            </x-responsive-nav-link>
            <!-- Add Reviews Link -->
            <x-responsive-nav-link :href="route('reviews.index')" :active="request()->routeIs('reviews.index')">
                {{ __('Reviews') }}
            </x-responsive-nav-link>
        </div>
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
        <div class="px-4">
            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>

        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>

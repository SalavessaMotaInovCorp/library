<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @auth
                        <a href="{{ route('dashboard') }}">
                            <img src="https://aircinelmvc.blob.core.windows.net/resources/inovcorp_logo_book_bg_removed.png.png" alt="library" class="mx-auto w-16">
                        </a>
                    @else
                        <a href="/">
                            <img src="https://aircinelmvc.blob.core.windows.net/resources/inovcorp_logo_book_bg_removed.png.png" alt="library" class="mx-auto w-16">
                        </a>
                    @endauth
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            {{ __('Home Page') }}
                        </x-nav-link>
                    @else
                        <x-nav-link href="/" :active="request()->routeIs('dashboard')">
                            {{ __('Home Page') }}
                        </x-nav-link>
                    @endauth
                    <x-nav-link href="{{ route('books.index') }}" :active="request()->routeIs('books.index')">
                        {{ __('Books') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('authors.index') }}" :active="request()->routeIs('authors.index')">
                        {{ __('Authors') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('publishers.index') }}" :active="request()->routeIs('publishers.index')">
                        {{ __('Publishers') }}
                    </x-nav-link>
                    <x-dropdown>
                        <x-slot name="trigger">
                            <x-nav-link href="#"  class="h-full flex items-center">
                                {{ __('Book Requests') }}
                                <svg class="ml-2 -mr-0.5 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </x-nav-link>
                        </x-slot>

                        <x-slot name="content">
                            @if(Auth::user()->hasRole('admin'))
                                <x-dropdown-link href="{{ route('book_requests.index_admin') }}">
                                    {{ __('Book Requests') }}
                                </x-dropdown-link>
                            @else
                                <x-dropdown-link href="{{ route('book_requests.index') }}">
                                    {{ __('Your Book Requests') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link href="{{ route('book_requests.available') }}">
                                {{ __('Make a Request') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                        @if(Auth::user()->hasRole('admin'))
                            <x-nav-link href="{{ route('admin_panel') }}" :active="request()->routeIs('admin_panel')">
                                {{ __('Admin Panel') }}
                            </x-nav-link>
                        @endif



                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">


                <!-- Settings Dropdown -->
                @auth
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex items-center space-x-2 text-sm border-2 border-transparent focus:outline-none focus:border-gray-300 transition">
                                        <div class="text-center self-center">
                                            {{ Auth::user()->name }}
                                            <br/>
                                            @auth
                                                @if(Auth::user()->hasRole('admin'))
                                                    <span class="text-red-500 text-xs">(admin)</span>
                                                @endif
                                            @endauth
                                        </div>
                                        <img class="size-10 rounded-full object-cover"
                                             src="{{ Auth::user()->profile_photo_url }}"
                                             alt="{{ Auth::user()->name }}"/>
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
            <button type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                {{ Auth::user()->name }}
                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
        </span>
                                @endif
                            </x-slot>



                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}"
                                                     @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth

            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
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
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('books.index') }}" :active="request()->routeIs('books.index')">
                {{ __('Books') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('authors.index') }}" :active="request()->routeIs('authors.index')">
                {{ __('Authors') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('publishers.index') }}" :active="request()->routeIs('publishers.index')">
                {{ __('Publishers') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('book_requests.available') }}" :active="request()->routeIs('book_requests.available')">
                {{ __('Make a Book Request') }}
            </x-responsive-nav-link>
            @if(Auth::user()->hasRole('admin'))
                <x-responsive-nav-link href="{{ route('book_requests.index_admin') }}" :active="request()->routeIs('book_requests.index_admin')">
                    {{ __('Book Requests') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('admin_panel') }}" :active="request()->routeIs('admin_panel')">
                    {{ __('ADMIN PANEL') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link href="{{ route('book_requests.index') }}" :active="request()->routeIs('book_requests.index')">
                    {{ __('Your Book Requests') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="shrink-0 me-3">
                            <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }} <p class="text-red-600 text-xs">(admin)</p></div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Account Management -->
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                            {{ __('API Tokens') }}
                        </x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-responsive-nav-link href="{{ route('logout') }}"
                                               @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>

                    <!-- Team Management -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>

                        <!-- Team Settings -->
                        <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                            {{ __('Team Settings') }}
                        </x-responsive-nav-link>

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                {{ __('Create New Team') }}
                            </x-responsive-nav-link>
                        @endcan

                        <!-- Team Switcher -->
                        @if (Auth::user()->allTeams()->count() > 1)
                            <div class="border-t border-gray-200"></div>

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" component="responsive-nav-link" />
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        @endauth

    </div>
</nav>

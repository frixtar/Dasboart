<nav x-data="{ open: false }" class="bg-sky-900 border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo -->
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="h-8 w-auto object-contain" />
                    <span class="font-semibold tracking-wide text-lg text-gray-800">
                        Navegador de Administración
                    </span>
                </a>

                <!-- Desktop links -->
                <div class="hidden sm:flex items-center gap-2">

                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')"
                        class="px-4 py-2 rounded-full text-sm transition
                               hover:bg-white/20
                               {{ request()->routeIs('dashboard') ? 'bg-white/25 font-semibold' : '' }}">
                        Inicio
                    </x-nav-link>

                    <x-nav-link
                        :href="route('products.index')"
                        :active="request()->routeIs('products.*')"
                        class="px-4 py-2 rounded-full text-sm transition
                               hover:bg-white/20
                               {{ request()->routeIs('products.*') ? 'bg-white/25 font-semibold' : '' }}">
                        Productos
                    </x-nav-link>

                    @if(Auth::user()->role === 'administrador')

                        <x-nav-link
                            :href="route('reports.index')"
                            :active="request()->routeIs('reports.*')"
                            class="px-4 py-2 rounded-full text-sm transition
                                   hover:bg-white/20
                                   {{ request()->routeIs('reports.*') ? 'bg-white/25 font-semibold' : '' }}">
                            Reportes
                        </x-nav-link>

                        <x-nav-link
                            :href="route('cashiers.index')"
                            :active="request()->routeIs('cashiers.*')"
                            class="px-4 py-2 rounded-full text-sm transition
                                   hover:bg-white/20
                                   {{ request()->routeIs('cashiers.*') ? 'bg-white/25 font-semibold' : '' }}">
                            Cajeros
                        </x-nav-link>

                    @endif
                </div>
            </div>

            <!-- User dropdown -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center gap-2 px-3 py-2 rounded-full
                                   bg-white/10 hover:bg-white/20 transition text-sm">
                            <span>{{ Auth::user()->name }}</span>
                            <span class="text-xs opacity-80">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                            <svg class="h-4 w-4 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Mi Perfil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar Sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                        class="p-2 rounded-md hover:bg-white/20 transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div x-show="open" x-transition class="sm:hidden bg-black text-gray-800">
        <div class="px-4 pt-4 space-y-2">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Inicio
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                Productos
            </x-responsive-nav-link>

            @if(Auth::user()->role === 'administrador')
                <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                    Reportes
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('cashiers.index')" :active="request()->routeIs('cashiers.*')">
                    Cajeros
                </x-responsive-nav-link>
            @endif

            <div class="border-t pt-4 mt-4">
                <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Mi Perfil
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link
                            :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar Sesión
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

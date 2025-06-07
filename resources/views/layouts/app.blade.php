  <!DOCTYPE html>
  <html lang="es" class="light">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title','Panel Admin')</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js"></script>
    @stack('styles')
  </head>
  <body class="flex h-screen bg-surface dark:bg-surface-dark">

    <div x-data="{ open: false }" class="flex w-full">

      {{-- Movil --}}
      <div
        x-show="open"
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 bg-black/30 z-20 md:hidden"
      ></div>

      {{-- Sidebar--}}
      <aside
        class="fixed inset-y-0 left-0 z-30 w-72 flex flex-col bg-white border-r border-gray-200
              dark:bg-gray-800 dark:border-gray-700 transition-transform md:translate-x-0"
        :class="open ? 'translate-x-0' : '-translate-x-full'"
      >
        
        <div class="flex items-center px-6 py-10">
          <span class="ml-2 text-2xl font-bold text-black dark:text-white text-center">Panel de Administrador</span>
        </div>

        <nav class="mt-4 flex-1 overflow-y-auto">
          <ul class="space-y-2 px-4">
            <li>
              <a href="{{ route('admin.index') }}"
                @class([
                  'flex items-center gap-3 px-4 py-3 rounded-lg transition-colors',
                  request()->routeIs('admin.index')
                    ? 'bg-primary text-white'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/50'
                ])
              >
                <i class="bi bi-speedometer2 text-xl"></i>
                Dashboard
              </a>
            </li>
            <li>
              <a href="{{ route('admin.empresas') }}"
                @class([
                  'flex items-center gap-3 px-4 py-3 rounded-lg transition-colors',
                  request()->routeIs('admin.empresas*')
                    ? 'bg-primary text-white'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/50'
                ])
              >
                <i class="bi bi-building text-xl"></i>
                Empresas
              </a>
            </li>
            <li>
              <a href="{{ route('admin.admins.index') }}"
                @class([
                  'flex items-center gap-3 px-4 py-3 rounded-lg transition-colors',
                  request()->routeIs('admin.admins*')
                    ? 'bg-primary text-white'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700/50'
                ])
              >
                <i class="bi bi-people-fill text-xl"></i>
                Administradores
              </a>
            </li>
          </ul>
        </nav>

        
        <div class="mt-auto px-4 py-4 border-t border-gray-200 dark:border-gray-700">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex w-full items-center text-center gap-3 px-4 py-3 text-red-600 rounded-lg hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-900/30"
            >
              <i class="bi bi-box-arrow-right text-xl"></i>
              Cerrar sesión
            </button>
          </form>
        </div>
      </aside>

      
      <div class="flex-1 flex flex-col">
        <header class="flex items-center justify-between p-4 bg-white border-b border-gray-200
                      dark:bg-gray-900 dark:border-gray-700 md:hidden">
          <button @click="open = !open"
                  class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition">
            <i x-show="!open" class="bi bi-list text-2xl"></i>
            <i x-show="open"  class="bi bi-x-lg text-2xl"></i>
          </button>
          <h1 class="text-xl font-semibold">@yield('title')</h1>
        </header>

        <main id="main-content"
              class="relative flex-1 overflow-auto md:ml-[18rem]">
          @yield('content')
        </main>
      </div>
    </div>

    @vite(['resources/js/app.js'])
    @stack('scripts')
  </body>
  </html>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Panel Admin')</title>
  @vite(['resources/css/app.css'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    /* Penguin theme variables */
    @theme {
      /* light theme */
      --color-surface: var(--color-white);
      --color-surface-alt: var(--color-slate-100);
      --color-on-surface: var(--color-slate-700);
      --color-on-surface-strong: var(--color-black);
      --color-primary: var(--color-blue-700);
      --color-on-primary: var(--color-slate-100);
      --color-secondary: var(--color-indigo-700);
      --color-on-secondary: var(--color-slate-100);
      --color-outline: var(--color-slate-300);
      --color-outline-strong: var(--color-slate-800);

      /* dark theme */
      --color-surface-dark: var(--color-slate-900);
      --color-surface-dark-alt: var(--color-slate-800);
      --color-on-surface-dark: var(--color-slate-300);
      --color-on-surface-dark-strong: var(--color-white);
      --color-primary-dark: var(--color-blue-600);
      --color-on-primary-dark: var(--color-slate-100);
      --color-secondary-dark: var(--color-indigo-600);
      --color-on-secondary-dark: var(--color-slate-100);
      --color-outline-dark: var(--color-slate-700);
      --color-outline-dark-strong: var(--color-slate-300);

      /* shared colors */
      --color-info: var(--color-sky-600);
      --color-on-info: var(--color-white);
      --color-success: var(--color-green-600);
      --color-on-success: var(--color-white);
      --color-warning: var(--color-amber-500);
      --color-on-warning: var(--color-white);
      --color-danger: var(--color-red-600);
      --color-on-danger: var(--color-white);

      /* border radius */
      --radius-radius: var(--radius-lg);
    }
  </style>
</head>
<body class="relative flex w-full flex-col md:flex-row" x-data="{ showSidebar: false }">
  
  <a class="sr-only" href="#main-content">skip to the main content</a>
  
  <div x-cloak x-show="showSidebar"
       class="fixed inset-0 z-10 bg-surface-dark/10 backdrop-blur-xs md:hidden"
       aria-hidden="true"
       x-on:click="showSidebar = false"
       x-transition.opacity>
  </div>

  <!-- Sidebar -->
  <nav x-cloak
       class="fixed left-0 z-20 flex h-svh w-60 shrink-0 flex-col border-r border-outline bg-surface-alt p-4 transition-transform duration-300 md:w-64 md:translate-x-0 md:relative dark:border-outline-dark dark:bg-surface-dark-alt"
       :class="showSidebar ? 'translate-x-0' : '-translate-x-60'"
       aria-label="sidebar navigation">
    <!-- logo -->
    <a href="{{ route('admin.index') }}"
       class="ml-2 w-fit text-2xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
      <span class="sr-only">homepage</span>
      
      AdminPanel
    </a>

    <!-- search bar -->
    <div class="relative my-4 flex w-full max-w-xs flex-col gap-1 text-on-surface dark:text-on-surface-dark">
      <input type="search"
             name="search"
             aria-label="Search"
             placeholder="Buscar..."
             class="w-full border border-outline rounded-radius bg-surface px-2 py-1.5 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:border-outline-dark dark:bg-surface-dark/50 dark:focus-visible:outline-primary-dark" />
    </div>

    <!-- sidebar links -->
    <div class="flex flex-col gap-2 overflow-y-auto pb-6">
      <a href="{{ route('admin.index') }}"
         class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium rounded-radius hover:bg-primary/5 hover:text-on-surface-strong {{ request()->routeIs('admin.index') ? 'bg-primary/10 text-on-surface-strong dark:bg-primary-dark/10 dark:text-on-surface-dark-strong' : 'text-on-surface dark:text-on-surface-dark' }}">
         Dashboard
      </a>
      <a href="{{ route('admin.empresas') }}"
         class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium rounded-radius hover:bg-primary/5 hover:text-on-surface-strong {{ request()->routeIs('admin.empresas*') ? 'bg-primary/10 text-on-surface-strong dark:bg-primary-dark/10 dark:text-on-surface-dark-strong' : 'text-on-surface dark:text-on-surface-dark' }}">
         Empresas
      </a>
      <a href="{{ route('admin.admins.index') }}"
         class="flex items-center gap-2 px-2 py-1.5 text-sm font-medium rounded-radius hover:bg-primary/5 hover:text-on-surface-strong {{ request()->routeIs('admin.admins*') ? 'bg-primary/10 text-on-surface-strong dark:bg-primary-dark/10 dark:text-on-surface-dark-strong' : 'text-on-surface dark:text-on-surface-dark' }}">
         Administradores
      </a>

      <!-- Logout -->
      <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit"
                class="w-full text-left px-2 py-1.5 text-sm font-medium rounded-radius hover:bg-danger/10 hover:text-on-danger dark:hover:bg-danger-dark/10 dark:hover:text-on-danger">
          Cerrar sesión
        </button>
      </form>
    </div>
  </nav>

  <!-- Main content container -->
  <div id="main-content" class="h-svh w-full overflow-y-auto p-4 bg-surface dark:bg-surface-dark">
    <!-- Toggle button for small screens -->
    <button x-cloak
            class="fixed right-4 top-4 z-20 rounded-full bg-primary p-2 md:hidden text-on-primary dark:bg-primary-dark dark:text-on-primary-dark"
            aria-label="Toggle sidebar"
            x-on:click="showSidebar = !showSidebar">
      <svg x-show="showSidebar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-6 h-6">
        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
      </svg>
      <svg x-show="!showSidebar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-6 h-6">
        <path d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z"/>
      </svg>
    </button>

    {{-- Aquí va el contenido de cada vista --}}
    @yield('content')

  </div>

  @vite(['resources/js/app.js'])
</body>
</html>
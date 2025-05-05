@extends('layouts.app')

@push('styles')
<style>
  .enterprises-bg {
    background: url('{{ asset("resources/admin/admin-enterprises1.jpg") }}') center/cover no-repeat;
  }

  .blue-overlay {
    background: rgba(22, 22, 46, 0.8);
  }
  
  .btn-icon {
    @apply p-2 rounded hover:bg-opacity-90 transition-colors;
  }

  .penguin-modal {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
  }
  
  .penguin-modal-content {
    animation: penguinFadeIn 0.3s ease-out;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.1);
  }
  
  @keyframes penguinFadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  [x-cloak] { display: none !important; }
</style>
@endpush

@section('title', 'Gestión de Empresas')

@section('content')
<div class="relative min-h-screen enterprises-bg p-16 z-15">
  <div class="absolute inset-0 blue-overlay z-10"></div>

  <div 
    class="relative z-10 space-y-12"
    x-data="{ 
      showModal: false, 
      actionUrl: '', 
      percentage: '',
      showDeleteModal: false,
      deleteUrl: '',
      companyName: '',
      showCreateUserModal: false,
      showEditUserModal: false,
      createUrl: '',
      editUrl: '',
      currentCompany: null,
      currentUser: null,
      formData: {
        email: '',
        names: '',
        surnames: '',
        dui: '',
        birthdate: '',
        password: '',
        password_confirmation: ''
      }
    }"
  >

    @if($errors->any())
      <div 
        x-data="{ open: true }" 
        x-show="open" 
        x-transition 
        class="relative bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4"
        role="alert"
      >
        <button 
          @click="open = false" 
          class="absolute top-2 right-2 text-red-800 hover:text-red-600 focus:outline-none" 
          aria-label="Cerrar alerta"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M6 6L14 14M6 14L14 6" clip-rule="evenodd" />
          </svg>
        </button>

        <strong class="font-semibold">Hubo errores al procesar el formulario:</strong>
        <ul class="list-disc list-inside mt-2 text-sm">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

  
    @if(session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    {{-- Empresas por aprobar --}}
    <section>
      <h2 class="text-3xl font-bold text-gray-100 mb-6">Solicitud de Empresas</h2>
      
      <div class="overflow-hidden w-full overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow">
        <table class="w-full text-left text-sm text-gray-800 dark:text-gray-200">
          <thead class="border-b border-gray-200 bg-gray-50 text-sm font-medium text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
            <tr>
              <th scope="col" class="p-4">Empresa</th>
              <th scope="col" class="p-4">NIT</th>
              <th scope="col" class="p-4">Correo</th>
              <th scope="col" class="p-4">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
            @forelse($toApprove as $company)
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                <td class="p-4">{{ $company->name }}</td>
                <td class="p-4">{{ $company->nit }}</td>
                <td class="p-4">{{ $company->email }}</td>
                <td class="p-4 space-x-2">
                  <button
                    @click="
                      showModal = true;
                      actionUrl = '{{ route('admin.empresas.aprobar', $company) }}';
                      percentage = ''
                    "
                    class="btn-icon text-white"
                    title="Aprobar"
                  >
                    <i class="bi bi-check-lg hover:text-blue-400 text-xl"></i>
                  </button>
                  <form action="{{ route('admin.empresas.rechazar', $company) }}" method="POST" class="inline">
                    @csrf
                    <button 
                      class="btn-icon text-white"
                      title="Rechazar"
                    >
                      <i class="bi bi-x-lg hover:text-gray-400 text-xl"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">
                  No hay empresas pendientes por aprobar.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

    {{-- Gestión de usuarios de empresas --}}
    <section>
      <h2 class="text-3xl font-bold text-gray-100 mb-6">Gestión de Usuarios</h2>
      
      <div class="overflow-hidden w-full overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow">
        <table class="w-full text-left text-sm text-gray-800 dark:text-gray-200">
          <thead class="border-b border-gray-200 bg-gray-50 text-sm font-medium text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
            <tr>
              <th scope="col" class="p-4">Empresa</th>
              <th scope="col" class="p-4">Correo Empresa</th>
              <th scope="col" class="p-4">Usuario</th>
              <th scope="col" class="p-4">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
            @forelse($forUsers as $company)
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                <td class="p-4">{{ $company->name }}</td>
                <td class="p-4">{{ $company->email }}</td>
                <td class="p-4">
                  @if($company->users->isNotEmpty())
                    <span class="text-green-600 font-medium">Creado</span>
                  @else
                    <span class="text-gray-500">No creado</span>
                  @endif
                </td>
                <td class="p-4 flex gap-4">
                  @if($company->users->isNotEmpty())
                    <button
                      @click="
                        showEditUserModal = true;
                        editUrl = '{{ route('admin.empresas.users.update', ['company'=>$company->company_uuid,'user'=>$company->users->first()->user_uuid]) }}';
                        currentCompany = { name: '{{ $company->name }}' };
                        formData = {
                          email: '{{ $company->users->first()->email }}',
                          names: '{{ $company->users->first()->names }}',
                          surnames: '{{ $company->users->first()->surnames }}',
                          dui: '{{ $company->users->first()->dui }}',
                          birthdate: '{{ \Carbon\Carbon::parse($company->users->first()->birthdate)->format('Y-m-d') }}',
                          password: '',
                          password_confirmation: ''
                        }
                      "
                      class="btn-icon text-white hover:text-blue-600"
                      title="Editar"
                    >
                      <i class="bi bi-pencil-square text-xl"></i>
                    </button>
                    
                    <button
                      @click.prevent="
                        showDeleteModal = true;
                        deleteUrl = '{{ route('admin.empresas.users.destroy',['company'=>$company->company_uuid,'user'=>$company->users->first()->user_uuid]) }}';
                        companyName = '{{ $company->name }}'
                      "
                      class="btn-icon text-white hover:text-gray-400"
                      title="Eliminar"
                    >
                      <i class="bi bi-trash text-xl"></i>
                    </button>
                  @else
                    <button
                      @click="
                        showCreateUserModal = true;
                        createUrl = '{{ route('admin.empresas.users.store', $company->company_uuid) }}';
                        currentCompany = { name: '{{ $company->name }}' };
                        formData = {
                          email: '',
                          names: '',
                          surnames: '',
                          dui: '',
                          birthdate: '',
                          password: '',
                          password_confirmation: ''
                        }
                      "
                      class="btn-icon text-white hover:text-green-700 text-xl"
                      title="Crear usuario"
                    >
                      <i class="bi bi-plus-lg text-xl"></i>
                    </button>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">
                  No hay empresas aprobadas.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

    {{-- Modal porcentaje --}}
    <div 
      x-show="showModal" 
      x-cloak 
      class="fixed inset-0 flex items-center justify-center z-50 penguin-modal"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
    >
      <div 
        class="penguin-modal-content bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-md mx-4"
        @click.away="showModal = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
      >
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-semibold dark:text-white">Porcentaje de comisión (%)</h3>
          <button @click="showModal = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
        <form :action="actionUrl" method="POST">
          @csrf
          <input
            type="number"
            name="percentage"
            x-model="percentage"
            min="0"
            max="100"
            required
            class="w-full border rounded-lg px-4 py-3 mb-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
            placeholder="Ejemplo 10"
          >
          <div class="flex justify-end space-x-3">
            <button 
              type="button" 
              @click="showModal = false" 
              class="px-4 py-2.5 rounded-lg hover:bg-gray-100 transition-colors dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
            >
              Cancelar
            </button>
            <button 
              type="submit" 
              class="px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
              Confirmar
            </button>
          </div>
        </form>
      </div>
    </div>

    {{-- Modal eliminar usuario --}}
    <div 
      x-show="showDeleteModal" 
      x-cloak 
      class="fixed inset-0 flex items-center justify-center z-50 penguin-modal"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
    >
      <div 
        class="penguin-modal-content bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-md mx-4"
        @click.away="showDeleteModal = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
      >
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-semibold dark:text-white">Confirmar eliminación</h3>
          <button @click="showDeleteModal = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
        <p class="mb-6 dark:text-gray-300">¿Eliminar el usuario de <strong x-text="companyName" class="font-medium"></strong>? Esta acción no se puede deshacer.</p>
        <form :action="deleteUrl" method="POST">
          @csrf @method('DELETE')
          <div class="flex justify-end space-x-3">
            <button 
              type="button" 
              @click="showDeleteModal = false" 
              class="px-4 py-2.5 rounded-lg hover:bg-gray-100 transition-colors dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white"
            >
              Cancelar
            </button>
            <button 
              type="submit" 
              class="px-4 py-2.5 bg-red-800 text-white rounded-lg hover:bg-red-700 transition-colors focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            >
              Eliminar
            </button>
          </div>
        </form>
      </div>
    </div>

    {{-- Modal crear usuario --}}
<div 
  x-show="showCreateUserModal" 
  x-cloak 
  class="fixed inset-0 flex items-center justify-center z-50 penguin-modal"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0"
  x-transition:enter-end="opacity-100"
  x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
>
  <div 
    class="penguin-modal-content bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto"
    @click.away="showCreateUserModal = false"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
  >
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold dark:text-white">Crear Usuario para <span x-text="currentCompany.name"></span></h3>
      <button @click="showCreateUserModal = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
    
    <form :action="createUrl" method="POST">
      @csrf
      
      <div class="space-y-4">
        <div>
          <label class="block mb-2 text-sm font-medium dark:text-gray-300">Email</label>
          <input 
            type="email" 
            name="email" 
            x-model="formData.email"
            required 
            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
            placeholder="correo@empresa.com"
          >
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium dark:text-gray-300">Nombres</label>
          <input 
            type="text" 
            name="names" 
            x-model="formData.names"
            required 
            pattern="[\pL\s\-]+"
            pattern="[\pL\s\-]+"
    title="Solo letras, espacios y guiones"title="Solo letras, espacios y guiones"
            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
            placeholder="Nombre(s) del usuario"
          >
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium dark:text-gray-300">Apellidos</label>
          <input 
            type="text" 
            name="surnames" 
            x-model="formData.surnames"
            required 
            pattern="[\pL\s\-]+"
            title="Solo letras, espacios y guiones"
            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
            placeholder="Apellido(s) del usuario"
          >
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium dark:text-gray-300">DUI</label>
          <input 
            type="text" 
            name="dui" 
            x-model="formData.dui"
            required 
            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
            placeholder="00000000-0"
          >
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium dark:text-gray-300">Fecha de Nacimiento</label>
          <input 
            type="date" 
            name="birthdate" 
            x-model="formData.birthdate"
            required 
            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          >
        </div>

        <div class="border-t pt-4">
          <h4 class="font-medium text-lg mb-3 dark:text-white">Contraseña</h4>
          
          <div class="mb-4">
            <label class="block mb-2 text-sm font-medium dark:text-gray-300">Contraseña</label>
            <input 
              type="password" 
              name="password" 
              x-model="formData.password"
              required 
              class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
              placeholder="••••••••"
            >
          </div>

          <div class="mb-4">
            <label class="block mb-2 text-sm font-medium dark:text-gray-300">Confirmar Contraseña</label>
            <input 
              type="password" 
              name="password_confirmation" 
              x-model="formData.password_confirmation"
              required 
              class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
              placeholder="••••••••"
            >
          </div>
        </div>

        <div class="flex gap-3 pt-4">
          <button 
            type="button" 
            @click="showCreateUserModal = false" 
            class="flex-1 text-center px-4 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white rounded-lg transition"
          >
            Cancelar
          </button>
          <button 
            type="submit" 
            class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            Crear Usuario
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Modal editar usuario --}}
<div 
  x-show="showEditUserModal" 
  x-cloak 
  class="fixed inset-0 flex items-center justify-center z-50 penguin-modal"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0"
  x-transition:enter-end="opacity-100"
  x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
>
  <div 
    class="penguin-modal-content bg-white dark:bg-gray-800 p-6 rounded-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto"
    @click.away="showEditUserModal = false"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
  >
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-semibold dark:text-white">Editar Usuario para <span x-text="currentCompany.name"></span></h3>
      <button @click="showEditUserModal = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
    
    <form :action="editUrl" method="POST">
      @csrf
      @method('PUT')
      
      <div class="space-y-4">
        <div>
          <label class="block mb-2 text-sm font-medium dark:text-gray-300">Email</label>
          <input 
            type="email"
            name="email"
            x-model="formData.email"
            required
            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
            placeholder="correo@empresa.com"
          >
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium dark:text-gray-300">Nombres</label>
          <input 
            type="text"
            name="names"
            x-model="formData.names"
            required
            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
            placeholder="Nombre(s) del usuario"
          >
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium dark:text-gray-300">Apellidos</label>
          <input 
            type="text"
            name="surnames"
            x-model="formData.surnames"
            required
            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
            placeholder="Apellido(s) del usuario"
          >
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium dark:text-gray-300">DUI</label>
          <input 
            type="text"
            name="dui"
            x-model="formData.dui"
            required
            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
            placeholder="00000000-0"
          >
        </div>

        <div>
          <label class="block mb-2 text-sm font-medium dark:text-gray-300">Fecha de Nacimiento</label>
          <input 
            type="date"
            name="birthdate"
            x-model="formData.birthdate"
            required
            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          >
        </div>

        <div class="border-t pt-4">
          <h4 class="font-medium text-lg mb-3 dark:text-white">Cambiar Contraseña</h4>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Dejar en blanco para mantener la contraseña actual</p>
          
          <div class="mb-4">
            <label class="block mb-2 text-sm font-medium dark:text-gray-300">Nueva Contraseña</label>
            <input 
              type="password"
              name="password"
              x-model="formData.password"
              class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
              placeholder="••••••••"
            >
          </div>
          
          <div class="mb-4">
            <label class="block mb-2 text-sm font-medium dark:text-gray-300">Confirmar Nueva Contraseña</label>
            <input 
              type="password"
              name="password_confirmation"
              x-model="formData.password_confirmation"
              class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
              placeholder="••••••••"
            >
          </div>
        </div>

        <div class="flex gap-3 pt-4">
          <button 
            type="button" 
            @click="showEditUserModal = false" 
            class="flex-1 text-center px-4 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white rounded-lg transition"
          >
            Cancelar
          </button>
          <button 
            type="submit"
            class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            Actualizar Usuario
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
  </div>
</div>
@endsection
@extends('layouts.app')

@push('styles')
<style>
  .admins-bg {
    background: url('{{ asset("resources/admin/admin-users.jpg") }}') center/cover no-repeat;
  }

  .blue-overlay {
    background: rgba(22, 22, 46, 0.9);
  }
  
  .btn-icon {
    @apply p-2 rounded hover:bg-opacity-90 transition-colors;
  }

  /* Estilos para el modal Penguin */
  .penguin-modal {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
  }
  
  .penguin-modal-content {
    animation: penguinFadeIn 0.3s ease-out;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.2);
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

@section('title', 'Gestión de Administradores')

@section('content')
<div class="relative min-h-screen admins-bg p-16 z-15">
  <div class="absolute inset-0 blue-overlay z-10"></div>

  <div 
    class="relative z-10 space-y-12"
    x-data="{ 
      showCreateAdminModal: false,
      showEditAdminModal: false,
      showDeleteModal: false,
      deleteUrl: '',
      adminName: '',
      createUrl: '{{ route('admin.admins.store') }}',
      editUrl: '',
      formData: {
        email: '',
        names: '',
        surnames: '',
        dui: '',
        birthdate: '',
        password: '',
        password_confirmation: '',
        role_uuid: '{{ $roleUuid }}'
      },
      changePassword: false
    }"
  >
    @if(session('success'))
      <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    {{-- Gestión de administradores --}}
    <section>
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-100">Administradores</h2>
        <button
          @click="
            showCreateAdminModal = true;
            formData = {
              email: '',
              names: '',
              surnames: '',
              dui: '',
              birthdate: '',
              password: '',
              password_confirmation: '',
              role_uuid: '{{ $roleUuid }}'
            };
            changePassword = false;
          "
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 flex items-center gap-2"
        >
          <i class="bi bi-plus-lg"></i>
          Nuevo Administrador
        </button>
      </div>
      
      <div class="overflow-hidden w-full overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow">
        <table class="w-full text-left text-sm text-gray-800 dark:text-gray-200">
          <thead class="border-b border-gray-200 bg-gray-50 text-sm font-medium text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
            <tr>
              <th scope="col" class="p-4">Nombre</th>
              <th scope="col" class="p-4">Correo</th>
              <th scope="col" class="p-4">DUI</th>
              <th scope="col" class="p-4">Nacimiento</th>
              <th scope="col" class="p-4">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
            @forelse($admins as $admin)
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                <td class="p-4">{{ $admin->names }} {{ $admin->surnames }}</td>
                <td class="p-4">{{ $admin->email }}</td>
                <td class="p-4">{{ $admin->dui }}</td>
                <td class="p-4">{{ $admin->birthdate }}</td>
                <td class="p-4 flex gap-4">
                  <button
                    @click="
                      showEditAdminModal = true;
                      editUrl = '{{ route('admin.admins.update', $admin->user_uuid) }}';
                      formData = {
                        email: '{{ $admin->email }}',
                        names: '{{ $admin->names }}',
                        surnames: '{{ $admin->surnames }}',
                        dui: '{{ $admin->dui }}',
                        birthdate: '{{ $admin->birthdate }}',
                        password: '',
                        password_confirmation: '',
                        role_uuid: '{{ $roleUuid }}'
                      };
                      changePassword = false;
                    "
                    class="btn-icon text-white hover:text-blue-600"
                    title="Editar"
                  >
                    <i class="bi bi-pencil-square text-xl"></i>
                  </button>
                  
                  <button
                    @click.prevent="
                      showDeleteModal = true;
                      deleteUrl = '{{ route('admin.admins.destroy', $admin->user_uuid) }}';
                      adminName = '{{ $admin->names }} {{ $admin->surnames }}'
                    "
                    class="btn-icon text-white hover:text-gray-400"
                    title="Eliminar"
                  >
                    <i class="bi bi-trash text-xl"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="p-4 text-center text-gray-500">
                  No hay administradores registrados.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

    {{-- Modal crear administrador --}}
    <div 
      x-show="showCreateAdminModal" 
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
        @click.away="showCreateAdminModal = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
      >
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-semibold dark:text-white">Nuevo Administrador</h3>
          <button @click="showCreateAdminModal = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
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
                placeholder="correo@admin.com"
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
                placeholder="Nombre(s)"
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
                placeholder="Apellido(s)"
              >
            </div>

            <div>
              <label class="block mb-2 text-sm font-medium dark:text-gray-300">DUI</label>
              <input 
                type="text" 
                name="dui" 
                x-model="formData.dui"
                required 
                pattern="^\d{8}-\d{1}$"
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

            <input type="hidden" name="role_uuid" x-model="formData.role_uuid">

            <div class="flex gap-3 pt-4">
              <button 
                type="button" 
                @click="showCreateAdminModal = false" 
                class="flex-1 text-center px-4 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white rounded-lg transition"
              >
                Cancelar
              </button>
              <button 
                type="submit" 
                class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
              >
                Crear
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    {{-- Modal editar administrador --}}
    <div 
      x-show="showEditAdminModal" 
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
        @click.away="showEditAdminModal = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
      >
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-semibold dark:text-white">Editar Administrador</h3>
          <button @click="showEditAdminModal = false" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
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
                placeholder="correo@admin.com"
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
                placeholder="Nombre(s) del administrador"
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
                placeholder="Apellido(s) del administrador"
              >
            </div>

            <div>
              <label class="block mb-2 text-sm font-medium dark:text-gray-300">DUI</label>
              <input 
                type="text"
                name="dui"
                x-model="formData.dui"
                required
                pattern="^\d{8}-\d{1}$"
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
              
              <div class="flex items-center mb-3">
                <input 
                  type="checkbox" 
                  id="changePasswordToggle" 
                  x-model="changePassword"
                  class="mr-2 rounded text-blue-600 focus:ring-blue-500"
                >
                <label for="changePasswordToggle" class="text-sm font-medium dark:text-gray-300">Cambiar contraseña</label>
              </div>
              
              <div x-show="changePassword" class="space-y-3">
                <div>
                  <label class="block mb-2 text-sm font-medium dark:text-gray-300">Nueva Contraseña</label>
                  <input 
                    type="password"
                    name="password"
                    x-model="formData.password"
                    class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                    placeholder="••••••••"
                  >
                </div>
                
                <div>
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
            </div>

            <input type="hidden" name="role_uuid" x-model="formData.role_uuid">

            <div class="flex gap-3 pt-4">
              <button 
                type="button" 
                @click="showEditAdminModal = false" 
                class="flex-1 text-center px-4 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white rounded-lg transition"
              >
                Cancelar
              </button>
              <button 
                type="submit"
                class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
              >
                Actualizar
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    {{-- Modal eliminar administrador --}}
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
        <p class="mb-6 dark:text-gray-300">¿Eliminar al administrador <strong x-text="adminName" class="font-medium"></strong>? Esta acción no se puede deshacer.</p>
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
  </div>
</div>
@endsection
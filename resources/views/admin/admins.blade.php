@extends('layouts.app')

@section('title','Administradores')

@section('content')
<div class="p-6" x-data="{ showModal: false, editMode: false, form: {}, actionUrl: '' }">
    <h2 class="text-2xl font-bold mb-6">Administradores</h2>

    <button
      @click="showModal = true;
               editMode = false;
               form = {};
               actionUrl = '{{ route('admin.admins.store') }}'"
      class="mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Nuevo Administrador
    </button>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white rounded shadow">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Correo</th>
                <th class="px-4 py-2">DUI</th>
                <th class="px-4 py-2">Nacimiento</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $admin->names }} {{ $admin->surnames }}</td>
                <td class="px-4 py-2">{{ $admin->email }}</td>
                <td class="px-4 py-2">{{ $admin->dui }}</td>
                <td class="px-4 py-2">{{ $admin->birthdate }}</td>
                <td class="px-4 py-2 space-x-2">
                    <button
                      @click="showModal = true;
                               editMode = true;
                               form = {
                                 names: '{{ $admin->names }}',
                                 surnames: '{{ $admin->surnames }}',
                                 email: '{{ $admin->email }}',
                                 dui: '{{ $admin->dui }}',
                                 birthdate: '{{ $admin->birthdate }}'
                               };
                               actionUrl = '{{ route('admin.admins.update', $admin->user_uuid) }}'"
                      class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        Editar
                    </button>
                    <form action="{{ route('admin.admins.destroy', $admin->user_uuid) }}"
                          method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div x-show="showModal"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow w-full max-w-lg" @click.away="showModal = false">
            <h3 class="text-lg font-bold mb-4"
                x-text="editMode ? 'Editar Administrador' : 'Nuevo Administrador'"></h3>
            <form :action="actionUrl" method="POST">
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                @csrf
                <input type="hidden" name="role_uuid" value="{{ $roleUuid }}">

                <input type="text" name="names" x-model="form.names"
                       placeholder="Nombres" required
                       class="w-full mb-2 border px-3 py-2 rounded">

                <input type="text" name="surnames" x-model="form.surnames"
                       placeholder="Apellidos" required
                       class="w-full mb-2 border px-3 py-2 rounded">

                <input type="email" name="email" x-model="form.email"
                       placeholder="Correo" required
                       class="w-full mb-2 border px-3 py-2 rounded">

                <input type="text" name="dui" x-model="form.dui"
                       placeholder="DUI" required
                       class="w-full mb-2 border px-3 py-2 rounded">

                <input type="date" name="birthdate" x-model="form.birthdate"
                       required
                       class="w-full mb-4 border px-3 py-2 rounded">

                <template x-if="!editMode">
                    <input type="password" name="password"
                           placeholder="Contraseña" required
                           class="w-full mb-2 border px-3 py-2 rounded">
                    <input type="password" name="password_confirmation"
                           placeholder="Confirmar Contraseña" required
                           class="w-full mb-4 border px-3 py-2 rounded">
                </template>

                <div class="flex justify-end gap-2">
                    <button @click="showModal = false" type="button"
                            class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

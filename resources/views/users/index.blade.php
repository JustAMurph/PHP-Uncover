<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Users</li>
            </ol>
        </nav>
    </div>

    <div class="row mb-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">
                                ID:
                            </th>
                            <th scope="col">
                                User:
                            </th>
                            <th scope="col">
                                Email:
                            </th>
                            <th scope="col">
                                Role:
                            </th>
                            <th scope="col">
                                Actions:
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="">
                                <td scope="row">
                                    {{ $user->id }}
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    {{ $user->role }}
                                </td>
                                <td >
                                    <form action="{{ route('users:delete') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="">
        <a href="<?= route('users:create'); ?>" type="button" style="display:inline-block" class="btn btn-primary text-white" >
            <i class="bi bi-plus"></i> New User</a>
    </div>
</x-app-layout>

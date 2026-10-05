<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 40px;
        }

        .back-arrow {
            font-size: 24px;
            color: #000;
            display: inline-block;
            margin-bottom: 20px;
            cursor: pointer;
            text-decoration: none;
        }

        .container {
            max-width: 500px;
        }

        .title {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table {
            width: 10%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #b5b5b5;
            padding: 8px 12px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        td input[type="checkbox"] {
            cursor: pointer;
            width: 16px;
            height: 16px;
        }

        .btn-edit-save {
            background-color: #c88132;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 2px;
           
        }

        .btn-edit-save:hover {
            background-color: #b06f28;
                        onmouseover="this.style.opacity='0.9'" 
                      onmouseout="this.style.opacity='1'
        }

        .alert-success {
            color: green;
            margin-bottom: 10px;
            font-size: 13px;
        }
    </style>
</head>
<body><x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Management
        </h2>
    </x-slot>

    <div class="container py-4">
        <!-- Display Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-3">
                {{ session('error') }}
            </div>
        @endif

        <form id="accessForm" action="{{ route('user-management.update') }}" method="POST">
            @csrf
            
            <table class="table table-bordered bg-white shadow-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="text-center">Accountant</th>
                        <th class="text-center">Committee</th>
                        <th class="text-center">None</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        @php
                            // Fetch user's role ID for the currently active event
                            $userRoleId = $userRoles[$user->id] ?? null;
                            $accountantRoleId = $roles->where('name', 'accountant')->first()->id ?? null;
                            $committeeRoleId  = $roles->where('name', 'committee')->first()->id ?? null;
                        @endphp
                        <tr>
                            <td>{{ $user->name }}</td>

                            <!-- Accountant Role -->
                            <td style="text-align: center;">
                                <input type="radio" 
                                       name="roles[{{ $user->id }}]" 
                                       value="accountant" 
                                       class="role-radio" 
                                       {{ $userRoleId == $accountantRoleId ? 'checked' : '' }}>
                            </td>

                            <!-- Committee Role -->
                            <td style="text-align: center;">
                                <input type="radio" 
                                       name="roles[{{ $user->id }}]" 
                                       value="committee" 
                                       class="role-radio" 
                                       {{ $userRoleId == $committeeRoleId ? 'checked' : '' }}>
                            </td>

                            <!-- None -->
                            <td style="text-align: center;">
                                <input type="radio" 
                                       name="roles[{{ $user->id }}]" 
                                       value="none" 
                                       class="role-radio" 
                                       {{ is_null($userRoleId) ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <button type="submit" class="btn-edit-save fw-bold  px-4 py-2 mt-3 rounded shadow-sm border-0"">
                EDIT
            </button>
        </form>
    </div>
</x-app-layout>
</body>
</html>
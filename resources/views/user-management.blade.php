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
        }

        .alert-success {
            color: green;
            margin-bottom: 10px;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <form id="accessForm" action="{{ route('roles.store') }}" method="POST">
    @csrf
    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>accountant</th>
                <th>committee</th>
                <th>none</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td style="text-align: center;">
                        <input type="radio" 
                               name="roles[{{ $user->id }}]" 
                               value="accountant" 
                               class="role-radio" 
                              {{ $user->role && strtolower($user->role->name) === 'accountant' ? 'checked' : '' }}>
                    </td>
                          
                    <td style="text-align: center;">
                        <input type="radio" 
                               name="roles[{{ $user->id }}]" 
                               value="committee" 
                               class="role-radio" 
                              {{ $user->role && strtolower($user->role->name) === 'committee' ? 'checked' : '' }} 
                    <td>
                    <td style="text-align: center;">
                        <input type="radio" 
                               name="roles[{{ $user->id }}]" 
                               value="none" 
                               class="role-radio" 
                               {{ !$user->role || !in_array(strtolower($user->role->name), ['accountant', 'committee']) ? 'checked' : '' }}>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <button type="button" id="toggleBtn" class="btn-edit-save" onclick="handleEditSave()">EDIT</button>
</form>

<script>
    let isEditing = false;

    function handleEditSave() {
        const btn = document.getElementById('toggleBtn');
        const form = document.getElementById('accessForm');
        const radios = document.querySelectorAll('.role-radio');

        if (!isEditing) {
            radios.forEach(radio => radio.disabled = false);
            isEditing = true;
            btn.textContent = "Save Changes";
            btn.style.backgroundColor = "#28a745";
        } else {
            form.submit();
        }
    }
</script>
</body>
</html>
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
            width: 100%;
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

    <a href="#" class="back-arrow" onclick="window.history.back()">&#8592;</a>

    <div class="container">
        <div class="title">USER MANAGEMENT SYSTEM</div>

        <!-- Display success message from controller session -->
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form id="accessForm" action="#" method="POST">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Accountant</th>
                        <th>committee</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch users dynamically from controller -->
                    @forelse($users ?? [] as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td style="text-align: center;">
                                <input type="checkbox" 
                                       name="roles[{{ $user->id }}][accountant]" 
                                       class="role-checkbox" 
                                       {{ method_exists($user, 'hasRole') && $user->hasRole('accountant') ? 'checked' : '' }} 
                                       disabled>
                            </td>
                            <td style="text-align: center;">
                                <input type="checkbox" 
                                       name="roles[{{ $user->id }}][committee]" 
                                       class="role-checkbox" 
                                       {{ method_exists($user, 'hasRole') && $user->hasRole('committee') ? 'checked' : '' }} 
                                       disabled>
                            </td>
                        </tr>
                    @empty
                        <!-- Static fallback rows for preview before database integration -->
                        <tr>
                            <td></td>
                            <td style="text-align: center;">
                                <input type="checkbox" class="role-checkbox" disabled>
                            </td>
                            <td style="text-align: center;">
                                <input type="checkbox" class="role-checkbox" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align: center;">
                                <input type="checkbox" class="role-checkbox" checked disabled>
                            </td>
                            <td style="text-align: center;">
                                <input type="checkbox" class="role-checkbox" disabled>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <button type="button" id="toggleBtn" class="btn-edit-save" onclick="handleEditSave()">EDIT</button>
        </form>
    </div>

    <script>
        let isEditing = false;

        function handleEditSave() {
            const btn = document.getElementById('toggleBtn');
            const form = document.getElementById('accessForm');
            const checkboxes = document.querySelectorAll('.role-checkbox');

            if (!isEditing) {
                // Enable checkboxes to allow editing
                checkboxes.forEach(cb => cb.disabled = false);
                isEditing = true;
                btn.textContent = "Save Changes";
                btn.style.backgroundColor = "#28a745";
            } else {
                // Submit form data to Laravel backend
                form.submit();
            }
        }
    </script>

</body>
</html>
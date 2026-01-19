@extends('layouts.app')

@section('title', __('app.admin.manage_users'))

@section('content')
    <div class="admin-container">
        <div class="page-header">
            <h1>{{ __('app.admin.manage_users') }}</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">← {{ __('app.app.back') }}</a>
        </div>

        <div class="filters-section">
            <form method="GET" class="filters-form">
                <div class="filter-group">
                    <input type="text" name="search" placeholder="{{ __('app.admin.search_placeholder') }}"
                        value="{{ request('search') }}" class="filter-input">
                </div>
                <div class="filter-group">
                    <select name="role" class="filter-select">
                        <option value="">{{ __('app.admin.all_roles') }}</option>
                        <option value="player" {{ request('role') === 'player' ? 'selected' : '' }}>{{ __('app.admin.player') }}</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>{{ __('app.admin.admin') }}</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">{{ __('app.admin.filter') }}</button>
                <a href="{{ route('admin.users') }}" class="btn-reset">{{ __('app.admin.reset') }}</a>
            </form>
        </div>

        <div class="users-table-section">
            <div class="table-header">
                <h2>{{ __('app.admin.users') }} ({{ $users->total() }})</h2>
            </div>

            @if($users->count() > 0)
                <div class="table-container">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ __('app.admin.username') }}</th>
                                <th>{{ __('app.admin.email') }}</th>
                                <th>{{ __('app.admin.role') }}</th>
                                <th>{{ __('app.admin.registration_date') }}</th>
                                <th>{{ __('app.admin.last_login') }}</th>
                                <th>{{ __('app.admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>#{{ $user->UserID }}</td>
                                    <td><strong>{{ $user->Username }}</strong></td>
                                    <td>{{ $user->Email }}</td>
                                    <td>
                                        <span class="badge badge-{{ $user->role }}">
                                            {{ $user->role === 'admin' ? '👑 ' . __('app.admin.admin') : '🎮 ' . __('app.admin.player') }}
                                        </span>
                                    </td>
                                    <td>{{ $user->RegisterDate->format('d.m.Y') }}</td>
                                    <td>{{ $user->LastLogin->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.users.show', $user->UserID) }}"
                                                class="btn-action btn-view">{{ __('app.admin.view') }}</a>
                                            <button type="button" class="btn-action btn-change-role"
                                                onclick="openRoleModal({{ $user->UserID }}, '{{ $user->Username }}', '{{ $user->role }}')">
                                                {{ __('app.admin.change_role') }}
                                            </button>
                                            <button type="button" class="btn-action btn-delete"
                                                onclick="confirmDelete({{ $user->UserID }}, '{{ $user->Username }}')">
                                                {{ __('app.admin.delete') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-section">
                    {{ $users->links() }}
                </div>
            @else
                <div class="no-results">
                    <p>{{ __('app.admin.no_careers') }}</p>
                </div>
            @endif
        </div>
    </div>

    <div id="roleModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">{{ __('app.admin.change_role') }}</h2>
                <button type="button" class="close-btn" onclick="closeRoleModal()">&times;</button>
            </div>
            <form id="roleForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p id="modalMessage"></p>
                    <div class="form-group">
                        <label for="newRole">{{ __('app.admin.new_role') }}</label>
                        <select name="role" id="newRole" required class="form-control">
                            <option value="">{{ __('app.admin.change_role') }}</option>
                            <option value="player">🎮 {{ __('app.admin.player') }}</option>
                            <option value="admin">👑 {{ __('app.admin.admin') }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeRoleModal()">{{ __('app.admin.cancel') }}</button>
                    <button type="submit" class="btn-save">{{ __('app.admin.save') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal" style="display: none;">
        <div class="modal-content modal-delete">
            <div class="modal-header">
                <h2>{{ __('app.admin.delete_user') }}</h2>
                <button type="button" class="close-btn" onclick="closeDeleteModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>{{ __('app.admin.confirm_delete') }} <strong id="deleteUsername"></strong>?</p>
                <p style="color: #e74c3c; margin-top: 15px;">⚠️ {{ __('app.admin.delete_warning') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeDeleteModal()">{{ __('app.admin.cancel') }}</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete-confirm">{{ __('app.admin.delete') }}</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2rem;
            color: #333;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            color: white;
            background-color: #5a6268;
        }

        .filters-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filters-form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-input,
        .filter-select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn-filter {
            background-color: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            align-self: flex-end;
        }

        .btn-filter:hover {
            background-color: #5568d3;
        }

        .btn-reset {
            background-color: #95a5a6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .btn-reset:hover {
            color: white;
            background-color: #7f8c8d;
        }

        .users-table-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table-header h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
        }

        .table-container {
            overflow-x: auto;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .users-table th,
        .users-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .users-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #666;
            white-space: nowrap;
        }

        .users-table tr:hover {
            background-color: #f9f9f9;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-admin {
            background-color: #ffd700;
            color: #333;
        }

        .badge-player {
            background-color: #87ceeb;
            color: #333;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .btn-view {
            background-color: #667eea;
            color: white;
        }

        .btn-view:hover {
            color: white;
            background-color: #5568d3;
        }

        .btn-change-role {
            background-color: #f39c12;
            color: white;
        }

        .btn-change-role:hover {
            background-color: #e67e22;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .modal-header h2 {
            margin: 0;
            color: #333;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 2rem;
            cursor: pointer;
            color: #999;
        }

        .close-btn:hover {
            color: #333;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 20px;
            border-top: 1px solid #eee;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn-cancel {
            background-color: #95a5a6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-cancel:hover {
            background-color: #7f8c8d;
        }

        .btn-save {
            background-color: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-save:hover {
            background-color: #229954;
        }

        .btn-delete-confirm {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-delete-confirm:hover {
            background-color: #c0392b;
        }

        .pagination-section {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>

    <script>
        function openRoleModal(userId, username, currentRole) {
            document.getElementById('modalTitle').textContent = `Змінити роль користувача: ${username}`;
            document.getElementById('modalMessage').textContent = `Поточна роль: ${currentRole === 'admin' ? '👑 Адмін' : '🎮 Гравець'}`;
            document.getElementById('newRole').value = currentRole;
            document.getElementById('roleForm').action = `/admin/users/${userId}/change-role`;
            document.getElementById('roleModal').style.display = 'flex';
        }

        function closeRoleModal() {
            document.getElementById('roleModal').style.display = 'none';
        }

        function confirmDelete(userId, username) {
            document.getElementById('deleteUsername').textContent = username;
            document.getElementById('deleteForm').action = `/admin/users/${userId}`;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        window.onclick = function (event) {
            let roleModal = document.getElementById('roleModal');
            let deleteModal = document.getElementById('deleteModal');

            if (event.target === roleModal) {
                roleModal.style.display = 'none';
            }
            if (event.target === deleteModal) {
                deleteModal.style.display = 'none';
            }
        }
    </script>
@endsection
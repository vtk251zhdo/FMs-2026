@extends('layouts.app')

@section('title', __('app.admin.user_profile'))

@section('content')
    <div class="admin-container">
        <div class="page-header">
            <h1>{{ __('app.admin.user_profile') }}</h1>
            <div class="header-actions">
                <a href="{{ route('admin.users') }}" class="btn-back">← {{ __('app.admin.manage_users') }}</a>
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">{{ __('app.admin.dashboard') }}</a>
            </div>
        </div>

        <div class="user-profile-section">

            <div class="profile-card">
                <div class="profile-header">
                    <h2>{{ $user->Username }}</h2>
                    <span class="badge badge-{{ $user->role }}">
                        {{ $user->role === 'admin' ? '👑 ' . __('app.admin.administrator') : '🎮 ' . __('app.admin.player') }}
                    </span>
                </div>

                <div class="profile-info">
                    <div class="info-row">
                        <span class="info-label">{{ __('app.admin.user_id') }}:</span>
                        <span class="info-value">#{{ $user->UserID }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">{{ __('app.admin.email') }}:</span>
                        <span class="info-value">{{ $user->Email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">{{ __('app.admin.registration_date') }}:</span>
                        <span class="info-value">{{ $user->RegisterDate->format('d.m.Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">{{ __('app.admin.last_login') }}:</span>
                        <span class="info-value">{{ $user->LastLogin->format('d.m.Y H:i') }}</span>
                    </div>
                </div>

                <div class="profile-actions">
                    <button type="button" class="btn-action btn-change-role"
                        onclick="openRoleModal({{ $user->UserID }}, '{{ $user->Username }}', '{{ $user->role }}')">
                        {{ __('app.admin.change_role') }}
                    </button>
                    <button type="button" class="btn-action btn-delete"
                        onclick="confirmDelete({{ $user->UserID }}, '{{ $user->Username }}')">
                        {{ __('app.admin.delete_user') }}
                    </button>
                </div>
            </div>

            @if($userClubs->count() > 0)
                <div class="careers-section">
                    <h2>{{ __('app.admin.careers') }}</h2>
                    <div class="careers-list">
                        @foreach($userClubs as $career)
                            <div class="career-card">
                                <div class="career-header">
                                    <h3>{{ $career->club->ClubName }}</h3>
                                    <span class="career-status {{ $career->season->EndDate > now() ? 'active' : 'completed' }}">
                                        {{ $career->season->EndDate > now() ? '🟢 ' . __('app.admin.active') : '⚫ ' . __('app.admin.completed') }}
                                    </span>
                                </div>
                                <div class="career-info">
                                    <div class="info-row">
                                        <span>{{ __('app.admin.tournament') }}:</span>
                                        <strong>{{ $career->season->tournament->TournamentName ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="info-row">
                                        <span>{{ __('app.admin.start_date') }}:</span>
                                        <strong>{{ $career->season->StartDate->format('d.m.Y') }}</strong>
                                    </div>
                                    <div class="info-row">
                                        <span>{{ __('app.admin.end_date') }}:</span>
                                        <strong>{{ $career->season->EndDate->format('d.m.Y') }}</strong>
                                    </div>
                                    <div class="info-row">
                                        <span>{{ __('app.admin.round') }}:</span>
                                        <strong>{{ $career->season->CurrentRound }}/{{ $career->season->TotalRounds }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="no-careers">
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
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 2rem;
            color: #333;
            flex: 1;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn-back,
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
            display: inline-block;
        }

        .btn-back:hover,
        .btn-secondary:hover {
            color: white;
            background-color: #5a6268;
        }

        .user-profile-section {
            display: grid;
            gap: 20px;
        }

        .profile-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .profile-header h2 {
            margin: 0;
            font-size: 1.8rem;
            color: #333;
        }

        .badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.95rem;
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

        .profile-info {
            margin-bottom: 30px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            min-width: 150px;
        }

        .info-value {
            color: #333;
        }

        .profile-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
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

        .careers-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .careers-section h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
        }

        .careers-list {
            display: grid;
            gap: 15px;
        }

        .career-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s;
        }

        .career-card:hover {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-color: #ddd;
        }

        .career-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .career-header h3 {
            margin: 0;
            color: #333;
        }

        .career-status {
            font-size: 0.9rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 15px;
            background-color: #f0f0f0;
        }

        .career-status.active {
            background-color: #d4edda;
            color: #155724;
        }

        .career-status.completed {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .career-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .career-info .info-row {
            border: none;
            padding: 5px 0;
            display: block;
        }

        .career-info .info-row span {
            display: block;
            font-size: 0.9rem;
            color: #666;
        }

        .career-info .info-row strong {
            display: block;
            color: #333;
            margin-top: 3px;
        }

        .no-careers {
            background: white;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            color: #999;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .header-actions {
                width: 100%;
                flex-direction: column;
            }

            .header-actions a {
                width: 100%;
                text-align: center;
            }

            .career-info {
                grid-template-columns: 1fr;
            }
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
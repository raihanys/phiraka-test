<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User — Phiraka Test</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <div id="toast-container"></div>

    <div class="page-shell">

        <div class="topbar">
            <div>
                <h2>Daftar User</h2>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <button class="btn btn-success" onclick="openModal('createModal')">
                    Tambah User
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>

        @include('users.create')

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:50px">No</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Dibuat</th>
                    <th style="width:140px">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span>{{ $user->Username }}</span>
                        </td>
                        <td>
                            <span class="password">
                                ********
                            </span>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($user->CreateTime)->locale('id')->translatedFormat('l, d F Y') }}
                            </br>
                            {{ \Carbon\Carbon::parse($user->CreateTime)->locale('id')->format('H:i:s') }} WIB
                        </td>
                        <td>
                            <div style="display:flex; gap:8px; align-items:center;">
                                <button class="btn btn-primary" onclick="openModal('editModal-{{ $user->Id }}')">
                                    Edit
                                </button>

                                <button class="btn btn-danger"
                                    onclick="openDeleteConfirm('{{ $user->Id }}', '{{ $user->Username }}')">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    @include('users.edit', ['user' => $user])
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; color:var(--muted); padding:30px;">
                            Belum ada user. Silakan tambah user baru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="modal" id="deleteModal">
        <div class="modal-content" style="max-width:360px;">
            <h3 class="modal-title-center">Hapus User?</h3>
            <p class="modal-text" id="deleteModalText">Aksi ini tidak bisa dibatalkan.</p>
            <div class="modal-actions">
                <button class="btn btn-outline" onclick="closeModal('deleteModal')">Batal</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }

        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) closeModal(this.id);
            });
        });

        function openDeleteConfirm(userId, username) {
            document.getElementById('deleteModalText').textContent =
                `Yakin ingin menghapus user "${username}"?`;
            const form = document.getElementById('deleteForm');
            form.action = `/users/${userId}`;
            openModal('deleteModal');
        }

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
        <span class="toast-icon">${type === 'success' ? '✓' : '✕'}</span>
        <span>${message}</span>
    `;
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('out');
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }

        @if (session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif
        @if ($errors->any())
            showToast('{{ $errors->first() }}', 'error');
            @if (old('Username') || session()->hasOldInput())
                openModal('createModal');
            @endif
        @endif
    </script>
</body>

</html>

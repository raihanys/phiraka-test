<div id="editModal-{{ $user->Id }}" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit User</h3>
            <span class="close-btn" onclick="closeModal('editModal-{{ $user->Id }}')">&times;</span>
        </div>
        <form action="{{ route('users.update', $user->Id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="Username" value="{{ $user->Username }}" required>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="Password">
                <small>*Kosongkan jika tidak ingin mengubah password.</small>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:8px;">
                <button type="button" class="btn btn-outline"
                    onclick="closeModal('editModal-{{ $user->Id }}')">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<div id="createModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah User Baru</h3>
            <span class="close-btn" onclick="closeModal('createModal')">&times;</span>
        </div>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="Username" value="{{ old('Username') }}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="Password" required minlength="5" maxlength="8">
                <small>*Minimal 5, maksimal 8 karakter</small>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:8px;">
                <button type="button" class="btn btn-outline" onclick="closeModal('createModal')">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>

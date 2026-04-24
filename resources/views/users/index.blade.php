<h2>DAFTAR USER</h2>
@if (session('success'))
    <div style="color:green">{{ session('success') }}</div>
@endif
<a href="{{ route('users.create') }}">[+] Tambah User</a> |
<form action="{{ route('logout') }}" method="POST" style="display:inline;">@csrf<button type="submit">Logout</button>
</form>
<br><br>
<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Ctime</th>
        <th>Fungsi</th>
    </tr>
    @foreach ($users as $index => $user)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $user->nama }}</td>
            <td>{{ $user->ctime }}</td>
            <td>
                <a href="{{ route('users.edit', $user->id) }}">Edit</a> |
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE') <button type="submit"
                        onclick="return confirm('Yakin hapus?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

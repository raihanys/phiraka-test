<h2>
    SOAL 1 - Fibonacci</h2>
<form action="{{ route('fibonacci') }}" method="POST">
    @csrf
    Rows: <input type="number" name="rows" value="{{ $rows }}" required>
    Cols: <input type="number" name="cols" value="{{ $cols }}" required>
    <button type="submit">Submit</button>
</form>
<br>
@if (!empty($data))
    <table border="1" cellpadding="10">
        @foreach ($data as $row)
            <tr>
                @foreach ($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
@endif

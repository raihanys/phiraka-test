<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fibonacci - Phiraka Test</title>
    <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">
</head>

<body>
    <div class="floating-switch">
        <a href="{{ route('login') }}" class="btn-switch">
            Login Page
        </a>
    </div>

    <div class="page-shell">

        <h2>Fibonacci Grid</h2>

        <div class="card" style="margin-bottom: 24px;">
            <form action="{{ route('fibonacci') }}" method="POST">
                @csrf
                <div class="fib-form">
                    <div class="form-group">
                        <label for="rows">Rows</label>
                        <input type="number" id="rows" name="rows" value="{{ $rows }}" min="1"
                            max="10" required>
                    </div>
                    <div class="form-group">
                        <label for="cols">Columns</label>
                        <input type="number" id="cols" name="cols" value="{{ $cols }}" min="1"
                            max="10" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-bottom:0;">
                        Generate
                    </button>
                </div>
            </form>
        </div>

        @if (!empty($data))
            <div class="fib-table-wrap">
                <table class="fib-table">
                    @foreach ($data as $row)
                        <tr>
                            @foreach ($row as $cell)
                                <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif

    </div>
</body>

</html>

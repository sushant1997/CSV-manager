<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Dashboard</title>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-brand"><a href="" style=" text-decoration: none; color:black;">CSV Manager</a></div>
        <div class="navbar-center">
            @if (session('message'))
                <p>{{ session('message') }}</p>
            @endif
            @if (session('error'))
                <p>{{ session('error') }}</p>
            @endif

            @if ($errors->any())
                <div class="danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li style="color: red">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="navbar-right">
            <a href="{{ route('logout') }}" class="logout-button">Logout</a>
            <span>Logged in as: <strong>{{ Auth::user()->name }}</strong></span>
        </div>
    </nav>

    <div class="container">
        <div class="file-upload">
            <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="csv_file" accept=".csv">
                <button type="submit">Submit</button>
            </form>
        </div>

        <div class="card-container">
            @foreach ($datas as $document)
                <div class="card">
                    <h5 class="card-title" style="color: blue;">{{ $document->document_name }}</h5>
                    <p class="card-text"><strong>Created by:</strong> {{ $document->user->name }}</p>
                    <p class="card-text"><strong>Created at:</strong> {{ $document->created_at }}</p>
                    <p><strong>Checksum: </strong><i><small>{{ $document->document_checksum }}</small></i></p>

                    <div class="card-actions">
                        @if ($document->user_id == Auth::user()->id)
                            <form action="{{ route('delete', $document->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">Delete</button>
                            </form>
                        @endif
                        <a href="{{ route('download', $document->id) }}" class="btn-download">Download</a>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</body>

</html>

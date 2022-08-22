<head>
    <title>Github PHP</title>
    @vite
</head>

<body>
<div class="flex-center position-ref full-height">
    <h1 class="text-3xl font-bold underline">Testing!</h1>
    <div class="content">
        <div class="Repos">
            <table class="table-auto">
                <tr>
                    <th>Project Name</th>
                    <th>Stars</th>
                </tr>
                @foreach ($repositories as $repository)
                    <tr>
                        <td>{{ $repository->projectName }}</td>
                        <td>{{ $repository->stars }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
</body>


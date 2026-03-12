<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard – {{ $title ?? 'Content' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <nav class="bg-slate-800 text-white shadow">
        <div class="max-w-4xl mx-auto px-4 py-3 flex items-center justify-between">
            <span class="font-semibold">Content Dashboard</span>
            <a href="{{ url('/') }}" target="_blank" class="text-sm text-slate-300 hover:text-white">View site →</a>
        </div>
    </nav>
    <div class="max-w-4xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Create product</title>
</head>
<body class="min-h-screen bg-gray-100 p-6 text-gray-900 sm:p-10">
    <main class="mx-auto max-w-xl rounded-lg bg-white p-6 shadow">
        <p class="text-sm font-semibold uppercase tracking-wide text-blue-700">Inventory</p>
        <h1 class="mb-6 mt-1 text-2xl font-bold">Create product</h1>

        @if($errors->any())
            <div role="alert" class="mb-5 rounded border border-red-300 bg-red-50 p-3 text-red-800">
                <ul class="list-inside list-disc">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="mb-1 block font-medium">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required maxlength="255" class="w-full rounded border-gray-300">
            </div>
            <div>
                <label for="description" class="mb-1 block font-medium">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full rounded border-gray-300">{{ old('description') }}</textarea>
            </div>
            <div>
                <label for="price" class="mb-1 block font-medium">Price</label>
                <input id="price" type="number" name="price" value="{{ old('price') }}" min="0" max="99999999.99" step="0.01" required class="w-full rounded border-gray-300">
            </div>
            <div>
                <label for="image" class="mb-1 block font-medium">Image</label>
                <input id="image" type="file" name="image" accept=".jpg,.jpeg,.png,.gif" class="w-full rounded border border-gray-300 p-2">
                <p class="mt-1 text-sm text-gray-500">JPG, PNG, or GIF; maximum 2 MB.</p>
            </div>
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">Save product</button>
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </main>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $product->name }}</title>
</head>
<body class="min-h-screen bg-gray-100 p-6 text-gray-900 sm:p-10">
    <main class="mx-auto max-w-xl rounded-lg bg-white p-6 shadow">
        <p class="text-sm font-semibold uppercase tracking-wide text-blue-700">Inventory</p>
        <h1 class="mb-6 mt-1 text-2xl font-bold">Product details</h1>

        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mb-5 max-h-80 w-full rounded object-contain">
        @endif

        <dl class="space-y-3">
            <div>
                <dt class="font-semibold">Name</dt>
                <dd>{{ $product->name }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Description</dt>
                <dd class="whitespace-pre-line">{{ $product->description ?: '—' }}</dd>
            </div>
            <div>
                <dt class="font-semibold">Price</dt>
                <dd>${{ number_format((float) $product->price, 2) }}</dd>
            </div>
        </dl>

        <div class="mt-6 flex items-center gap-4">
            <a href="{{ route('products.edit', $product) }}" class="rounded bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">Edit</a>
            <a href="{{ route('products.index') }}" class="text-gray-600 hover:underline">Back to products</a>
        </div>
    </main>
</body>
</html>

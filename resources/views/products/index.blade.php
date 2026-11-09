<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Products</title>
</head>
<body class="min-h-screen bg-gray-100 p-6 text-gray-900 sm:p-10">
    <main class="mx-auto max-w-6xl">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-blue-700">Inventory</p>
                <h1 class="mt-1 text-3xl font-bold">Products</h1>
            </div>
            <a href="{{ route('products.create') }}" class="rounded bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
                Add product
            </a>
        </div>

        @if(session('success'))
            <div role="status" class="mb-5 rounded border border-green-300 bg-green-50 p-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="w-full min-w-[640px] text-left">
                <thead class="bg-gray-200 text-sm uppercase text-gray-700">
                    <tr>
                        <th scope="col" class="p-3">Image</th>
                        <th scope="col" class="p-3">Name</th>
                        <th scope="col" class="p-3">Description</th>
                        <th scope="col" class="p-3">Price</th>
                        <th scope="col" class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-t">
                            <td class="p-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-16 w-16 rounded object-cover">
                                @else
                                    <span class="text-sm text-gray-500">No image</span>
                                @endif
                            </td>
                            <td class="p-3 font-medium">{{ $product->name }}</td>
                            <td class="max-w-sm p-3 text-gray-600">{{ $product->description ?: '—' }}</td>
                            <td class="whitespace-nowrap p-3">${{ number_format((float) $product->price, 2) }}</td>
                            <td class="whitespace-nowrap p-3">
                                <a href="{{ route('products.show', $product) }}" class="mr-2 text-green-700 hover:underline">View</a>
                                <a href="{{ route('products.edit', $product) }}" class="mr-2 text-blue-700 hover:underline">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-700 hover:underline" onclick="return confirm('Delete this product?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">No products found. Add one to get started.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

<?php

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('lists products and exposes the CRUD pages', function () {
    $product = Product::create([
        'name' => 'Desk lamp',
        'description' => 'Adjustable light',
        'price' => 29.99,
    ]);

    $this->get(route('products.index'))
        ->assertOk()
        ->assertSee('Desk lamp');

    $this->get(route('products.create'))->assertOk();
    $this->get(route('products.show', $product))->assertOk()->assertSee('Adjustable light');
    $this->get(route('products.edit', $product))->assertOk();
});

it('creates, updates, and deletes a product with its image', function () {
    Storage::fake('public');

    $this->post(route('products.store'), [
        'name' => 'Desk lamp',
        'description' => 'Warm light',
        'price' => '29.99',
        'image' => UploadedFile::fake()->image('lamp.jpg'),
    ])->assertRedirect(route('products.index'));

    $product = Product::firstOrFail();
    expect($product->name)->toBe('Desk lamp')
        ->and($product->image)->not->toBeNull();
    Storage::disk('public')->assertExists($product->image);

    $oldImage = $product->image;
    $this->put(route('products.update', $product), [
        'name' => 'Reading lamp',
        'description' => 'Updated description',
        'price' => '35.00',
        'image' => UploadedFile::fake()->image('reading-lamp.png'),
    ])->assertRedirect(route('products.index'));

    $product->refresh();
    expect($product->name)->toBe('Reading lamp')
        ->and($product->price)->toBe('35.00')
        ->and($product->image)->not->toBe($oldImage);
    Storage::disk('public')->assertMissing($oldImage);
    Storage::disk('public')->assertExists($product->image);

    $this->delete(route('products.destroy', $product))
        ->assertRedirect(route('products.index'));

    expect(Product::count())->toBe(0);
    Storage::disk('public')->assertMissing($product->image);
});

it('rejects invalid product data', function () {
    $this->post(route('products.store'), [
        'name' => '',
        'price' => '-1.239',
    ])->assertSessionHasErrors(['name', 'price']);

    expect(Product::count())->toBe(0);
});

it('keeps the existing image when updating without an image upload', function () {
    Storage::fake('public');

    $image = UploadedFile::fake()->image('lamp.jpg')->store('products', 'public');
    $product = Product::create([
        'name' => 'Desk lamp',
        'price' => 29.99,
        'image' => $image,
    ]);

    $this->put(route('products.update', $product), [
        'name' => 'Desk lamp',
        'price' => '30.00',
    ])->assertRedirect(route('products.index'));

    expect($product->fresh()->image)->toBe($image);
    Storage::disk('public')->assertExists($image);
});

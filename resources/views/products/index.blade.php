<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <table class="table my-5">
        <thead>
            <tr>
                <td>Name</td>
                <td>Price</td>
            </tr>
        </thead>
        <tbody class="bg-white divide-y">
            @forelse($products as $product)
                <tr class="bg-white">
                    <td class="px-6 py-4 whitespace-no-wrap">{{$product->name}}</td>
                    <td class="px-6 py-4 whitespace-no-wrap">{{$product->price}}</td>
                </tr>
            @empty
                <tr class="bg-white">
                    <td class="px-6 py-4 whitespace-no-wrap text-sm">
                        {{ __("No products found") }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
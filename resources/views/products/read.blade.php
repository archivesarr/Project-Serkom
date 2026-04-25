<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-100 border border-gray-200 shadow-lg rounded-xl p-6">

                <div class="flex items-center gap-4 mb-6">
                    <h2 class="text-xl font-bold text-gray-800">
                        Detail Produk #{{ $product->id }}
                    </h2>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-[120px_10px_1fr] gap-2">
                        <div class="font-medium text-gray-700">No Produk</div>
                        <div>:</div>
                        <div>{{ $product->id }}</div>
                    </div>

                    <div class="grid grid-cols-[120px_10px_1fr] gap-2">
                        <div class="font-medium text-gray-700">Nama</div>
                        <div>:</div>
                        <div>{{ $product->nama_produk }}</div>
                    </div>

                    <div class="grid grid-cols-[120px_10px_1fr] gap-2">
                        <div class="font-medium text-gray-700">Deskripsi</div>
                        <div>:</div>
                        <div>
                            {{ $product->deskripsi_produk ?? 'Tidak ada deskripsi' }}
                        </div>
                    </div>

                    <div class="grid grid-cols-[120px_10px_1fr] gap-2">
                        <div class="font-medium text-gray-700">Harga</div>
                        <div>:</div>
                        <div>
                            Rp {{ number_format($product->harga_produk, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="grid grid-cols-[120px_10px_1fr] gap-2">
                        <div class="font-medium text-gray-700">Stok Barang</div>
                        <div>:</div>
                        <div>
                            {{ $product->stok_produk }} unit
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-6 gap-3">
                    <a href="{{ route('products.index') }}"
                        class="bg-gray-400 hover:bg-gray-500 text-gray-700 px-5 py-2 rounded-lg shadow font-semibold">
                        Kembali
                    </a>
                    <a href="{{ route('products.edit', $product->id) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow font-semibold">
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

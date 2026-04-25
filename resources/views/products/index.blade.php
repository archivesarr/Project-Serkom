<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 border border-gray-200 shadow-lg rounded-xl p-6">
                <div class="mb-4">
                    <h1 class="text-3xl font-bold mb-3">Daftar Produk</h1>
                    <div class="flex justify-end items-center mb-6 gap-3">
                        <form method="GET" action="{{ route('products.index') }}" class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow font-semibold">
                                Cari
                            </button>
                        </form>
                        <div class="flex gap-3">
                            <a href="{{ route('products.export') }}"
                                class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg shadow font-semibold">
                                Export XLSX
                            </a>
                            <a href="{{ route('products.create') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow font-semibold">
                                Tambah Produk
                            </a>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 rounded-xl px-4 py-3 bg-green-700 text-white">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full bg-white border rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-4">
                                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => $sort === 'id' && $direction === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                    No
                                    @if($sort === 'id')
                                        <span>{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-4">
                                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'nama_produk', 'direction' => $sort === 'nama_produk' && $direction === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                    Nama
                                    @if($sort === 'nama_produk')
                                        <span>{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-4">
                                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'deskripsi_produk', 'direction' => $sort === 'deskripsi_produk' && $direction === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                    Deskripsi
                                    @if($sort === 'deskripsi_produk')
                                        <span>{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-4">
                                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'harga_produk', 'direction' => $sort === 'harga_produk' && $direction === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                    Harga
                                    @if($sort === 'harga_produk')
                                        <span>{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-4">
                                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'stok_produk', 'direction' => $sort === 'stok_produk' && $direction === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                    Stok
                                    @if($sort === 'stok_produk')
                                        <span>{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-t">
                                <td class="px-4 py-4">
                                    {{ (($products->currentPage() - 1) * $products->perPage()) + $loop->iteration }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ $product->nama_produk }}
                                </td>
                                <td class="px-4 py-4">
                                    {{ $product->deskripsi_produk }}
                                </td>
                                <td class="px-4 py-4">
                                    Rp {{ number_format($product->harga_produk,0,',','.') }}
                                </td>
                                <td class="px-4 py-4">
                                    <span class="px-2 py-4 rounded">
                                        {{ $product->stok_produk }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('products.show',$product->id) }}"
                                            class="bg-green-600 text-white px-3 py-1 rounded">
                                            Lihat
                                        </a>
                                        <a href="{{ route('products.edit',$product->id) }}"
                                            class="bg-blue-600 text-white px-3 py-1 rounded">
                                            Edit
                                        </a>
                                        <button
                                            onclick='openDeleteModal({{ $product->id }}, @json($product->nama_produk))'
                                            class="bg-red-600 text-white px-3 py-1 rounded">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">
                                    Data produk belum ada
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-8 flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold">{{ ($products->currentPage() - 1) * $products->perPage() + 1 }}</span>
                        hingga <span class="font-semibold">{{ min($products->currentPage() * $products->perPage(), $products->total()) }}</span>
                        dari <span class="font-semibold">{{ $products->total() }}</span> hasil
                    </div>
                    <div class="flex gap-1">
                        @if ($products->onFirstPage())
                            <a href="{{ route('products.index', array_merge(request()->query(), ['page' => $products->lastPage()])) }}" class="px-3 py-2 rounded bg-gray-700 text-white hover:bg-gray-900 transition">‹</a>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="px-3 py-2 rounded bg-gray-700 text-white hover:bg-gray-900 transition">‹</a>
                        @endif

                        <div class="flex gap-1">
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if ($page == $products->currentPage())
                                    <span class="px-3 py-2 rounded bg-gray-700 text-white font-semibold">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition">{{ $page }}</a>
                                @endif
                            @endforeach
                        </div>

                        @if ($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="px-3 py-2 rounded bg-gray-700 text-white hover:bg-gray-900 transition">›</a>
                        @else
                            <a href="{{ route('products.index', array_merge(request()->query(), ['page' => 1])) }}" class="px-3 py-2 rounded bg-gray-700 text-white hover:bg-gray-900 transition">›</a>
                        @endif
                    </div>
                </div>

                <div id="deleteFormContainer" style="display:none">
                    @foreach($products as $product)
                        <form
                            id="deleteForm{{ $product->id }}"
                            action="{{ route('products.destroy',$product->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="deleteModal"
        class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold mb-2">Hapus Produk</h3>
            <p class="mb-6">Apakah Anda ingin menghapus produk
                <span id="productName" class="text-red-600 font-semibold"></span>?
            </p>
            <div class="flex justify-end gap-3">
                <button
                    onclick="closeDeleteModal()"
                    class="border px-4 py-2 rounded">
                    Batal
                </button>
                <button
                    onclick="confirmDelete()"
                    class="bg-red-600 text-white px-4 py-2 rounded">
                    Hapus
                </button>

            </div>
        </div>
    </div>

    <script>
        let deleteProductId = null;
        function openDeleteModal(id,name){
            deleteProductId=id;
            document.getElementById('productName').textContent=name;
            let modal=document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal(){
            deleteProductId=null;
            let modal=document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function confirmDelete(){
            if(deleteProductId){
                document.getElementById(
                'deleteForm'+deleteProductId
            ).submit();
            }
        }

        document.getElementById('deleteModal')
        .addEventListener('click',function(e){
            if(e.target===this){
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>

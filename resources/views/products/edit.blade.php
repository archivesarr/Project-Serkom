<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 border border-gray-200 shadow-lg rounded-xl p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">
                    Edit Produk
                </h1>

                <form action="{{ route('products.update', $product->id) }}" method="POST" id="product-form">
                    @csrf
                    @method('PUT')
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="nama_produk"
                                value="{{ old('nama', $product->nama_produk) }}"
                                class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500
                                {{ $errors->has('nama_produk') ? 'border-red-500' : 'border-gray-300' }}"
                                data-validation="required|max:255">

                            <p class="text-red-500 text-sm mt-1 field-error">
                                @error('nama_produk') {{ $message }} @enderror
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi_produk"
                                rows="4"
                                placeholder="Masukkan deskripsi produk (opsional)"
                                class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500
                                {{ $errors->has('deskripsi_produk') ? 'border-red-500' : 'border-gray-300' }}"
                                data-validation="max:1000">{{ old('deskripsi_produk', $product->deskripsi_produk) }}</textarea>

                            <p class="text-red-500 text-sm mt-1 field-error">
                                @error('deskripsi_produk') {{ $message }} @enderror
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga</label>
                            <input type="number" name="harga_produk"
                                value="{{ old('harga', $product->harga_produk) }}"
                                class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500
                                {{ $errors->has('harga_produk') ? 'border-red-500' : 'border-gray-300' }}"
                                data-validation="required|numeric|min:0">

                            <p class="text-red-500 text-sm mt-1 field-error">
                                @error('harga_produk') {{ $message }} @enderror
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stok</label>
                            <input type="number" name="stok_produk"
                                value="{{ old('stok', $product->stok_produk) }}"
                                class="w-full border rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500
                                {{ $errors->has('stok_produk') ? 'border-red-500' : 'border-gray-300' }}"
                                data-validation="required|integer|min:0">

                            <p class="text-red-500 text-sm mt-1 field-error">
                                @error('stok_produk') {{ $message }} @enderror
                            </p>
                        </div>

                    </div>

                    <div class="flex justify-end mt-6 gap-3">
                        <a href="{{ route('products.index') }}"
                            class="bg-gray-400 hover:bg-gray-500 text-gray-700 px-5 py-2 rounded-lg shadow font-semibold">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow font-semibold">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('product-form');
        const fields = form.querySelectorAll('[data-validation]');

        const validators = {
            required: value => value.trim() !== '' || 'Field ini wajib diisi.',
            max: (value, arg) => value.trim().length <= Number(arg) || `Maksimal ${arg} karakter.`,
            numeric: value => value.trim() === '' || !isNaN(value) || 'Harus berupa angka.',
            integer: value => value.trim() === '' || Number.isInteger(Number(value)) || 'Harus bilangan bulat.',
            min: (value, arg) => value.trim() === '' || Number(value) >= Number(arg) || `Nilai minimal adalah ${arg}.`,
        };

        function validateField(field) {
            const rules = field.dataset.validation.split('|');
            let error = '';
            const value = field.value || '';

            for (const rulePair of rules) {
                const [rule, arg] = rulePair.split(':');
                const result = validators[rule](value, arg);
                if (result !== true) {
                    error = result;
                    break;
                }
            }

            const errorNode = field.closest('div').querySelector('.field-error');
            if (error) {
                errorNode.textContent = error;
                field.classList.remove('border-gray-300');
                field.classList.add('border-red-500');
            } else {
                if (errorNode.textContent.trim() === '' || !errorNode.textContent.includes('Nama produk sudah ada')) {
                    errorNode.textContent = '';
                }
                field.classList.remove('border-red-500');
                field.classList.add('border-gray-300');
            }

            return !error;
        }

        fields.forEach(field => {
            field.addEventListener('blur', () => validateField(field));
            field.addEventListener('input', () => validateField(field));
        });

        form.addEventListener('submit', function (event) {
            let valid = true;
            fields.forEach(field => {
                if (!validateField(field)) {
                    valid = false;
                }
            });
            if (!valid) {
                event.preventDefault();
            }
        });
    </script>
</x-app-layout>

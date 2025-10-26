<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Recommendation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.recommendations.store') }}" class="bg-white shadow-sm sm:rounded-lg p-6">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock Symbol *</label>
                    <input type="text" name="stock_symbol" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="e.g., AAPL">
                    @error('stock_symbol')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock Name *</label>
                    <input type="text" name="stock_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="e.g., Apple Inc.">
                    @error('stock_name')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Type *</label>
                    <select name="type" id="type" required class="shadow border rounded w-full py-2 px-3 text-gray-700" onchange="toggleOptionsFields()">
                        <option value="stock">Stock</option>
                        <option value="option">Option</option>
                    </select>
                    @error('type')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div id="options-fields" style="display: none;">
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Option Type *</label>
                        <select name="option_type" id="option_type" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                            <option value="">Select Option Type</option>
                            <option value="call">Call</option>
                            <option value="put">Put</option>
                        </select>
                        @error('option_type')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Strike Price *</label>
                        <input type="number" step="0.01" name="strike_price" id="strike_price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="e.g., 350.00">
                        @error('strike_price')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Expiration Date *</label>
                        <input type="date" name="expiration_date" id="expiration_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        @error('expiration_date')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Action *</label>
                    <select name="action" required class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="">Select Action</option>
                        <option value="buy">BUY</option>
                        <option value="hold">HOLD</option>
                        <option value="sell">SELL</option>
                    </select>
                    @error('action')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="e.g., 150.25">
                    @error('price')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                    <textarea name="notes" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="Additional notes..."></textarea>
                    @error('notes')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Display Order</label>
                    <input type="number" name="display_order" value="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="show_in_marquee" value="1" class="rounded">
                        <span class="ml-2 text-sm text-gray-600">Show in Dashboard Marquee</span>
                    </label>
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded">
                        <span class="ml-2 text-sm text-gray-600">Active</span>
                    </label>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Create Recommendation
                    </button>
                    <a href="{{ route('admin.recommendations.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleOptionsFields() {
            const type = document.getElementById('type').value;
            const optionsFields = document.getElementById('options-fields');
            const optionType = document.getElementById('option_type');
            const strikePrice = document.getElementById('strike_price');
            const expirationDate = document.getElementById('expiration_date');

            if (type === 'option') {
                optionsFields.style.display = 'block';
                optionType.required = true;
                strikePrice.required = true;
                expirationDate.required = true;
            } else {
                optionsFields.style.display = 'none';
                optionType.required = false;
                strikePrice.required = false;
                expirationDate.required = false;
                // Clear values when hiding
                optionType.value = '';
                strikePrice.value = '';
                expirationDate.value = '';
            }
        }
    </script>
</x-app-layout>

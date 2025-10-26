<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Recommendation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.recommendations.update', $recommendation) }}" class="bg-white shadow-sm sm:rounded-lg p-6">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock Symbol *</label>
                    <input type="text" name="stock_symbol" value="{{ $recommendation->stock_symbol }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @error('stock_symbol')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Stock Name *</label>
                    <input type="text" name="stock_name" value="{{ $recommendation->stock_name }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @error('stock_name')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Type *</label>
                    <select name="type" id="type" required class="shadow border rounded w-full py-2 px-3 text-gray-700" onchange="toggleOptionsFields()">
                        <option value="stock" {{ $recommendation->type === 'stock' ? 'selected' : '' }}>Stock</option>
                        <option value="option" {{ $recommendation->type === 'option' ? 'selected' : '' }}>Option</option>
                    </select>
                    @error('type')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div id="options-fields" style="display: {{ $recommendation->type === 'option' ? 'block' : 'none' }};">
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Option Type *</label>
                        <select name="option_type" id="option_type" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                            <option value="">Select Option Type</option>
                            <option value="call" {{ $recommendation->option_type === 'call' ? 'selected' : '' }}>Call</option>
                            <option value="put" {{ $recommendation->option_type === 'put' ? 'selected' : '' }}>Put</option>
                        </select>
                        @error('option_type')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Strike Price *</label>
                        <input type="number" step="0.01" name="strike_price" id="strike_price" value="{{ $recommendation->strike_price }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="e.g., 350.00">
                        @error('strike_price')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Expiration Date *</label>
                        <input type="date" name="expiration_date" id="expiration_date" value="{{ $recommendation->expiration_date ? $recommendation->expiration_date->format('Y-m-d') : '' }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        @error('expiration_date')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Action *</label>
                    <select name="action" required class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        <option value="buy" {{ $recommendation->action === 'buy' ? 'selected' : '' }}>BUY</option>
                        <option value="hold" {{ $recommendation->action === 'hold' ? 'selected' : '' }}>HOLD</option>
                        <option value="sell" {{ $recommendation->action === 'sell' ? 'selected' : '' }}>SELL</option>
                    </select>
                    @error('action')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ $recommendation->price }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    @error('price')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                    <textarea name="notes" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">{{ $recommendation->notes }}</textarea>
                    @error('notes')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Display Order</label>
                    <input type="number" name="display_order" value="{{ $recommendation->display_order }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="show_in_marquee" value="1" {{ $recommendation->show_in_marquee ? 'checked' : '' }} class="rounded">
                        <span class="ml-2 text-sm text-gray-600">Show in Dashboard Marquee</span>
                    </label>
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ $recommendation->is_active ? 'checked' : '' }} class="rounded">
                        <span class="ml-2 text-sm text-gray-600">Active</span>
                    </label>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Update Recommendation
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

        // Set initial required state on page load
        window.addEventListener('DOMContentLoaded', function() {
            const type = document.getElementById('type').value;
            if (type === 'option') {
                document.getElementById('option_type').required = true;
                document.getElementById('strike_price').required = true;
                document.getElementById('expiration_date').required = true;
            }
        });
    </script>
</x-app-layout>

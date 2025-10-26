@props(['show' => true])

@if($show && auth()->check() && auth()->user()->role === 'paid_member')
    @php
        $recommendations = \App\Models\Recommendation::active()->ordered()->get();
    @endphp

    @if($recommendations->count() > 0)
        <div class="w-full lg:w-80 bg-white shadow-lg rounded-lg p-4 sticky top-4">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                </svg>
                Today's Picks
            </h3>

            <div class="space-y-3 max-h-[600px] overflow-y-auto">
                @foreach($recommendations as $rec)
                    <div class="border border-gray-200 rounded-lg p-3 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h4 class="font-bold text-gray-900">{{ $rec->stock_symbol }}</h4>
                                    <span class="px-1.5 py-0.5 rounded text-xs font-medium {{ $rec->type === 'option' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ strtoupper($rec->type) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">{{ $rec->stock_name }}</p>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($rec->action === 'buy') bg-green-100 text-green-800
                                @elseif($rec->action === 'sell') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ strtoupper($rec->action) }}
                            </span>
                        </div>

                        @if($rec->type === 'option')
                            <div class="bg-gray-50 rounded px-2 py-1.5 mb-2">
                                <div class="text-xs text-gray-700">
                                    <span class="font-semibold">{{ strtoupper($rec->option_type) }}</span>
                                    Strike: ${{ number_format($rec->strike_price, 2) }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    Exp: {{ $rec->expiration_date ? $rec->expiration_date->format('M d, Y') : 'N/A' }}
                                </div>
                            </div>
                        @endif

                        @if($rec->price)
                            <div class="text-sm font-semibold text-gray-700 mb-1">
                                ${{ number_format($rec->price, 2) }}
                            </div>
                        @endif

                        @if($rec->notes)
                            <p class="text-xs text-gray-600 mt-2">{{ Str::limit($rec->notes, 80) }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-xs text-center text-gray-500">
                Updated {{ now()->format('M d, Y') }}
            </div>
        </div>
    @endif
@endif

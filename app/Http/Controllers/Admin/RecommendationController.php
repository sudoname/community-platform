<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage recommendations');
        }

        $recommendations = Recommendation::ordered()->paginate(20);
        return view('admin.recommendations.index', compact('recommendations'));
    }

    public function create()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage recommendations');
        }

        return view('admin.recommendations.create');
    }

    public function store(Request $request)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage recommendations');
        }

        $validated = $request->validate([
            'stock_symbol' => 'required|string|max:20',
            'stock_name' => 'required|string|max:255',
            'type' => 'required|in:stock,option',
            'option_type' => 'nullable|required_if:type,option|in:call,put',
            'strike_price' => 'nullable|required_if:type,option|numeric|min:0',
            'expiration_date' => 'nullable|required_if:type,option|date|after:today',
            'action' => 'required|in:buy,sell,hold',
            'price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'show_in_marquee' => 'boolean',
            'is_active' => 'boolean',
            'display_order' => 'nullable|integer',
        ]);

        $validated['show_in_marquee'] = $request->boolean('show_in_marquee');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['display_order'] = $request->input('display_order', 0);

        // Clear options fields if type is stock
        if ($validated['type'] === 'stock') {
            $validated['option_type'] = null;
            $validated['strike_price'] = null;
            $validated['expiration_date'] = null;
        }

        Recommendation::create($validated);

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Recommendation created successfully!');
    }

    public function edit(Recommendation $recommendation)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage recommendations');
        }

        return view('admin.recommendations.edit', compact('recommendation'));
    }

    public function update(Request $request, Recommendation $recommendation)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage recommendations');
        }

        $validated = $request->validate([
            'stock_symbol' => 'required|string|max:20',
            'stock_name' => 'required|string|max:255',
            'type' => 'required|in:stock,option',
            'option_type' => 'nullable|required_if:type,option|in:call,put',
            'strike_price' => 'nullable|required_if:type,option|numeric|min:0',
            'expiration_date' => 'nullable|required_if:type,option|date|after:today',
            'action' => 'required|in:buy,sell,hold',
            'price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'show_in_marquee' => 'boolean',
            'is_active' => 'boolean',
            'display_order' => 'nullable|integer',
        ]);

        $validated['show_in_marquee'] = $request->boolean('show_in_marquee');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['display_order'] = $request->input('display_order', 0);

        // Clear options fields if type is stock
        if ($validated['type'] === 'stock') {
            $validated['option_type'] = null;
            $validated['strike_price'] = null;
            $validated['expiration_date'] = null;
        }

        $recommendation->update($validated);

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Recommendation updated successfully!');
    }

    public function destroy(Recommendation $recommendation)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can manage recommendations');
        }

        $recommendation->delete();

        return redirect()->route('admin.recommendations.index')
            ->with('success', 'Recommendation deleted successfully!');
    }
}

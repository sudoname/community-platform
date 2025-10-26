<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can access settings');
        }

        $settings = Setting::all()->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only admins can update settings');
        }

        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string',
        ]);

        foreach ($validated['settings'] as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                // Handle boolean values
                if ($setting->type === 'boolean') {
                    $value = $request->has("settings.{$key}") ? '1' : '0';
                }
                Setting::set($key, $value, $setting->type);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}

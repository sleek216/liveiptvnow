<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $settings = [
            'announcement_enabled' => Setting::get('announcement_enabled', '1'),
            'announcement_text' => Setting::get('announcement_text', ''),
            'announcement_link' => Setting::get('announcement_link', '/packages'),
            'announcement_link_text' => Setting::get('announcement_link_text', 'Shop Now'),
        ];

        return view('admin.announcement.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'announcement_enabled' => 'boolean',
            'announcement_text' => 'nullable|string|max:500',
            'announcement_link' => 'nullable|string|max:255',
            'announcement_link_text' => 'nullable|string|max:100',
        ]);

        $validated['announcement_enabled'] = $request->boolean('announcement_enabled') ? '1' : '0';

        foreach ($validated as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        return redirect()
            ->route('admin.announcement.index')
            ->with('success', 'Announcement bar updated successfully!');
    }
}

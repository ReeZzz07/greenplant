<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageSectionTitle;
use Illuminate\Http\Request;

class HomePageSectionTitleController extends Controller
{
    public function index()
    {
        $sectionTitles = HomePageSectionTitle::orderBy('order')->get();
        return view('admin.home-page-section-titles.index', compact('sectionTitles'));
    }

    public function edit($id)
    {
        $sectionTitle = HomePageSectionTitle::findOrFail($id);
        return view('admin.home-page-section-titles.edit', compact('sectionTitle'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $sectionTitle = HomePageSectionTitle::findOrFail($id);
        $sectionTitle->update($request->all());

        return redirect()->route('admin.home-page-section-titles.index')
            ->with('success', 'Заголовок секции успешно обновлен!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::withCount('products')->get();
            return view('admin.categories.index', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Failed to load categories. Please try again.');
        }
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories',
                'description' => 'nullable|string',
            ]);

            $validated['slug'] = str()->slug($validated['name']);

            Category::create($validated);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while creating the category. Please try again.')
                ->withInput();
        }
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
                'description' => 'nullable|string',
            ]);

            $validated['slug'] = str()->slug($validated['name']);

            $category->update($validated);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while updating the category. Please try again.')
                ->withInput();
        }
    }

    public function destroy(Category $category)
    {
        try {
            if ($category->products()->count() > 0) {
                return back()->with('error', 'Cannot delete category with products.');
            }

            $category->delete();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while deleting the category. Please try again.');
        }
    }
}

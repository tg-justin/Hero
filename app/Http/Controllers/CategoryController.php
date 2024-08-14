<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
	public function index(): View
	{
		$categories = Category::paginate(25);

		return view('categories.index', compact('categories'));
	}

	public function store(Request $request): RedirectResponse
	{
		$validatedData = $request->validate([
			'name' => 'required|unique:categories|max:255',
			'description' => 'nullable',
		]);

		Category::create($validatedData);

		return redirect()->route('categories.index')->with('success', 'Category created successfully.');
	}

	public function create(): View
	{
		return view('categories.create');
	}

	public function edit(Category $category): View
	{
		return view('categories.edit', compact('category'));
	}

	public function update(Request $request, Category $category): RedirectResponse
	{
		$validatedData = $request->validate([
			'name' => 'required|unique:categories,name,' . $category->id . '|max:255',
			'description' => 'nullable',
		]);

		$category->update($validatedData);

		return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
	}

	public function destroy(Category $category): RedirectResponse
	{
		$category->delete();
		return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
	}
}
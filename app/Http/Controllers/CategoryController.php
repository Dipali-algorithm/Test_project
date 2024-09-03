<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    // Method to fetch and display categories
    public function index(Request $request)
    {
        $parent_id = $request->input('parent_id');

        // Fetch hierarchical category data
        $categoryData = $this->getCategoryData($parent_id);

        return view('index', compact('categoryData'));
    }


    // Method to show the form for creating a new category
    public function create()
    {
        // Fetch parent categories for dropdown selection
        $parentCategories = $this->getCategoryData();

        return view('create', compact('parentCategories'));
    }

    // Method to store a new category
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'category_desc' => 'nullable',
            'parent_id' => 'nullable|exists:categories,cid',
            'sort_order' => 'nullable|integer',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    // Method to show the form for editing a category
    public function edit($cid)
    {
        $category = Category::findOrFail($cid);
        $parentCategories = $this->getCategoryData(); // Fetch all categories for parent selection

        return view('edit', compact('category', 'parentCategories'));
    }

    // Method to update a category
    public function update(Request $request, $cid)
    {
        $request->validate([
            'category_name' => 'required',
            'category_desc' => 'nullable',
            'parent_id' => 'nullable|exists:categories,cid',
            'sort_order' => 'nullable|integer',
        ]);

        $category = Category::findOrFail($cid);
        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    // Method to delete a category
    public function destroy($category)
    {
        $category = Category::findOrFail($category);
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    // Recursive method to fetch hierarchical category data
    private function getCategoryData($parent_id = null, $level = 0)
    {

        $categories = Category::where('parent_id', $parent_id)->orderBy('sort_order')->get();


        $categoryData = [];

        foreach ($categories as $category) {
            $category->level = $level;
            $categoryData[] = $category;
            $categoryData = array_merge($categoryData, $this->getCategoryData($category->cid, $level + 1));
        }

        return $categoryData;
    }
}

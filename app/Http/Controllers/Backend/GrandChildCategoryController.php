<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\GrandChildCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\GrandChildCategory;
use Illuminate\Http\Request;
use Str;

class GrandChildCategoryController extends Controller
{
    public function index(GrandChildCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.grand-child-category.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.grand-child-category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required'],
            'sub_category' => ['required'],
            'child_category' => ['required'],
            'name' => ['required', 'max:200', 'unique:grand_child_categories,name'],
            'status' => ['required']
        ]);

        $grandChildCategory = new GrandChildCategory();

        $grandChildCategory->category_id = $request->category;
        $grandChildCategory->sub_category_id = $request->sub_category;
        $grandChildCategory->child_category_id = $request->child_category;
        $grandChildCategory->name = $request->name;
        $grandChildCategory->slug = Str::slug($request->name);
        $grandChildCategory->status = $request->status;
        $grandChildCategory->save();

        toastr('Created Successfully!', 'success');

        return redirect()->route('admin.grand-child-category.index');
    }

    public function edit(string $id)
    {
        $categories = Category::all();
        $grandChildCategory = GrandChildCategory::findOrFail($id);
        $subCategories = SubCategory::where('category_id', $grandChildCategory->category_id)->get();
        $childCategories = ChildCategory::where('sub_category_id', $grandChildCategory->sub_category_id)->get();

        return view('admin.grand-child-category.edit', compact('categories', 'grandChildCategory', 'subCategories', 'childCategories'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => ['required'],
            'sub_category' => ['required'],
            'child_category' => ['required'],
            'name' => ['required', 'max:200', 'unique:grand_child_categories,name,'.$id],
            'status' => ['required']
        ]);

        $grandChildCategory = GrandChildCategory::findOrFail($id);

        $grandChildCategory->category_id = $request->category;
        $grandChildCategory->sub_category_id = $request->sub_category;
        $grandChildCategory->child_category_id = $request->child_category;
        $grandChildCategory->name = $request->name;
        $grandChildCategory->slug = Str::slug($request->name);
        $grandChildCategory->status = $request->status;
        $grandChildCategory->save();

        toastr('Updated Successfully!', 'success');

        return redirect()->route('admin.grand-child-category.index');
    }

    public function destroy(string $id)
    {
        $grandChildCategory = GrandChildCategory::findOrFail($id);
        $grandChildCategory->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request)
    {
        $grandChildCategory = GrandChildCategory::findOrFail($request->id);
        $grandChildCategory->status = $request->status == 'true' ? 1 : 0;
        $grandChildCategory->save();

        return response(['message' => 'Status has been updated!']);
    }

    public function getChildCategories(Request $request)
    {
        $childCategories = ChildCategory::where('sub_category_id', $request->id)->where('status', 1)->get();
        return $childCategories;
    }
}

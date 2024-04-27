<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Admin\StoreCategoryRequest;
use App\Models\Administrator;
use App\Models\Category;
use App\Traits\UploadUtilsTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use UploadUtilsTrait;

    public function index()
    {
        $admin = $this->request->admin;


        $categories = Category::all();


        return view('admin.categories.index', compact('admin', 'categories'));

    }

    public function create()
    {
        $admin = $this->request->admin;

        return view('admin.categories.create', compact('admin'));
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = Category::create([
                'title'       => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            if ($request->input('deleted_image_logo')) {
                $logo = $category->logo["model"];
                if ($logo) {
                    $this->mediaRemove($logo, 'assetsStorage');
                }
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $this->imageUpload($logo, 'categoryLogo', 'assetsStorage', $category);
            }

            return redirect(route('admin.categories'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function edit(Category $category)
    {
        $admin = $this->request->admin;

        return view('admin.categories.edit', compact('admin', 'category'));
    }

    public function update(Category $category, StoreCategoryRequest $request)
    {
        try {
            $category->update([
                'title'       => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            if ($request->input('deleted_image_logo')) {
                $logo = $category->logo["model"];
                if ($logo) {
                    $this->mediaRemove($logo, 'assetsStorage');
                }
            }
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $this->imageUpload($logo, 'categoryLogo', 'assetsStorage', $category);
            }

            return redirect(route('admin.categories'))->with('message', trans('trs.changed_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }

    public function remove(Category $category)
    {
        try {
            $category->delete();
            return redirect(route('admin.categories'))->with('message', trans('trs.changed_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => trans('trs.changed_unsuccessfully')]);
        }
    }
}

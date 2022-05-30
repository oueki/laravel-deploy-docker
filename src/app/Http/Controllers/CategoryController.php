<?php

namespace App\Http\Controllers;


use App\Exceptions\BusinessException;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{

    public function index(Request $request): View
    {
        $is_trashed = $request->get('trashed');

        $category = Category::query();


        if($is_trashed){
            $category->withTrashed();
        }

        $categoriesCollection = $category
            ->orderBy('id', 'desc')
            ->withCount('posts')
            ->paginate(5)
            ->withQueryString();
//        $categoriesCollection->loadCount('posts');

        return view('web.categories.index', ['categoriesCollection' => $categoriesCollection]);
    }



    public function store(Request $request): RedirectResponse
    {
        $category = new Category;
        $category->name = $request->input('name');
        $category->saveOrFail();

        return back()->with('success', 'The category was created');
    }


    public function show(Category $category)
    {
        //
    }


    public function edit(Category $category): View
    {
        $categoriesCollection = Category::orderBy('id', 'desc')->paginate(5);
        $categoriesCollection->loadCount('posts');
        return view('web.categories.edit', ['category' => $category, 'categoriesCollection' => $categoriesCollection]);
    }


    public function update(Request $request, Category $category): RedirectResponse
    {
        $category->name = $request->input('name');
        $category->saveOrFail();

        return back()->with('success', 'The category has been successfully updated');
    }


    public function destroy(Category $category): RedirectResponse
    {
        $defaultCategory = Category::defaultCategory();
        if($defaultCategory && $category->id === $defaultCategory->id){
            throw new BusinessException("You can't delete a default category");
        }

        if($category->posts()->count()){
            throw new BusinessException("You can't delete a category");
        }

        $category->delete();
        return redirect()->route('categories.index');
    }


    public function default(Category $category): RedirectResponse
    {
//        if($defaultCategory = Category::defaultCategory()){
//            $defaultCategory->makeNoDefault();
//        }
        $category->makeDefault();
        return back()->with('success', 'The category has been successfully updated');
    }

    public function restore($id): RedirectResponse
    {
        $category = Category::withTrashed()->find($id);
        $category->restore();
        return back()->with('success', 'The category has been successfully restored');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  CategoryService  $categoryService
     * @return void
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->middleware('auth');

        $this->categoryService = $categoryService;
    }

    /**
     * Display a list of all categories.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('admin.category.index', [
            'categories' => $this->categoryService->getCategories([], [['id', 'desc']]),
        ]);
    }

    /**
     * Display a form of new category.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        return view('admin.category.form');
    }

    /**
     * Create a new category.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreCategoryRequest $request)
    {
        if ($this->categoryService->storeCategory($request)) {
            return redirect()->route('admin.category.index')->with('message', 'カテゴリを登録しました。');
        } else {
            return redirect()->route('admin.category.index')->with('error', 'カテゴリを登録できませんでした。');
        }
    }

    /**
     * Display a form of edit category.
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        return view('admin.category.form', [
            'category' => $this->categoryService->getCategory($id),
        ]);
    }

    /**
     * Update a category.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        if ($this->categoryService->updateCategory($request, $id)) {
            return redirect()->route('admin.category.index')->with('message', 'カテゴリを編集しました。');
        } else {
            return redirect()->route('admin.category.index')->with('error', 'カテゴリを編集できませんでした。');
        }
    }

    /**
     * Destroy the given category.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        if ($this->categoryService->deleteCategory($id)) {
            return redirect()->route('admin.category.index')->with('message', 'カテゴリを削除しました。');
        } else {
            return redirect()->route('admin.category.index')->with('error', 'カテゴリを削除できませんでした。');
        }
    }
}

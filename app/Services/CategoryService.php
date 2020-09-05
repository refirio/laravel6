<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Contracts\Repositories\CategoryRepository;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryService
{
    /** @var CategoryRepository */
    protected $categoryRepository;

    /**
     * コンストラクタ
     *
     * @param  CategoryRepository  $categoryRepository
     * @return void
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * 1件取得
     *
     * @param  int  $id
     * @return mixed
     */
    public function getCategory($id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * 検索して取得
     *
     * @param  array  $conditions
     * @param  array  $orders
     * @param  int  $limit
     * @return mixed
     */
    public function getCategories(array $conditions = array(), array $orders = array(), $limit = null)
    {
        return $this->categoryRepository->search($conditions, $orders, $limit);
    }

    /**
     * 件数を取得
     *
     * @param  array  $conditions
     * @return int
     */
    public function countCategories(array $conditions = array())
    {
        return $this->categoryRepository->count($conditions);
    }

    /**
     * 登録
     *
     * @param  StoreCategoryRequest  $request
     * @return \App\Models\Category
     */
    public function storeCategory(StoreCategoryRequest $request)
    {
        $input = $request->only([
            'name',
            'sort',
        ]);

        // 保存
        try {
            return DB::transaction(function () use ($input) {
                $result = $this->categoryRepository->save($input);

                return $result;
            });
        } catch (\Exception $e) {
            Log::error('CategoryService:storeCategory', ['message' => $e->getMessage(), 'input' => $input]);

            return null;
        }
    }

    /**
     * 編集
     *
     * @param  UpdateCategoryRequest  $request
     * @param  int  $id
     * @return \App\Models\Category
     */
    public function updateCategory(UpdateCategoryRequest $request, $id)
    {
        $input = $request->only([
            'name',
            'sort',
        ]);

        // 保存
        try {
            return DB::transaction(function () use ($input, $id) {
                $result = $this->categoryRepository->save($input, $id);

                return $result;
            });
        } catch (\Exception $e) {
            Log::error('CategoryService:updateCategory', ['message' => $e->getMessage(), 'input' => $input, 'id' => $id]);

            return null;
        }
    }

    /**
     * 削除
     *
     * @param  int  $id
     * @return \App\Models\Category
     */
    public function deleteCategory($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                return $this->categoryRepository->delete($id);
            });
        } catch (\Exception $e) {
            Log::error('CategoryService:deleteCategory', ['message' => $e->getMessage(), 'id' => $id]);

            return null;
        }
    }
}

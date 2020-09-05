<?php

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepository as CategoryRepositoryContract;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryContract
{
    /** @var Category */
    protected $category;

    /**
     * コンストラクタ
     *
     * @param Category  $category
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * 取得
     *
     * @param  int  $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->category->find($id);
    }

    /**
     * 検索
     *
     * @param  array  $conditions
     * @param  array  $orders
     * @param  int|null  $limit
     * @return mixed
     */
    public function search(array $conditions = array(), array $orders = array(), $limit = null)
    {
        $query = $this->category->query();
        $query = $this->setConditions($query, $conditions);

        foreach ($orders as $order) {
            $query->orderBy($order[0], $order[1]);
        }

        if ($limit == null) {
            return $query->get();
        } else {
            return $query->paginate($limit);
        }
    }

    /**
     * 件数
     *
     * @param  array  $conditions
     * @return int
     */
    public function count(array $conditions = array())
    {
        $query = $this->category->query();
        $query = $this->setConditions($query, $conditions);

        return $query->count();
    }

    /**
     * 保存
     *
     * @param  array  $data
     * @param  int|null  $id
     * @return Category
     */
    public function save(array $data, $id = null)
    {
        return $this->category->updateOrCreate(['id' => $id], $data);
    }

    /**
     * 削除
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->category->findOrFail($id)->delete();
    }

    /**
     * 検索条件を設定
     *
     * @param  int  $query
     * @param  array  $conditions
     * @return \Illuminate\Database\Query\Builder
     */
    private function setConditions($query, array $conditions = array())
    {
        if (isset($conditions['id'])) {
            $query->where('id', $conditions['id']);
        }
        if (isset($conditions['name'])) {
            $query->where('name', $conditions['name']);
        }
        if (isset($conditions['name_like'])) {
            $query->where('name', 'like', $conditions['name_like']);
        }

        return $query;
    }
}

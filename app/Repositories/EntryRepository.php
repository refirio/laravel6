<?php

namespace App\Repositories;

use App\Contracts\Repositories\EntryRepository as EntryRepositoryContract;
use App\Models\Entry;

class EntryRepository implements EntryRepositoryContract
{
    /** @var Entry */
    protected $entry;

    /**
     * コンストラクタ
     *
     * @param Entry  $entry
     * @return void
     */
    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }

    /**
     * 取得
     *
     * @param  int  $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->entry->with(['categories' => function($query) {
            $query->orderBy('sort');
        }, 'user'])->find($id);
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
        $query = $this->entry->query()->with(['categories' => function($query) {
            $query->orderBy('sort');
        }, 'user']);
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
        $query = $this->entry->query();
        $query = $this->setConditions($query, $conditions);

        return $query->count();
    }

    /**
     * 保存
     *
     * @param  array  $data
     * @param  int|null  $id
     * @return Entry
     */
    public function save(array $data, $id = null)
    {
        $entry = $this->entry->updateOrCreate(['id' => $id], $data);

        $model = $this->entry->find($entry->id);
        $model->categories()->sync($data['categories']);

        return $entry;
    }

    /**
     * 削除
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->entry->findOrFail($id)->delete();
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
        if (isset($conditions['title'])) {
            $query->where('title', $conditions['title']);
        }
        if (isset($conditions['title_like'])) {
            $query->where('title', 'like', $conditions['title_like']);
        }

        return $query;
    }
}

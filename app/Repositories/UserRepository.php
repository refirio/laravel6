<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepository as UserRepositoryContract;
use App\Models\User;

class UserRepository implements UserRepositoryContract
{
    /** @var User */
    protected $user;

    /**
     * コンストラクタ
     *
     * @param User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * 取得
     *
     * @param  int  $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->user->find($id);
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
        $query = $this->user->query();
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
        $query = $this->user->query();
        $query = $this->setConditions($query, $conditions);

        return $query->count();
    }

    /**
     * 保存
     *
     * @param  array  $data
     * @param  int|null  $id
     * @return User
     */
    public function save(array $data, $id = null)
    {
        return $this->user->updateOrCreate(['id' => $id], $data);
    }

    /**
     * 削除
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->user->findOrFail($id)->delete();
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

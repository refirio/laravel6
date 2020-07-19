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
     * 1件取得
     *
     * @param  int  $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->user->find($id);
    }

    /**
     * 全件取得
     *
     * @return mixed
     */
    public function findAll()
    {
        return $this->user->query()->orderBy('id', 'asc')->get();
    }

    /**
     * 検索して取得
     *
     * @param  array  $conditions
     * @param  array  $orders
     * @param  int|null  $limit
     * @return mixed
     */
    public function search(array $conditions = array(), array $orders = array(), $limit = null)
    {
        $query = $this->user->query();

        if (isset($conditions['id'])) {
            $query->where('id', $conditions['id']);
        }
        if (isset($conditions['title'])) {
            $query->where('title', $conditions['title']);
        }
        if (isset($conditions['title_like'])) {
            $query->where('title', 'like', $conditions['title']);
        }

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
     * 件数取得
     *
     * @return int
     */
    public function count()
    {
        return $this->user->count();
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
}

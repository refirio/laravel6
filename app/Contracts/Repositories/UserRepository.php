<?php

namespace App\Contracts\Repositories;

interface UserRepository
{
    /**
     * 1件取得
     *
     * @param  int $id
     * @return mixed
     */
    public function find($id);

    /**
     * 全件取得
     *
     * @return mixed
     */
    public function findAll();

    /**
     * 検索して取得
     *
     * @param  array $conditions
     * @param  array $orders
     * @param  int   $limit
     * @return mixed
     */
    public function search(array $conditions, array $orders, $limit);

    /**
     * 件数取得
     *
     * @return int
     */
    public function count();

    /**
     * 保存
     *
     * @param  array $data
     * @param  int $id
     * @return mixed
     */
    public function save(array $data, $id);

    /**
     * 削除
     *
     * @param  int $id
     * @return mixed
     */
    public function delete($id);
}

<?php

namespace App\Contracts\Repositories;

interface CategoryRepository
{
    /**
     * 取得
     *
     * @param  int  $id
     * @return mixed
     */
    public function find($id);

    /**
     * 検索
     *
     * @param  array  $conditions
     * @param  array  $orders
     * @param  int|null  $limit
     * @return mixed
     */
    public function search(array $conditions, array $orders, $limit);

    /**
     * 件数
     *
     * @return int
     */
    public function count();

    /**
     * 保存
     *
     * @param  array  $data
     * @param  int|null  $id
     * @return mixed
     */
    public function save(array $data, $id);

    /**
     * 削除
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete($id);
}

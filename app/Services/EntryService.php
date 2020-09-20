<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Contracts\Repositories\EntryRepository;
use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;

class EntryService
{
    /** @var EntryRepository */
    protected $entryRepository;

    /**
     * コンストラクタ
     *
     * @param  EntryRepository  $entryRepository
     * @return void
     */
    public function __construct(EntryRepository $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    /**
     * 1件取得
     *
     * @param  int  $id
     * @return mixed
     */
    public function getEntry($id)
    {
        return $this->entryRepository->find($id);
    }

    /**
     * 検索して取得
     *
     * @param  array  $conditions
     * @param  array  $orders
     * @param  int  $limit
     * @return mixed
     */
    public function getEntries(array $conditions = array(), array $orders = array(), $limit = null)
    {
        return $this->entryRepository->search($conditions, $orders, $limit);
    }

    /**
     * 件数を取得
     *
     * @param  array  $conditions
     * @return int
     */
    public function countEntries(array $conditions = array())
    {
        return $this->entryRepository->count($conditions);
    }

    /**
     * 登録
     *
     * @param  StoreEntryRequest  $request
     * @return \App\Models\Entry
     */
    public function storeEntry(StoreEntryRequest $request)
    {
        $input = $request->only([
            'datetime',
            'title',
            'body',
            'categories',
            'user_id',
        ]);

        // 保存
        try {
            return DB::transaction(function () use ($input) {
                $result = $this->entryRepository->save($input);

                return $result;
            });
        } catch (\Exception $e) {
            Log::error('EntryService:storeEntry', ['message' => $e->getMessage(), 'input' => $input]);

            return null;
        }
    }

    /**
     * 編集
     *
     * @param  UpdateEntryRequest  $request
     * @param  int  $id
     * @return \App\Models\Entry
     */
    public function updateEntry(UpdateEntryRequest $request, $id)
    {
        $input = $request->only([
            'datetime',
            'title',
            'body',
            'categories',
            'user_id',
        ]);

        // 保存
        try {
            return DB::transaction(function () use ($input, $id) {
                $result = $this->entryRepository->save($input, $id);

                return $result;
            });
        } catch (\Exception $e) {
            Log::error('EntryService:updateEntry', ['message' => $e->getMessage(), 'input' => $input, 'id' => $id]);

            return null;
        }
    }

    /**
     * 削除
     *
     * @param  int  $id
     * @return \App\Models\Entry
     */
    public function deleteEntry($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                return $this->entryRepository->delete($id);
            });
        } catch (\Exception $e) {
            Log::error('EntryService:deleteEntry', ['message' => $e->getMessage(), 'id' => $id]);

            return null;
        }
    }
}

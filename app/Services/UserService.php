<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Contracts\Repositories\UserRepository;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserService
{
    /** @var UserRepository */
    protected $userRepository;

    /**
     * コンストラクタ
     *
     * @param UserRepository $userRepository
     * @return void
     */
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 1件取得
     *
     * @param  int $id
     * @return mixed
     */
    public function getUser($id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * 全件取得
     *
     * @return mixed
     */
    public function getUsers()
    {
        return $this->userRepository->findAll();
    }

    /**
     * 検索して取得
     *
     * @param  array $conditions
     * @param  array $orders
     * @param  int   $limit
     * @return mixed
     */
    public function searchUsers(array $conditions = array(), array $orders = array(), $limit = null)
    {
        return $this->userRepository->search($conditions, $orders, $limit);
    }

    /**
     * 件数取得
     *
     * @return int
     */
    public function count()
    {
        return $this->userRepository->count();
    }

    /**
     * 登録
     *
     * @param  StoreUserRequest $request
     * @return \App\Models\User
     */
    public function storeUser(StoreUserRequest $request)
    {
        $input = $request->only([
            'name',
            'email',
            'password',
        ]);

        // パスワードを暗号化
        $input['password'] = Hash::make($input['password']);

        // 保存
        try {
            return DB::transaction(function () use ($input) {
                $result = $this->userRepository->save($input);

                return $result;
            });
        } catch (\Exception $e) {
            Log::error('UserService:storeUser', ['message' => $e->getMessage(), 'input' => $input]);

            return null;
        }
    }

    /**
     * 編集
     *
     * @param  UpdateUserPost $request
     * @param  int $id
     * @return \App\Models\User
     */
    public function updateUser(UpdateUserRequest $request, $id)
    {
        $input = $request->only([
            'name',
            'email',
            'password',
        ]);

        // パスワードを暗号化
        if (empty($input['password'])) {
            unset($input['password']);
        } else {
            $input['password'] = Hash::make($input['password']);
        }

        // 保存
        try {
            return DB::transaction(function () use ($input, $id) {
                $result = $this->userRepository->save($input, $id);

                return $result;
            });
        } catch (\Exception $e) {
            Log::error('UserService:updateUser', ['message' => $e->getMessage(), 'input' => $input, 'id' => $id]);

            return null;
        }
    }

    /**
     * 削除
     *
     * @param  int $id
     * @return \App\Models\User
     */
    public function deleteUser($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                return $this->userRepository->delete($id);
            });
        } catch (\Exception $e) {
            Log::error('UserService:deleteUser', ['message' => $e->getMessage(), 'id' => $id]);

            return null;
        }
    }
}

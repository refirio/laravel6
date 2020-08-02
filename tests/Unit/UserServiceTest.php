<?php

namespace Tests\Unit;

//use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCountUsers()
    {
        $userService = new \App\Services\UserService(
            // コントラクトを実装したスタブクラスへ差し替える
            new StubUserRepository()
        );
        $this->assertEquals(3, $userService->countUsers());
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testStoreUser()
    {
        $userService = new \App\Services\UserService(
            // コントラクトを実装したスタブクラスへ差し替える
            new StubUserRepository()
        );

        $postRequest = new \App\Http\Requests\StoreUserRequest();
        $postRequest->merge([
            'name' => 'Taro Yamada',
            'email' => 'taro@example.com',
            'password' => 'abcd1234',
        ]);

        $result = $userService->storeUser($postRequest);
        $this->assertInstanceOf('\App\Models\User', $result);
    }
}

class StubUserRepository implements \App\Contracts\Repositories\UserRepository
{
    /**
     * 取得
     *
     * @param  int  $id
     * @return mixed
     */
    public function find($id) {
    }

    /**
     * 検索
     *
     * @param  array  $conditions
     * @param  array  $orders
     * @param  int|null  $limit
     * @return mixed
     */
    public function search(array $conditions, array $orders, $limit) {
    }

    /**
     * 件数
     *
     * @return int
     */
    public function count() {
        return 3;
    }

    /**
     * 保存
     *
     * @param  array  $data
     * @param  int|null  $id
     * @return mixed
     */
    public function save(array $data, $id = null) {
        return new \App\Models\User;
    }

    /**
     * 削除
     *
     * @param  int  $id
     * @return mixed
     */
    public function delete($id) {
    }
}

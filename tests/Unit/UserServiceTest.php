<?php

namespace Tests\Unit;

//use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private $users;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // ダミーデータを作成
        $this->users = factory(\App\Models\User::class, 3)->create();
        /*
        foreach ($this->users as $user) {
            echo '[' . $user->name . ']';
            echo '[' . $user->email . ']';
        }
        */
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        // ダミーデータを削除
        $this->users = null;
    }

    /**
     * 1件取得
     *
     * @return void
     */
    public function testGetUser()
    {
        // 1件取得
        $user = $this->users;

        // リポジトリのモックを作成
        $userRepositoryMock = \Mockery::mock(\App\Repositories\UserRepository::class);
        $userRepositoryMock->shouldReceive('find')->andReturn($user);

        // リポジトリをモックに差し替えてサービスを作成
        $userService = new \App\Services\UserService(
            $userRepositoryMock
        );
        $this->assertEquals($user, $userService->getUser(1));
    }

    /**
     * 検索して取得
     *
     * @return void
     */
    public function testGetUsers()
    {
        // リポジトリのモックを作成
        $userRepositoryMock = \Mockery::mock(\App\Repositories\UserRepository::class);
        $userRepositoryMock->shouldReceive('search')->andReturn($this->users);

        // リポジトリをモックに差し替えてサービスを作成
        $userService = new \App\Services\UserService(
            $userRepositoryMock
        );
        $this->assertEquals($this->users, $userService->getUsers());
    }

    /**
     * 件数を取得
     *
     * @return void
     */
    public function testCountUsers()
    {
        // リポジトリのモックを作成
        $userRepositoryMock = \Mockery::mock(\App\Repositories\UserRepository::class);
        $userRepositoryMock->shouldReceive('count')->andReturn(count($this->users));

        // リポジトリをモックに差し替えてサービスを作成
        $userService = new \App\Services\UserService(
            $userRepositoryMock
        );
        $this->assertEquals(3, $userService->countUsers());
    }

    /**
     * 登録
     *
     * @return void
     */
    public function testStoreUser()
    {
        // リポジトリのモックを作成
        $userRepositoryMock = \Mockery::mock(\App\Repositories\UserRepository::class);
        $userRepositoryMock->shouldReceive('save')->andReturn(new \App\Models\User);

        // リポジトリをモックに差し替えてサービスを作成
        $userService = new \App\Services\UserService(
            $userRepositoryMock
        );
        $postRequest = new \App\Http\Requests\StoreUserRequest();
        $postRequest->merge([
            'name' => 'Taro Yamada',
            'email' => 'taro@example.com',
            'password' => 'abcd1234',
        ]);
        $this->assertInstanceOf('\App\Models\User', $userService->storeUser($postRequest));
    }

    /**
     * 編集
     *
     * @return void
     */
    public function testUpdateUser()
    {
        // リポジトリのモックを作成
        $userRepositoryMock = \Mockery::mock(\App\Repositories\UserRepository::class);
        $userRepositoryMock->shouldReceive('save')->andReturn(new \App\Models\User);

        // リポジトリをモックに差し替えてサービスを作成
        $userService = new \App\Services\UserService(
            $userRepositoryMock
        );
        $postRequest = new \App\Http\Requests\StoreUserRequest();
        $postRequest->merge([
            'name' => 'Taro Yamada',
            'email' => 'taro@example.com',
            'password' => 'abcd1234',
        ]);
        $this->assertInstanceOf('\App\Models\User', $userService->storeUser($postRequest, 1));
    }

    /**
     * 削除
     *
     * @return void
     */
    public function testDeleteUser()
    {
        // リポジトリのモックを作成
        $userRepositoryMock = \Mockery::mock(\App\Repositories\UserRepository::class);
        $userRepositoryMock->shouldReceive('delete')->andReturn(new \App\Models\User);

        // リポジトリをモックに差し替えてサービスを作成
        $userService = new \App\Services\UserService(
            $userRepositoryMock
        );
        $this->assertInstanceOf('\App\Models\User', $userService->deleteUser(1));
    }
}

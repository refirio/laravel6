<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use App\Models\Entry;
use App\Services\EntryService;
use App\Services\CategoryService;
use App\Services\UserService;

class EntryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param  EntryService  $entryService
     * @param  CategoryService  $categoryService
     * @param  UserService  $userService
     * @return void
     */
    public function __construct(
        EntryService $entryService,
        CategoryService $categoryService,
        UserService $userService
    )
    {
        $this->middleware('auth');

        $this->entryService = $entryService;
        $this->categoryService = $categoryService;
        $this->userService = $userService;
    }

    /**
     * Display a list of all entries.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('admin.entry.index', [
            'entries' => $this->entryService->getEntries([], [['id', 'desc']]),
        ]);
    }

    /**
     * Display a form of new entry.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        return view('admin.entry.form', [
            'categories' => $this->categoryService->getCategories(),
            'users' => $this->userService->getUsers(),
        ]);
    }

    /**
     * Create a new entry.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreEntryRequest $request)
    {
        if ($this->entryService->storeEntry($request)) {
            return redirect()->route('admin.entry.index')->with('message', '記事を登録しました。');
        } else {
            return redirect()->route('admin.entry.index')->with('error', '記事を登録できませんでした。');
        }
    }

    /**
     * Display a form of edit entry.
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $entry = $this->entryService->getEntry($id);

        return view('admin.entry.form', [
            'entry' => $entry,
            'entry_categories' => array_column($entry->categories->toArray(), 'id'),
            'categories' => $this->categoryService->getCategories(),
            'users' => $this->userService->getUsers(),
        ]);
    }

    /**
     * Update a entry.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(UpdateEntryRequest $request, $id)
    {
        if ($this->entryService->updateEntry($request, $id)) {
            return redirect()->route('admin.entry.index')->with('message', '記事を編集しました。');
        } else {
            return redirect()->route('admin.entry.index')->with('error', '記事を編集できませんでした。');
        }
    }

    /**
     * Destroy the given entry.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        if ($this->entryService->deleteEntry($id)) {
            return redirect()->route('admin.entry.index')->with('message', '記事を削除しました。');
        } else {
            return redirect()->route('admin.entry.index')->with('error', '記事を削除できませんでした。');
        }
    }
}

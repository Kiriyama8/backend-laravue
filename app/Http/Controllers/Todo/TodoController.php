<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\TodoStoreRequest;
use App\Http\Requests\Todo\TodoTaskStoreRequest;
use App\Http\Requests\Todo\TodoUpdateRequest;
use App\Http\Resources\TodoResource;
use App\Http\Resources\TodoTaskResource;
use App\Models\Todo;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoController extends Controller
{
    /**
     * TodoController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $todos = auth()->user()->todos;

        return TodoResource::collection($todos);
    }

    /**
     * @param Todo $todo
     * @return TodoResource
     * @throws AuthorizationException
     */
    public function show(Todo $todo): TodoResource
    {
        $this->authorize('show', $todo);

        $todo->load('tasks');

        return new TodoResource($todo);
    }

    /**
     * @param TodoStoreRequest $todoStoreRequest
     * @return TodoResource
     */
    public function store(TodoStoreRequest $todoStoreRequest): TodoResource
    {
        $input = $todoStoreRequest->validated();

        $user = auth()->user();

        $todo = $user->todos()->create($input);

        return new TodoResource($todo);
    }

    /**
     * @param Todo $todo
     * @param TodoUpdateRequest $todoUpdateRequest
     * @return TodoResource
     */
    public function update(Todo $todo, TodoUpdateRequest $todoUpdateRequest): TodoResource
    {
        $this->authorize('update', $todo);

        $input = $todoUpdateRequest->validated();

        $todo->fill($input);
        $todo->save();

        return new TodoResource($todo->fresh());
    }

    /**
     * @param Todo $todo
     * @throws Exception
     */
    public function destroy(Todo $todo)
    {
        $this->authorize('destroy', $todo);

        $todo->delete();
    }

    /**
     * @param Todo $todo
     * @param TodoTaskStoreRequest $todoTaskStoreRequest
     * @return TodoTaskResource
     */
    public function createTask(Todo $todo, TodoTaskStoreRequest $todoTaskStoreRequest): TodoTaskResource
    {
        $this->authorize('createTask', $todo);

        $input = $todoTaskStoreRequest->validated();

        $todoTask = $todo->tasks()->create($input);

        return new TodoTaskResource($todoTask);
    }
}

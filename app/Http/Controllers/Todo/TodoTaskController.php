<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\TodoTaskUpdateRequest;
use App\Http\Resources\TodoTaskResource;
use App\Models\TodoTask;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class TodoTaskController extends Controller
{
    /**
     * TodoTaskController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param TodoTask $todoTask
     * @param TodoTaskUpdateRequest $todoTaskUpdateRequest
     * @return TodoTaskResource
     * @throws AuthorizationException
     */
    public function update(TodoTask $todoTask, TodoTaskUpdateRequest $todoTaskUpdateRequest): TodoTaskResource
    {
        $this->authorize('update', $todoTask);

        $input = $todoTaskUpdateRequest->validated();

        $todoTask = $todoTask->fill($input);
        $todoTask->save();

        return new TodoTaskResource($todoTask);
    }

    /**
     * @param TodoTask $todoTask
     * @throws Exception
     */
    public function destroy(TodoTask $todoTask)
    {
        $this->authorize('destroy', $todoTask);

        $todoTask->delete();
    }
}

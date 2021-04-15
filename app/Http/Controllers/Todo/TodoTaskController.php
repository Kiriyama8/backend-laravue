<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\TodoTaskUpdateRequest;
use App\Http\Resources\TodoTaskResource;
use App\Models\TodoTask;
use Exception;
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
     */
    public function update(TodoTask $todoTask, TodoTaskUpdateRequest $todoTaskUpdateRequest): TodoTaskResource
    {
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
        $todoTask->delete();
    }
}

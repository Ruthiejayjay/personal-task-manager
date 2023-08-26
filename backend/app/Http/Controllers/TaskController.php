<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use App\Utils\StringUtils;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(User $user)
    {
        return $user->tasks;
    }

    public function store(StoreTaskRequest $request)
    {
        $task = new Task($request->validated());
        $task->user_id = auth()->id();
        $task->save();
        return response()->json($task, 201);

    }

    public function show(Task $task)
    {
        $task->load('author');
        return $task;
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();
        $task->update($validated);
        return $task;
    }

    public function delete(Task $task)
    {
        $task->delete();
    }
}

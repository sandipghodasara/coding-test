<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Phase;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{

    public function kanban()
    {
        return view('tasks.index');
    }

    /**
     * Display a listing of the Users resource.
     */
    public function statistics()
    {
        return view('statistic.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Phase::query()->withCount('tasks')->with('tasks.user')->get();
    }

    /**
     * Display a listing of the Users resource.
     */
    public function users()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            // Create a new task from the $request
            Task::query()->create($request->validated());
            return new JsonResponse([
                "code" => 200,
                "status" => "success",
                "message" => "Card created successfully.!",
            ]);
        }catch (Exception $exception){
            return new JsonResponse([
                "code" => $exception->getCode(),
                "status" => "fail",
                "message" => $exception->getMessage(),
            ], $exception->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, $taskId)
    {
        try {
            $task = Task::query()->findOrFail($taskId);
            $task->update([
                'name' => $request->name ?? $task->name,
                'phase_id' => $request->phase_id ?? $task->phase_id,
                'user_id' => $request->user_id ?? $task->user_id,
            ]);

            return new JsonResponse([
                "code" => 200,
                "status" => "success",
                "message" => "Card updated successfully.!",
            ]);
        }catch (Exception $exception) {
            return new JsonResponse([
                "code"    => $exception->getCode(),
                "status"  => "fail",
                "message" => $exception->getMessage(),
            ], $exception->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            Task::destroy($task->id);
            return new JsonResponse([
                "code" => 200,
                "status" => "success",
                "message" => "Card deleted successfully.!"
            ]);
        }catch (Exception $exception) {
            return new JsonResponse([
                "code"    => $exception->getCode(),
                "status"  => "fail",
                "message" => $exception->getMessage(),
            ], $exception->getCode());
        }
    }
}

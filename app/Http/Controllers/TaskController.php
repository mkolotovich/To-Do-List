<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->get();
        $statusId = $request->input('filter.status_id');
        $authorId = $request->input('filter.created_by_id');
        $executorId = $request->input('filter.assigned_to_id');
        $statuses = TaskStatus::paginate();
        $users = User::paginate();
        return view(
            'task.index',
            compact('tasks', 'request', 'statuses', 'users', 'statusId', 'authorId', 'executorId')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Task $task)
    {
        Gate::authorize('create', $task);
        $task = new Task();
        $statuses = TaskStatus::paginate();
        $users = User::paginate();
        return view('task.create', compact('task', 'statuses', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:tasks',
            'status_id' => 'required',
            'assigned_to_id' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $task = new Task();
        $task->fill($data);
        $task->created_by_id = $request->user()->id;
        $task->save();
        flash(__('task.created'))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        Gate::authorize('update', $task);
        $statuses = TaskStatus::paginate();
        $users = User::paginate();
        return view('task.edit', compact('task', 'statuses', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title' => "required|unique:tasks,name,{$task->id}",
            'status_id' => 'required',
            'assigned_to_id' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $task->fill($data);
        $task->save();
        flash(__('task.editSuccess'))->success();
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Task $task)
    {
        Gate::authorize('delete', $task);
        $task->delete();
        flash(__('task.remove'))->success();
        return redirect()->route('tasks.index');
    }
}

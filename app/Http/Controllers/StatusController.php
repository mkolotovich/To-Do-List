<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = TaskStatus::all();
        return view('status.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(TaskStatus $taskStatus)
    {
        Gate::authorize('create', $taskStatus);
        $status = new TaskStatus();
        return view('status.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'name' => 'required|unique:task_statuses',
        ], $messages = ['unique' => __('status.createError')]);

        $data = $validator->validated();

        $status = new TaskStatus();
        $status->fill($data);
        $status->save();
        flash(__('status.created'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        Gate::authorize('update', $taskStatus);
        return view('status.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $data = $request->validate([
            'name' => "required|unique:task_statuses,name,{$taskStatus->id}",
        ]);

        $taskStatus->fill($data);
        $taskStatus->save();
        flash(__('status.editSuccess'))->success();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        Gate::authorize('delete', $taskStatus);
        $taskExists = Task::where('status_id', $taskStatus->id)->exists();
        if ($taskExists) {
            flash(__('status.error'))->error();
            return redirect()->route('task_statuses.index');
        }
        $taskStatus->delete();
        flash(__('status.removed'))->success();
        return redirect()->route('task_statuses.index');
    }
}

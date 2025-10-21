<div>
    {{  html()->label(__('layout.name'), 'name') }}
</div>
<div class="mt-2">
    {{  html()->input('text', 'title')->class('rounded border-gray-300 w-1/3') }}
</div>
@error('title')
    <div class="text-rose-600">{{ $message }}</div>
@enderror
<div class="mt-2">
    {{  html()->label(__('task.description'), 'description') }}
</div>
<div>
    {{  html()->textarea('description')->class('rounded border-gray-300 w-1/3 h-32') }}
</div>
<div class="mt-2">
    {{  html()->label(__('task.status'), 'status_id') }}
</div>
<div>
    <select class="rounded border-gray-300 w-1/3" name="status_id" id="status_id">
        @if (!$task->status_id)
            <option value=""></option>
        @endif
        @foreach ($statuses as $status)
            @if ($task->status_id === $status->id)
                <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
            @else
                <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endif
        @endforeach
    </select>
</div>
@error('status_id')
    <div class="text-rose-600">{{ $message }}</div>
@enderror
<div class="mt-2">
    {{  html()->label(__('task.executor'), 'status_id') }}
</div>
<div>
    <select class="rounded border-gray-300 w-1/3" name="assigned_to_id" id="assigned_to_id">
        <option value=""></option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
</div>
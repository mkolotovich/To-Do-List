<x-app-layout>
    <h1 class="mb-5">{{__('task.tasks')}}</h1>
    <div class="w-full flex items-center">
        <div>
            {{ html()->modelForm($tasks, 'GET', route('tasks.index'))->open() }}
                <div class="flex">
                    <select class="rounded border-gray-300" name="filter[status_id]" id="filter[status_id]">
                        <option value>{{__('task.status')}}</option>
                        @foreach ($statuses as $status)
                            @if ($status->id == $statusId)
                                <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                            @else
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <select class="rounded border-gray-300" name="filter[created_by_id]" id="filter[created_by_id]">
                        <option value>{{__('task.author')}}</option>
                        @foreach ($users as $user)
                            @if ($user->id == $authorId)
                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                            @else
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <select class="rounded border-gray-300" name="filter[assigned_to_id]" id="filter[assigned_to_id]">
                        <option value>{{__('task.executor')}}</option>
                        @foreach ($users as $user)
                            @if ($user->id == $executorId)
                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                            @else
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    {{ html()->submit(__('task.apply'))->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2') }}
                </div>
            {{ html()->closeModelForm() }}
        </div>
        @if (Auth::user())
            <div class="ml-auto">
                <a href="{{route('tasks.create')}}" class="btn btn-primary me-1">{{__('task.create')}}</a>
            </div>
        @endif
    </div>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>{{__('status.id')}}</th>
                <th>{{__('task.status')}}</th>
                <th>{{__('status.name')}}</th>
                <th>{{__('task.author')}}</th>
                <th>{{__('task.executor')}}</th>
                <th>{{__('status.createdAt')}}</th>
                @if (Auth::user())
                    <th>{{__('status.actions')}}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{$task->id }}</td>
                    <td>{{$task->status->name }}</td>
                    <td>
                        <a href="{{route('tasks.show', $task->id)}}">{{$task->title}}</a>
                    </td>
                    <td>{{$task->author->name}}</td>
                    <td>{{$task->executor === null ? '' : $task->executor->name}}</td>
                    <td>{{$task->created_at->settings(['toStringFormat' => 'd.m.Y'])}}</td>
                    <td class="d-flex">
                        @can('update', $task)
                            <a href="{{route('tasks.edit', $task->id)}}" class="btn btn-primary me-1">{{__('status.edit')}}</a>
                        @endcan
                        @can('delete', $task)
                            <a href="{{route('tasks.destroy', $task->id)}}" data-confirm="{{__('layout.confirm')}}?" data-method="delete" rel="nofollow">{{__('status.remove')}}</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
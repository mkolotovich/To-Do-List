<x-app-layout>
    <h2 class="mb-5">{{__('task.view')}}: {{$task->name}}
        <a href="{{route('tasks.edit', $task->id)}}">⚙</a>
    </h2>
    <p>
        <span>{{__('status.name')}}:</span>
        {{$task->title}}
    </p>
    <p>
        <span>{{__('task.status')}}:</span>
        {{$task->status->name}}
    </p>
    <p>
        <span>{{__('task.description')}}:</span>
        {{$task->description}}
    </p>
</x-app-layout>
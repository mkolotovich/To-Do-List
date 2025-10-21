<x-app-layout>
    <h1>{{__('task.edit')}}</h1>
    {{ html()->modelForm($task, 'PATCH', route('tasks.update', $task))->open() }}
        @include('task.form')
        <div class="mt-2">
            {{ html()->submit(__('layout.update'))->class('btn btn-primary') }}
        </div>
    {{ html()->closeModelForm() }}
</x-app-layout>
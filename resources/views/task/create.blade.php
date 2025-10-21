<x-app-layout>
    <h1>{{__('task.create')}}</h1>
    {{ html()->modelForm($task, 'POST', route('tasks.store'))->open() }}
        @include('task.form')
        <div class="mt-2">
            {{ html()->submit(__('status.new'))->class('btn btn-primary') }}
        </div>
    {{ html()->closeModelForm() }}
</x-app-layout>
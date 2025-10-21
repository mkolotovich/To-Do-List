<x-app-layout>
    <h1>{{__('status.editStatus')}}</h1>
    {{ html()->modelForm($taskStatus, 'PATCH', route('task_statuses.update', $taskStatus))->open() }}
        @include('status.form')
        <div class="mt-2">
            {{ html()->submit(__('layout.update'))->class('btn btn-primary') }}
        </div>
    {{ html()->closeModelForm() }}
</x-app-layout>
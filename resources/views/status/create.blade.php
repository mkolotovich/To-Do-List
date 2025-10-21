<x-app-layout>
    <h1>{{__('status.create')}}</h1>
    {{ html()->modelForm($status, 'POST', route('task_statuses.store'))->open() }}
        @include('status.form')
        <div class="mt-2">
            {{ html()->submit(__('status.new'))->class('btn btn-primary') }}
        </div>
    {{ html()->closeModelForm() }}
</x-app-layout>
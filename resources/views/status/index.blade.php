<x-app-layout>
    <h1 class="mb-5">{{__('status.statuses')}}</h1>
        <div>
            @if (Auth::user())
                <a href="{{route('task_statuses.create')}}" class="btn btn-primary me-1">{{__('status.create')}}</a>
            @endif
        </div>
        <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>{{__('status.id')}}</th>
                <th>{{__('status.name')}}</th>
                <th>{{__('status.createdAt')}}</th>
                @if (Auth::user())
                    <th>{{__('status.actions')}}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
                <tr>
                    <td>{{$status->id }}</td>
                    <td>{{$status->name}}</td>
                    <td>{{$status->created_at }}</td>
                    @if (Auth::user())
                        <td class="d-flex">
                            <a href="{{route('task_statuses.edit', $status->id)}}" class="btn btn-primary me-1">{{__('status.edit')}}</a>
                            <a href="{{route('task_statuses.destroy', $status->id)}}" data-confirm="{{__('layout.confirm')}}?" data-method="delete" rel="nofollow">{{__('status.remove')}}</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
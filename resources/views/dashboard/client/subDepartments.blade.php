<ul class="tree">
    @foreach ($subDepartments as $department)
         <li ondblclick="ShowRespondents('{{ $department->id }}')">
            @if($department->subDepartments->count()>0)

        <details>
            <summary><span class="m-1 p-1 bg-success"> {{ $department->name_en }} <i class="fa fa-user-plus"></i></span></summary>
            @include('dashboard.client.subDepartments',['subDepartments'=>$department->subDepartments])
        </details>
        @else
        <span class="m-1 p-1 bg-success"> {{ $department->name_en }} <i class="fa fa-user-plus"></i></span>
        @endif
    </li>
    @endforeach
    <li><a href="javascript:void(0)" class="btn btn-sm btn-info">{{ __('Add Sub-Department') }}</a></li>
</ul>

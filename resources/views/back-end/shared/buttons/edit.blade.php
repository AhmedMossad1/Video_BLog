{{-- <a href="{{ route($routeName.'.edit' , ['id' => $row]) }}" rel="tooltip" title="" class="btn btn-white btn-link btn-sm" data-original-title="Edit {{ $sModuleName }}">
</a> --}}

<a href="{{ route($routeName.'.edit' , [ $row->id]) }}" rel="tooltip"  class="btn btn-white btn-link btn-sm" data-original-title="Edit {{ $sModuleName }}">
    <i class="material-icons">edit</i>
    </a>

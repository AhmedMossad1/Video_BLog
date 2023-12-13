
<form action="{{ route($routeName.'.destroy' ,[$row->id])}}" method="POST">
    {{ csrf_field()}}
    @method('DELETE')
    {{-- {{method_field('delete')}} --}}
    <button type="submit" rel="tooltip" title="" class="btn btn-white btn-link btn-sm" data-original-title="Remove  {{ $sModuleName }}">
    <i class="material-icons">close</i>
    </button>
</form>
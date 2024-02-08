<form class="form-inline ml-auto" style="margin-top: 15px" action="{{ route($routeName.'.index') }}">
    <div class="form-group has-white">
        <input type="text" name="search" class="form-control" placeholder="Search">
    </div>
</form>
@if (request()->has('search') && request()->get('search') != '')
Search Result : <b>{{request()->get('search')}} </b> | <a href="{{ route($routeName.'.index') }}">Rest</a>
@endif

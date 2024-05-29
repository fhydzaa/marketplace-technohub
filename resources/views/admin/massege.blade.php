@if(Session::has('error'))

<div>
     {{ Session::get('error') }}
</div>
@endif

@if(Session::has('success'))
<div>
    {{ Session::get('success') }}
</div>
@endif
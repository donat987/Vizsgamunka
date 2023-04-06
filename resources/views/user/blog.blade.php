@extends('layouts.user')
@section('content')
<div class="container container__blog">
    {!!$sql[0]->news!!}
</div>

@endsection

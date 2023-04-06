@extends('layouts.user')
@section('content')

<div class="container container__blog">
    @foreach ($sql as $sor)
    <div class="card__blog">
        <a href="/blog/{{$sor->link}}" class="text-body">
        <div class="card__header">
            <img src="{{$sor->file}}" alt="card__image" class="card__image" width="600">
        </div>
        <div class="card__body">
            <h5>{{$sor->name}}</h5>
            <p>{{$sor->summary}}</p>
        </div>
    </a>
    </div>
    @endforeach
</div>

@endsection

@extends('layouts.user')
@section('content')
<div class="container container__blog">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <img width="50px" src="{{$sql->file}}" class="rounded-circle mr-3">
                <div>
                    <h5 class="mb-0">{{$sql->lastname}} {{$sql->firstname}}</h5>
                    <small class="text-muted">Dátum: {{$sql->date}}</small>
                </div>
            </div>
            <h2 class="my-4">{{$sql->name}}</h2>
            <h4 class="my-4">{{$sql->summary}}</h4>
            {!!$sql->news!!}
        </div>

    </div>

</div>
@if (count($comment))
        <div class="container my-5">
            <h2 class="text-center">Eddigi értékelések:</h2>
            @foreach ($comment as $s)
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <img width="50px" src="{{ $s->file }}" class="rounded-circle mr-3">
                            <div>
                                <h5 class="mb-0">{{ $s->username }}</h5>
                                <small class="text-muted">Dátum: {{ $s->date }}.</small>
                            </div>
                            <div class="ml-auto">
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $s->comment }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
<div class="container my-5">
    <h2 class="text-center">Kommentelj!</h2>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('blogcomment') }}" method="POST">
        @csrf
        <input type="hidden" name="blogid" value="{{ $sql->id }}">
        <div class="form-group">
            <textarea class="form-control" name="comment" id="comment" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Beküldés</button>
    </form>
</div>

@endsection

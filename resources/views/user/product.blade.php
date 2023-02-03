@extends('layouts.user')
@section('content')
    </div>
    <form method='post' action='cart.php?action=add&id=3&quantity=1'>
        <div class='site-section mt-5'>
            <div class='container'>
                <div class='row'>
                    <div class='col-lg-6'> <img src='{{$pro[0]->file}}' alt='Image' class='img-fluid'>
                    </div>
                    <div class='col-lg-5 ml-auto'>
                        <h2 class='text-primary'>{{$pro[0]->name}}</h2>
                        <h2 class='text-primary'>{{$pro[0]->price}} ft</h2>
                        <p>Márka: Agárdi Pálinka</p>
                        <p>Gyümölcs: Birs</p>
                        <p>Mennyiség: 0.5 l.</p>
                        <p>{{$pro[0]->description}}</p>
                        <p><input name='quantity' type='submit' value='Kosárba'
                                class='btn btn-outline-dark  btn-lg btn-block' /></p>

                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

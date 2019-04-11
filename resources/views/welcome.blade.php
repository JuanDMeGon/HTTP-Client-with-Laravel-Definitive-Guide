@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h2 class="display-2">Products</h2>
        </div>
    </div>
    <div class="row">
        @foreach($products as $product)
            <div class="col-4">
                <div class="card">
                    <img src="{{$product->picture}}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{$product->title}}</h5>
                        <p class="card-text">{{$product->details}}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

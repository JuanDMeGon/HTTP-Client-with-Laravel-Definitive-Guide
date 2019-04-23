@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <h2 class="display-2">Purchases</h2>
                </div>
            </div>
            <div class="row">
                @foreach($publications as $publication)
                    <div class="col-4">
                        <a href="{{route('products.show', ['title' => $publication->title, 'id' => $publication->identifier])}}">
                            <div class="card">
                                <img src="{{$publication->picture}}" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">{{$publication->title}} ({{$publication->stock}})</h5>
                                    <p class="card-text">{{$publication->details}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

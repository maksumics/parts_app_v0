@extends('welcome')

@section('main')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-fluid">
<div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box">
<form method="POST" action="/categories/addsub/{{$id}}">
    @csrf
    <input type="text" name="title" />
    <input type="submit" value="Potvrdi!" />
</form>
</div>
</div>
</div>
</div>
@endsection
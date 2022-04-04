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
<form method="post" action="{{ route('categories.store') }}">

    @csrf
    <div class="form-group">
        <label class="col-md-4 text-right">Naziv</label>
        <div class="col-md-8"><input type="text" name="title" class="form-control input-lg" /></div>
    </div>

    <div class="form-group text-center">
        <input type="submit" name="add" class="btn btn-primary input-lg" value="Dodaj"/>
    </div>

</form>
</div>
</div>
</div>
</div>
@endsection
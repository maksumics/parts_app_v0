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
<form method="post" action="{{ route('items.store') }}" enctype="multipart/form-data">

@csrf
<div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
<div class="form-group">
    <label class="col-md-4 text-right">Kategorija</label>
    <div class="col-md-8">
    <select name="categories_list" class="form-select form-select-lg"  id="categories_list">
    <option value="" disabled selected>Odaberite kategoriju</option>
        @foreach ($cats as $cat)
        <optgroup label="{{$cat->title}}">
            @foreach ($cat->subcategories()->get() as $sub)
            <option value="{{$sub->id}}">{{$sub->title}}</option>
            @endforeach
        </optgroup>
        @endforeach
    </select>
</div> 
</div>
<div class="form-group">
    <label class="col-md-4 text-right">Vozilo</label>
    <div class="col-md-8">
    <select name="cars_list"  class="form-select form-select-lg" id="cars_list">
    <option value="" disabled selected>Odaberite vozilo</option>
        @foreach ($brnds as $brnd)
        <optgroup label="{{$brnd->title}}">
            @foreach ($brnd->cars()->get() as $car)
            <option value="{{$car->id}}">{{$car->title}}</option>
            @endforeach
        </optgroup>
        @endforeach
    </select>
</div> 
</div>
</div>
</div>
</div>
<div class="form-group">
    <label class="col-md-4 text-right">Naziv artikla</label>
    <div class="col-md-8"><input type="text" class="form-control input-lg" name="title" /></div>
</div>
<div class="form-group">
    <label class="col-md-4 text-right">Opis artikla</label>
    <div class="col-md-8"><input type="text" class="form-control input-lg" name="details" /></div>
</div>
<div class="form-group">
    <label class="col-md-4 text-right">Cijena</label>
    <div class="col-md-8"><input type="number" step="0.01" class="form-control input-lg" name="price" /></div> 
</div>
<div class="form-group">
    <label class="col-md-4 text-right">Kolicina</label>
    <div class="col-md-8"><input type="number" step="1" value="1" class="form-control input-lg" name="amount" /></div> 
</div>
<div class="form-group">
    <label class="col-md-4 text-right">Slike</label>
    <div class="col-md-8"><input type="file" name="images[]" multiple/></div> 
</div>
<div class="form-group text-center">
    <input type="submit" name="add" class="btn btn-primary input-lg" value="Unesi" />
</div>
</form>
</div>
</div>
</div>
<div>


@if (session('newCode'))
    <div class="alert alert-success">
        {{ session('newCode') }}
    </div>
    <script>
        $(document).ready(function() { 
                alert("{{session('newCode')}}");
        });
    </script>
@endif
@endsection
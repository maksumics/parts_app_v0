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
<form method="post" action="{{ route('items.update', $item->id) }}" enctype="multipart/form-data">
<input type="hidden" name="_method" value="put" />
@csrf
<div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
<div class="form-group">
    <label class="col-md-4 text-right">Kategorija</label>
    <div class="col-md-8">
    <select name="subcategory_list" class="form-select form-select-lg"  id="subcategory_list">
    <option value="" disabled selected>Odaberite kategoriju</option>
        @foreach ($cats as $cat)
        <optgroup label="{{$cat->title}}">
            @foreach ($cat->subcategories()->get() as $sub)
            <option value="{{$sub->id}}" {{($sub->id == $item->subcategory->id) ? 'selected' : ''}}>{{$sub->title}}</option>
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
            <option value="{{$car->id}}" {{($car->id == $item->car->id) ? 'selected' : ''}}>{{$car->title}}</option>
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
    <div class="col-md-8"><input type="text" class="form-control input-lg" value="{{$item->title}}" name="title" /></div>
</div>
<div class="form-group">
    <label class="col-md-4 text-right">Opis artikla</label>
    <div class="col-md-8"><input type="text" class="form-control input-lg" value="{{$item->details}}" name="details" /></div>
</div>
<div class="form-group">
    <label class="col-md-4 text-right">Cijena</label>
    <div class="col-md-8"><input type="number" step="0.01" value="{{$item->price}}" class="form-control input-lg" name="price" /></div> 
</div>
<div class="form-group">
    <label class="col-md-4 text-right">Kolicina</label>
    <div class="col-md-8"><input type="number" step="1" class="form-control input-lg" value="{{$item->amount}}" name="amount" /></div> 
</div>
<div class="form-group">
    
    <table>
        <thead>
            <th>Slika</th>
            <th></th>
        </thead>
        <tbody>
            @foreach($item->pictures()->get() as $pic)
                <tr>
                    <td><img src="/images/{{$pic->title}}" width="250px" height="250px"/></td>
                    <td><input onclick="pictureDelete({{$pic->id}})" class="btn btn-danger" value="Brisi" /></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="form-group">
    <label class="col-md-4 text-right">Slike</label>
    <div class="col-md-8"><input type="file" name="images[]" multiple/></div> 
</div>
<div class="form-group text-center">
    <input type="submit" name="add" class="btn btn-primary input-lg" value="Spasi izmjene" />
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



<script>
        function pictureDelete(id){
            $.ajax({
                url: '/pictures/remove/'+id,
                type: 'GET',
                success: function(result) {
                    location.reload();
                },
                error: function(html){
                    alert(html);
                }
            });
        }
</script>

@endsection
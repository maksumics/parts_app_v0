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

@if($id>0)


<div class="container-fluid">
<div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box">
<form method ="POST" action="{{route('cars.update', $brand->id)}}">
    @csrf
    <input type="hidden" name="_method" value="put" />
<div class="form-group">
        <label class="col-md-4 text-right">Naziv</label>
        <div class="col-md-8"><input type="text" value="{{$brand->title}}" name="title" class="form-control w-25 input-lg" /></div>
    </div>
    <div class="form-group text-left">
        <input type="submit" value="Potvrdi!" class="btn btn-primary input-lg" />
    </div>
    </form>
    <table class="table text-nowrap">
        <thead>
            <tr>
                <th>Naziv</th>
                <th>Brisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brand->cars()->get() as $car)
            <tr>
                <td>{{$car->title}}</td>
                <td><a href="" class="btn btn-primary input-lg">Brisi!</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
<div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box">
<form method="POST" action="/cars/addmodel/{{$id}}">
    @csrf
    <div class="form-group">
        <label class="col-md-4 text-right">Naziv</label>
        <div class="col-md-8"><input type="text" name="title" class="form-control w-25 input-lg" /></div>
    </div>
    <div class="form-group text-left">
        <input type="submit" value="Potvrdi!" class="btn btn-primary input-lg" />
    </div>
</form>
</div>
</div>
</div>
</div>
@endif
@endsection
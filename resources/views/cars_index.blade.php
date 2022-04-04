@extends('welcome')

@section('main')
<div class="container-fluid">
<div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box">
                        <div class="table-responsive">                            
<table class="table text-nowrap">
    <tr>
        <th>Naziv</th>
        <th><a href="{{route('cars.create')}}">Dodaj marku!</a></th>
    </tr>
    @foreach($data as $brand)
    <tr>
        <td>{{$brand->title}}</td>
        <td><a href="{{route('cars.edit', $brand->id)}}">Dodaj model!</a></td>
    </tr>
    @endforeach


</table>
</div>
</div>
</div>
</div>
</div>
@endsection
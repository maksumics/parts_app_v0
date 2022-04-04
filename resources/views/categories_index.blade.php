@extends('welcome')

@section('main')
<div class="container-fluid">
<div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="white-box">
                        <div class="table-responsive">                            
<table class="table text-nowrap">
    <tr>
        <th> Naziv </th>
        <th> <a href="{{ route('categories.create') }}">Dodaj novu</a> </th>
    </tr>
    @foreach($data as $cat)
    <tr>
        <td>{{ $cat->title }}</td>
        <td><a href = "{{ route('categories.edit', $cat->id) }}">Dodaj potkategoriju!</a></td>
    </tr>
    @endforeach
</table>
</div>
</div>
</div>
</div>
</div>
@endsection
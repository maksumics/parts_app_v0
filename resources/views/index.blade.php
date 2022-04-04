@extends('welcome')

@section('main')

<div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <form method="get" action="{{ route('items.index') }}" id="searchSelectForm">
                                <select id="subcategory_list" class="form-select form-select-lg  m-3" style="display: inline-block" name="subcategory_list">
                                    <option value="" disabled selected>Odaberite kategoriju</option>
                                    @foreach($cats as $cat)
                                    <optgroup label="{{$cat->title}}">
                                    @foreach($cat->subcategories()->get() as $sub)
                                        <option value="{{$sub->id}}">{{$sub->title}}</option>
                                    @endforeach
                                    </optgroup>
                                    @endforeach
<                                  </select>


                                <select name="car_list" class="form-select form-select-lg  m-3" style="display: inline-block" id="car_list">
                                    <option value="" disabled selected>Odaberite vozilo!</option>
                                    @foreach($brands as $brnd)
                                    <optgroup label="{{$brnd->title}}">
                                    @foreach($brnd->cars()->get() as $car)
                                        <option value="{{$car->id}}">{{$car->title}}</option>
                                    @endforeach
                                    </optgroup>
                                    @endforeach
                                </select>
                                <input type="submit" value="Pretraga" class="btn btn-primary m-3" />
                            </form>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><input type="text"  class="fw-normal" id="codeSearch" name="codeSearch" placeholder="Unesite kod!"/></li>
                            </ol>
                            <button onClick="openArticle()"
                                id="searchButton" class="btn btn-danger  d-none d-md-block pull-right ms-3 hidden-xs hidden-sm waves-effect waves-light text-white">Pretraga...</button>
                        </div>
                    </div>
                </div>
</div>



<div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                        @if($data)
                        @if(count($data)>0)
                                <h3 class="box-title">Rezultati pretrage <i>{{$data[0]->subcategory->title}}</i> za vozilo <i>{{$data[0]->car->brand->title}} {{$data[0]->car->title}}</i></h3>
                                <p class="text-muted">Pronađeno artikala : {{count($data)}}</p>
                                @else
                                <h3 class="box-title">Nema rezultata za pretragu, pokušajte pretragu za sličan model?</h3>
                            @endif
                            @endif 
                            <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                <tr>
                                    <th class="border-top-0">Naziv</th>
                                    <th class="border-top-0">Kod</th>
                                    <th class="border-top-0">Cijena</th>
                                    <th class="border-top-0">Količina</th>
                                    <th class="border-top-0"></th>
                                    <th class="border-top-0"></th>
                                </tr>
                                <thead>
                                    <tbody>
                                    @if($data)
                            @if(count($data)>0)
                            @foreach ($data as $item)
                                <tr {{$item->amount==0 ? 'bgcolor=#ff8080' : ""}}>
                                    <td class="text-oflo">{{$item->title}}</td>
                                    <td class="text-oflo">{{$item->code}}</td>
                                    <td class="text-oflo">{{$item->price}} KM</td>
                                    <td class="text-oflo">{{$item->amount}}</td>
                                    <td><a  href="#" onClick="showDetails({{$item->id}})">Pregledaj</a></td>
                                    <td><a  href="{{route('items.edit', $item->id)}}">Uredi</a></td>
                                </tr>
                            @endforeach
                            @endif
                            @endif
                            </tbody>
                            </table>
                            @if($data)
                            @if(count($data)>0)
                            {{ $data->appends(request()->input())->links(); }}
                            @endif
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>



<div class="modal fade" tabindex="-1" id="itemDetails" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close"  onclick="closeModal()" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-item-code"></h4>
      </div>
      <div class="modal-body">
          <span>Inofmacije o artiklu:</span>
        <p class="modal-item-details">Modal body text goes here.</p>
        <span class="card-price"></span>
        <span id="itemIdHidden" hidden></span>
        <span class="modal-item-amount"></span>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only"></span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only"></span>
            </a>
        </div>
        <div class="item-images" style="width: 25%; height:25%"></div>
      </div>
      <div class="modal-footer">
        <button type="button" id="sellButton" onclick="sellItem()" class="btn btn-primary">Prodaja</button>
        <button type="button" class="btn btn-secondary" onclick="closeModal()" data-dismiss="modal">Zatvori</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" id="infoModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="info-modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="info-modal-body">
          
        </div>
      </div>
      <div class="info-modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<script>
    
   function showDetails(id){
    $('.info-modal-body').html('');
        $('.info-modal-title').html('');
        $('.modal-item-code').html('');
        $('.card-price').html('');
        $('#itemIdHidden').html('');
        $('.carousel-inner').html('');
        $.ajax({
            url: 'items/'+id,
            success: function(html){
                $('.modal-title').html(html.data.title);
                $('.modal-item-details').html(html.data.details);
                $('.modal-item-code').html(html.data.code);
                $('.card-price').html(html.data.price+' KM');
                $('#itemIdHidden').html(html.data.id);
                for(var i = 0; i < html.images.length; i++)
                {
                    $str = "<img src='/storage/images/"+html.images[i].title+"' style='width: 90%; height:90%'/>";
                    if(i==0)
                        $('.carousel-inner').append("<div class='carousel-item active'> <img class='d-block w-100' src='images/"+html.images[i].title+"'/></div>");
                    else
                        $('.carousel-inner').append("<div class='carousel-item'> <img class='d-block w-100' src='images/"+html.images[i].title+"'/></div>");
                }
                if(html.data.amount==0){
                    document.getElementById("sellButton").disabled = true;
                    $('#sellButton').html('Nema na stanju');
                }
                $('#itemDetails').modal('show');
            },
            error: function(){
                alert('Prikaz detalja nije moguć!');
            }
        });
        
   }

   function sellItem(){
       var id = $('#itemIdHidden').html();
       $.ajax({
            url: 'items/sellItem/'+id,
            success: function(html){
                if(html.status =="ok")
                    location.reload();
                else
                    alert('nije ok')
            },
            error: function()
            {

            }
       });
   }

   function openArticle(){
        $('.info-modal-body').html('');
        $('.info-modal-title').html('');
        $('.modal-item-code').html('');
        $('.card-price').html('');
        $('#itemIdHidden').html('');
        $('.carousel-inner').html('');
        var code = $("#codeSearch").val()
        if(code){
            $('.modal-title').html('');
            $('.carousel-inner').html('');
            $.ajax({
                url: 'items/showByCode/'+code,
                success: function(html){
                    $('.modal-title').html(html.data.title);
                    $('.modal-item-details').html(html.data.details);
                    $('.modal-item-code').html(html.data.code);
                    $('.card-price').html(html.data.price+' KM');
                    $('#itemIdHidden').html(html.data.id);
                    for(var i = 0; i < html.images.length; i++)
                    {
                        $str = "<img src='/storage/images/"+html.images[i].title+"' style='width: 90%; height:90%'/>";
                        if(i==0)
                            $('.carousel-inner').append("<div class='carousel-item active'> <img class='d-block w-100' src='images/"+html.images[i].title+"'/></div>");
                        else
                            $('.carousel-inner').append("<div class='carousel-item'> <img class='d-block w-100' src='images/"+html.images[i].title+"'/></div>");
                    }
                    if(html.data.amount==0){
                        document.getElementById("sellButton").disabled = true;
                        $('#sellButton').html('Nema na stanju');
                    }
                    $('#itemDetails').modal('show');
                },
                error: function(){
                    alert('Prikaz detalja nije moguć!');
                }
        });
        }
        else{
            $('.info-modal-title').html('Greska');
            $('.info-modal-body').html('Unesite kod!');
            $('#infoModal').modal('show');
        }
   }


   function closeModal(){
    $('#itemDetails').modal('hide');
   }

   $("#codeSearch").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#searchButton").click();
    }

    function sellItem(){
       var id = $('#itemIdHidden').html();
       $.ajax({
            url: 'items/sellItem/'+id,
            success: function(html){
                if(html.status =="ok")
                    location.reload();
                else
                    alert('nije ok')
            },
            error: function()
            {

            }
       });
   }
});
</script>

@endsection
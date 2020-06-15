@extends('layouts.app')
@section('content')
    <form method="post">
        <div class="form-group">
            <fieldset>
                <legend>Aggiungi Criteri di Ricerca</legend>
                <input type="text" name="rooms" placeholder="Numero Minimo di Stanze">
                <input type="text" name="beds" placeholder="Numero Minimo di Posti Letto">
                <input type="text" name="radius" placeholder="Modifica raggio di ricerca">
                <input type="checkbox" id="wifi" name="services[]" value="wifi">
                <label for="wifi">wi-fi</label>
                <input type="checkbox" id="posto-auto" name="services[]" value="posto auto">
                <label for="posto-auto">posto auto</label>
                <input type="checkbox" id="piscina" name="services[]" value="piscina">
                <label for="piscina">piscina</label>
                <input type="checkbox" id="sauna" name="services[]" value="sauna">
                <label for="sauna">sauna</label>
                <input type="checkbox" id="vista-mare" name="services[]" value="vista mare">
                <label for="vista-mare">vista mare</label>
                <input type="checkbox" id="reception" name="services[]" value="portineria">
                <label for="reception">portineria</label>
                <button class="btn btn-primary m-3" type="submit">Vai</button>
            </fieldset>
        </div>
    </form>
    @foreach ($sponsoredApartments as $sponsored)
        <div>
            <h2>{{$sponsored->title}}</h2>
            <img src="{{asset('storage/'. $sponsored->main_img)}}" alt="{{$sponsored->title}}">
        </div>
    @endforeach
    @foreach ($filteredApartments as $filtered)
        <div>
            <h4>{{$filtered->title}}</h4>
            <img src="{{asset('storage/'. $filtered->main_img)}}" alt="{{$filtered->title}}">
        </div>
    @endforeach
@endsection

@extends('app')
@section('title')
    Контакты

@endsection
@section('content')

    <!-- Task manager table -->
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">Отчет по компаниям ({{date('d-m-Y',strtotime($min_date))}}-{{date('d-m-Y',strtotime($max_date))}} ) </h6>

        </div>

        <table class="table tasks-list table-lg">
            <thead>
            <tr>

                <th>Id Компании</th>
                <th>Название Компании </th>
                <th>Клики </th>
                <th>Расход </th>
                <th>Дата </th>




            </tr>
            </thead>
            <tbody>{{-- 'CampaignId',
               'CampaignName',
               'Clicks',
               'Cost',
               'Date',--}}
            @foreach($results as $client) <tr   >
                <td>{{$client->CampaignId}} </td>
                <td>{{$client->CampaignName}} </td>
                <td>{{$client->Clicks}} </td>
                <td>{{$client->Cost}} </td>
                <td>{{date('d-m-Y',strtotime($client->Date))}} </td>



            </tr>
            @endforeach

























            </tbody>
        </table>
    </div>
    <!-- /task manager table -->

    <!-- /footer -->









@endsection

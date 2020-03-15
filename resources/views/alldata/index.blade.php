@extends('app')
@section('title')
    Дополнительные поля

@endsection
@section('content')
    <div class="row">
        <div class="page-title col-md-6" style="padding: 10px">
            <h1><a href="/"><i class="icon-arrow-left52 position-left"></i></a><span class="text-semibold">Данные</span></h1>

        </div><div class="col-md-6"></div>



    </div>

    <!-- Task manager table -->
    <div class="panel panel-white">
        <div class="panel-heading">
            <h2 class="panel-title">Данные</h2>
            <div class="heading-elements">


            </div>
        </div>
<div class="table-responsive">
        <table class="table table-bordered" id="users-table">
            <thead>
            <tr>
                <th>Id</th>
                <th>Фио</th>
                <th>Телефон</th>
                <th>E-mail</th>
                <th>Визит</th>
                <th>Страниц</th>
                <th>Урл</th>



                <th>WName</th>
                <th>Created At</th>
                <th>mcep</th>
                <th>mctyp</th>
                <th>mccmp</th>
                <th>mccnt</th>
                <th>mctrim</th>
                <th>mcolev_phone_track</th>
                <th>mcip</th>
                <th>utm_source</th>
                <th>mcregion</th>
                {{----}}
              {{--  <th>mffd</th>
                <th>mfep</th>
                <th>mftyp</th>
                <th>mfsrc</th>
                <th>mfmdm</th>
                <th>mfcnt</th>--}}



{{--    ,'metrika_first.fd as mffd'
             ,'metrika_first.ep as mfep'
             ,'metrika_first.typ as mftyp'
             ,'metrika_first.src as mfsrc'
             ,'metrika_first.mdm as mfmdm'
             ,'metrika_first.cnt as mfcnt' --}}
            </tr>
            </thead>
        </table>
    </div>    </div>
    <!-- /task manager table -->

    <!-- /footer -->









@endsection

@section('skriptdop')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/alldata/data',
                columns: [
                    { data: 'pid', name: 'pid' },
                    { data: 'pfio', name: 'pfio' },
                    { data: 'pphone', name: 'pphone' },
                    { data: 'pemail', name: 'pemail' },
                    { data: 'pvst', name: 'pvst' },
                    { data: 'ppgs', name: 'ppgs' },
                    { data: 'purl', name: 'url' },


                    { data: 'wname', name: 'wname' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'mcep', name: 'mcep' },
                    { data: 'mctyp', name: 'mctyp' },
                    { data: 'mccmp', name: 'mccmp' },
                    { data: 'mccnt', name: 'mccnt' },
                    { data: 'mctrim', name: 'mctrim' },
                    { data: 'mcolev_phone_track', name: 'mcolev_phone_track' },
                    { data: 'mcip', name: 'mcip' },
                    { data: 'mcutm_source', name: 'mcutm_source' },
                    { data: 'mcregion', name: 'mcregion' },

                   /* { data: 'mffd', name: 'mffd' },
                    { data: 'mfep', name: 'mfep' },
                    { data: 'mftyp', name: 'mftyp' },
                    { data: 'mfsrc', name: 'mfsrc' },
                    { data: 'mfmdm', name: 'mfmdm' },
                    { data: 'mfcnt', name: 'mfcnt' },
*/



                    /*  <th>mffd</th>
                <th>mfep</th>
                <th>mftyp</th>
                <th>mfsrc</th>
                <th>mfmdm</th>
                <th>mfcnt</th>

*/
                ]
            });
        });
    </script>

@endsection

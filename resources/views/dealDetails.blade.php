@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {!! $deal['title'] !!}
                    </div>
                    <div class="panel-body" id="deal-panel-body">
                        <div class="row" id="deal-first-row">
                            <div class="col-sm-2">{!! $deal['formatted_value'] !!}</div>
                            <div class="col-sm-2"><i class="glyphicon glyphicon-briefcase"></i>{!! $deal['org_name'] !!}</div>
                            <div class="col-sm-2 col-sm-offset-6 text-right">{!! $deal['owner_name'] !!}</div>
                        </div>

                        <table class="table">
                            <tr>
                                @foreach($stages as $stage)
                                    <td>
                                        <p class="{!! ($stage['order_nr'] == $deal['stage_order_nr']) ? 'selected-stage' : '' !!}">
                                            {!! $stage['name'] !!}
                                        </p>
                                    </td>
                                @endforeach
                            </tr>
                        </table>

                        <div class="row">
                            <div class="col-xs-2 col-xs-offset-10">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Person
                                    </div>
                                    <div class="panel-body">
                                        <p><i class="glyphicon glyphicon-user"></i>{!! $deal['person_name'] !!}</p>
                                        @if(isset($deal['person_id']['email'][0]['value']) && !empty($deal['person_id']['email'][0]['value']))
                                            <p><i class="glyphicon glyphicon-envelope"></i>{!! $deal['person_id']['email'][0]['value'] !!}</p>
                                        @endif
                                        @if(isset($deal['person_id']['phone'][0]['value']) && !empty($deal['person_id']['phone'][0]['value']))
                                            <p><i class="glyphicon glyphicon-phone"></i>{!! $deal['person_id']['phone'][0]['value'] !!}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

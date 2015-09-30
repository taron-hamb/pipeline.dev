@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{!! $selectedPipeline['name'] !!}</div>
                    <div class="panel-body">
                        <table class="table">
                            <tr>
                                @foreach($stages as $stage)
                                    <td>
                                       <p>
                                           {!! $stage['name'] !!}
                                       </p>
                                        @if(isset($deals))
                                            @foreach($deals as $deal)
                                                @if($deal['stage_id'] == $stage['id'])
                                                    <p>
                                                        {!! $deal['title'] !!}
                                                        <small>
                                                            <span>{!! $deal['formatted_value'] !!}</span>
                                                            <span>{!! $deal['org_name'] !!}</span>
                                                        </small>
                                                    </p>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{!! $selectedPipeline['name'] !!}</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr>
                                @foreach($stages as $stage)
                                    <th>
                                       {!! $stage['name'] !!}
                                    </th>
                                @endforeach
                            </tr>
                        </table>
                        <ul>
                            @if(isset($deals))
                                @foreach($deals as $deal)
                                    <li>
                                        {!! $deal['title'] !!}
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

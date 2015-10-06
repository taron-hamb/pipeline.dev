@extends('app')

@section('content')

    <div class="col-md-12">
        <div class="title">
            {!! $selectedPipeline['name'] !!}
        </div>
        <table id="dashboard-table" class="table">
            <tr>
                @foreach($stages as $stage)
                    <td>
                        <p>
                            {!! $stage['name'] !!}
                        </p>
                        @if(isset($deals))
                            @foreach($deals as $deal)
                                @if($deal['stage_id'] == $stage['id'])
                                    <a href="/deal/{!! $deal['id'] !!}">
                                        <p>
                                            {!! $deal['title'] !!}
                                            <small>
                                                <span>{!! $deal['formatted_value'] !!}</span>
                                                <span>{!! $deal['org_name'] !!}</span>
                                            </small>
                                        </p>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </td>
                @endforeach
            </tr>
        </table>
    </div>

@endsection

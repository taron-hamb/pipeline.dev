@extends('app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <table class="table">
                <tr>
                    @foreach($users as $user)
                        <td class="user">
                            <a href="/user-desk/{!! $user['id'] !!}">
                                <p>
                                    {!! $user['name'] !!}
                                    <?php $dealsCount = 0 ?>
                                    @foreach($deals as $deal)
                                        @if($user['id'] == $deal['user_id'])
                                            <?php $dealsCount += 1 ?>
                                        @endif
                                    @endforeach
                                    <span>
                                        ({!! $dealsCount !!})
                                    </span>
                                </p>
                            </a>
                        </td>
                    @endforeach
                </tr>
            </table>

            <table class="table">
                <tr>
                    @foreach($stages as $stage)
                        <td>
                            <p>
                                {!! $stage['name'] !!}
                            </p>
                            @if(isset($userDeals))
                                @foreach($userDeals as $deal)
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

@endsection

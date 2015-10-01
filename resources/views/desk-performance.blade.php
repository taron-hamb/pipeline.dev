@extends('app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            {!! $selectedPipeline['name'] !!}
        </div>
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
        </div>
    </div>

@endsection

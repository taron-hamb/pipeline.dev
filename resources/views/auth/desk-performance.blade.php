@extends('app')

@section('content')

    <div class="col-md-12">
        <div class="title">
            {!! $selectedPipeline['name'] !!}
        </div>

        <select id="userSelect" class="form-control">
            <option value="">Choose User</option>
            @foreach($users as $user)
                <option value="/desk-performance/{!! $user['id'] !!}" {!! (isset($selectedUser) && ($user['id'] == $selectedUser['id'])) ? 'selected="selected"' : '' !!}>
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
                </option>
            @endforeach
        </select>

        @if(isset($selectedUser))
            <div class="title" style="margin-top:20px;">
                {!! $selectedUser['name'] !!}
            </div>
            <table id="user-pipeline" class="table">
                <tr>
                    @foreach($stages as $stage)
                        <td>
                            <p>
                                {!! $stage['name'] !!}
                            </p>
                            @if(isset($userDeals))
                                @foreach($userDeals as $deal)
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
        @endif
    </div>

@endsection

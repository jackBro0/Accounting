@extends('.layouts.master')
@section('title', 'Add')
@section('content')
    <table class="table table-sm table-hover table-bordered table-info mt-5">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Type</th>
            <th scope="col">Category</th>
            <th scope="col">Date</th>
            <th scope="col">Amount of money</th>
            <th scope="col">Commentary</th>
        </tr>
        </thead>
        <tbody>
        {{--        @dd($money_flows->flow_of_money)--}}
        @if(!empty($money_flows))
            @foreach($money_flows as $money_flow)
                @if(!empty($money_flow->category->name))
                    <tr @if($money_flow->flow_of_money == 'income') class="bg-success text-white"
                        @else class="bg-danger text-white" @endif>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$money_flow->flow_of_money}}</td>
                        <td>{{$money_flow->category->name}}</td>
                        <td>{{$money_flow->date}}</td>
                        <td>{{number_format( $money_flow->amount_of_money, 2, ',', ' ')}}</td>
                        <td>{{$money_flow->commentary}}</td>
                    </tr>
                @endif
            @endforeach
        @endif
        <tr>
            <td colspan="4"><h3>Total amount of money:</h3></td>
            <td COLSPAN="2"><h3>{{number_format( $total, 2, ',', ' ')}}</h3></td>
        </tr>
        </tbody>
    </table>
@endsection

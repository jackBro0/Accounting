@extends('.layouts.master')
@section('title', 'Add money of flow')
@section('content')
    <form action="{{route('money_flow.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="results">
            @if(Session::get('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
            @endif
            @if(Session::get('warning'))
                <div class="alert alert-warning">
                    {{Session::get('warning')}}
                </div>
            @endif
        </div>
        <div>
            <h1>Adding new Flow of money</h1>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="dating_adding">Date of adding</label>
                <input type="date" value="{{$formattedDate}}" class="form-control" id="dating_adding" name="date">
            </div>
            <div class="form-group col-md-6">
                <label for="flow_of_money">Flow of money</label>
                <select class="custom-select" id="flow_of_money" onclick="category()" name="type_of_money_flow">
                    <option></option>
                    <option value="income">Income</option>
                    <option value="spend">Spending</option>
                </select>
            </div>
        </div>
        <div class="form-group" id="income" hidden="hidden">
            <label for="category">Category</label>
            <select class="custom-select" name="income">
                @foreach($categories as $category)
                    @if($category->flow_of_money == 'income')
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group" id="spend" hidden="hidden">
            <label for="category">Category</label>
            <select class="custom-select" name="spend">
                @foreach($categories as $category)
                    @if($category->flow_of_money == 'spend')
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Amount of money</label>
            <input type="number" class="form-control" name="amount" id="amount">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="Comment">Comment</label>
                <textarea class="form-control" name="comment" id="Comment"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Confirm</button>
    </form>
    <h1 class="mt-5">List of Flows of money</h1>
    <table class="table table-sm table-hover table-bordered table-info mt-1">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Type</th>
            <th scope="col">Category</th>
            <th scope="col">Date</th>
            <th scope="col">Amount of money</th>
            <th scope="col">Commentary</th>
            <th scope="col">Action</th>
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
                        <td>
                            <form action="{{route('money_flow.destroy', $money_flow->id)}}" method="POST">
                                @csrf
                                <a href="{{route('money_flow.edit', $money_flow->id)}}" type="button"
                                   class="btn btn-primary">Edit</a>
                                @method('delete')
                                <button class="btn btn-warning">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endif
        <tr>
            <td colspan="4"><h2>Total amount of money:</h2></td>
            <td COLSPAN="2"><h3>{{number_format( $total, 2, ',', ' ')}}</td>
        </tr>
        </tbody>
    </table>
@endsection
@section('script')
    <script>
        function category() {
            let income = document.getElementById('income');
            let spend = document.getElementById('spend');
            let a = document.getElementById('flow_of_money').value;
            console.log(a)
            if (a === 'income') {
                income.toggleAttribute('hidden')
            }
            if (a === 'spend') {
                spend.toggleAttribute('hidden')
            }
        }
    </script>
@endsection

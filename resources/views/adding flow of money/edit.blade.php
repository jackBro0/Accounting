@extends('.layouts.master')
@section('title', 'Add money of flow')
@section('content')
    <form action="{{route('money_flow.update', $flow_of_money->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
            <h1>Editing Flow of money</h1>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="dating_adding">Date of adding</label>
                <input type="date" value="{{$flow_of_money->date}}" class="form-control" id="dating_adding" name="date">
            </div>
            <div class="form-group col-md-6">
                <label for="flow_of_money">Flow of money</label>
                <select class="custom-select" id="flow_of_money" onclick="category()" name="type_of_money_flow">
                    <option @if($flow_of_money->flow_of_money == 'income') selected="selected" @endif value="income">Income</option>
                    <option @if($flow_of_money->flow_of_money == 'spend') selected="selected" @endif value="spend">Spending</option>
                </select>
            </div>
        </div>
        <div class="form-group" id="income" @if($flow_of_money->flow_of_money != 'income') hidden="hidden" @endif>
            <label for="category">Category</label>
            <select class="custom-select" name="income">
                @foreach($categories as $category)
                    @if($category->flow_of_money == 'income')
                        <option @if($flow_of_money->category_id === $category->id) selected="selected" @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group" id="spend" @if($flow_of_money->flow_of_money != 'spend') hidden="hidden" @endif>
            <label for="category">Category</label>
            <select class="custom-select" name="spend">
                @foreach($categories as $category)
                    @if($category->flow_of_money == 'spend')
                        <option @if($flow_of_money->category_id === $category->id) selected="selected" @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Amount of money</label>
            <input type="number" value="{{$flow_of_money->amount_of_money}}" class="form-control" name="amount" id="amount">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="Comment">Comment</label>
                <textarea class="form-control" name="comment" id="Comment">{{$flow_of_money->commentary}}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Confirm</button>
    </form>
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

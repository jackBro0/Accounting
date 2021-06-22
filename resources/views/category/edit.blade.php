@extends('.layouts.master')
@section('title', 'Add')
@section('content')
    <div>
        <h1>Editing category</h1>
    </div>
    <div class="col col-8">
        <form action="{{route('category.update', $category->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="flow_of_money">Flow of money</label>
                <select class="custom-select" onclick="category()" id="flow_of_money" name="type_of_money_flow">
                    <option></option>
                    <option @if($category->flow_of_money === 'income') selected="selected" @endif value="income">Income</option>
                    <option @if($category->flow_of_money === 'spend') selected="selected" @endif value="spend">Spending</option>
                </select>
                <span class="text-danger">@error('type_of_money_flow'){{$message}}@enderror</span>
            </div>
            <div class="form-group" id="incoming" @if($category->flow_of_money != 'income') hidden="hidden" @endif>
                <label for="Income">Income</label>
                <input type="text" @if($category->flow_of_money === 'income') value="{{$category->name}}" @endif class="form-control" id="Income" name="income">
                <span class="text-danger">@error('income'){{$message}}@enderror</span>
            </div>
            <div class="form-group" id="spend" @if($category->flow_of_money != 'spend') hidden="hidden" @endif>
                <label for="Spending">Spending</label>
                <input type="text" @if($category->flow_of_money === 'spend') value="{{$category->name}}" @endif class="form-control" id="Spending" name="spend">
                <span class="text-danger">@error('spend'){{$message}}@enderror</span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
@section('script')
    <script>
        function category() {
            let income = document.getElementById('incoming');
            let spend = document.getElementById('spend');
            let a = document.getElementById('flow_of_money').value;
            if (a === 'income') {
                income.toggleAttribute('hidden')
            }
            if (a === 'spend') {
                spend.toggleAttribute('hidden')
            }
        }
    </script>
@endsection

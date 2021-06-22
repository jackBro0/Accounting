@extends('.layouts.master')
@section('title', 'Add')
@section('content')

    <div class="col col-8">
        <form action="{{route('category.store')}}" method="POST" enctype="multipart/form-data">
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
                <h1>Adding new category</h1>
            </div>
            <div class="form-group">
                <label for="flow_of_money">Flow of money</label>
                <select class="custom-select" onclick="category()" id="flow_of_money" name="type_of_money_flow">
                    <option></option>
                    <option value="income">Income</option>
                    <option value="spend">Spending</option>
                </select>
                <span class="text-danger">@error('type_of_money_flow'){{$message}}@enderror</span>
            </div>
            <div class="form-group" id="incoming" hidden="hidden">
                <label for="Income">Income</label>
                <input type="text" class="form-control" id="Income" name="income">
                <span class="text-danger">@error('income'){{$message}}@enderror</span>
            </div>
            <div class="form-group" id="spend" hidden="hidden">
                <label for="Spending">Spending</label>
                <input type="text" class="form-control" id="Spending" name="spend">
                <span class="text-danger">@error('spend'){{$message}}@enderror</span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <h1 class="mt-5">List of categories</h1>
    <table class="table mt-1 table-bordered">
        <caption>List of your categories</caption>
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Created</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr @if($category->flow_of_money === 'income') class="bg-success text-white"
                @else class="bg-danger text-white" @endif>
                <th scope="row">{{$loop->index+1}}</th>
                <td>{{$category->name}}</td>
                <td>{{$category->flow_of_money}}</td>
                <td>{{$category->created_at}}</td>
                <td>
                    <form action="{{route('category.destroy', $category->id)}}" method="POST">
                        @csrf
                        <a href="{{route('category.edit', $category->id)}}" type="button"
                           class="btn btn-primary">Edit</a>
                        @method('delete')
                        <button class="btn btn-warning">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

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


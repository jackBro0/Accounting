<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MoneyFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::query()->get();
        $user = Auth::user();
        return view('category.adding', compact('user', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty($request->income)){
            $request->validate([
                'type_of_money_flow' => 'required',
                'income' => 'required'
            ]);
        }
        if (!empty($request->spend)){
            $request->validate([
                'type_of_money_flow' => 'required',
                'spend' => 'required'
            ]);
        }

        if (!empty($request->income)){
            $category = Category::create([
                'flow_of_money'=> $request->type_of_money_flow,
                'name'=> $request->income
            ]);
        }

        if (!empty($request->spend)){
            $category = Category::create([
                'flow_of_money'=> $request->type_of_money_flow,
                'name'=> $request->spend
            ]);
        }

        if(!empty($category)){
            session()->flash('success','Successfully added!');
        }else{
            session()->flash('warning','Something went wrong!');
        }

        return redirect()->route('category.create');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::query()->findOrFail($id);
        $user = Auth::user();
        return view('category.edit', compact('category', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::query()->find($id);
        if ($category->flow_of_money == 'income'){
            $request->validate([
                'type_of_money_flow' => 'required',
                'income' => 'required'
            ]);
        }
        if ($category->flow_of_money == 'spend'){
            $request->validate([
                'type_of_money_flow' => 'required',
                'spend' => 'required'
            ]);
        }

        if ($category->flow_of_money === 'income'){
            $category->update([
                'flow_of_money'=> $request->type_of_money_flow,
                'name'=> $request->income
            ]);
        }

        if ($category->flow_of_money === 'spend'){
            $category->update([
                'flow_of_money'=> $request->type_of_money_flow,
                'name'=> $request->spend
            ]);
        }
        return redirect()->route('category.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flows_of_money = MoneyFlow::query()->get();
        $category = Category::query()->findOrFail($id);
        foreach ($flows_of_money as $flow_of_money){
            if ($flow_of_money->category_id == $category->id){
                $flow_of_money->delete();
            }
        }
        $category->delete();
        $income = 0;
        $spend = 0;
        $total = 0;
        $money_flows = MoneyFlow::query()->with('category')->get();
        $flow_of_money = MoneyFlow::query()->find($id);
        $flow_of_money->delete();
        foreach ($money_flows as $money) {
            if ($money->flow_of_money == 'income') {
                $income += $money->amount_of_money;
            }
            if ($money->flow_of_money == 'spend') {
                $spend += $money->amount_of_money;
            }
            $total = (int)$income - (int)$spend;
        }
        return redirect()->route('category.create', compact('total'));
    }
}

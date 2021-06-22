<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MoneyFlow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoneyFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $income = 0;
        $spend = 0;
        $total = 0;
        $formattedDate = Carbon::now()->format('Y-m-d');
        $categories = Category::query()->get();
        $money_flows = MoneyFlow::query()->with('category')->get();
        foreach ($money_flows as $money) {
            if ($money->flow_of_money == 'income') {
                $income += $money->amount_of_money;
            }
            if ($money->flow_of_money == 'spend') {
                $spend += $money->amount_of_money;
            }
            $total = (int)$income - (int)$spend;
        }
        $user = Auth::user();
        return view('adding flow of money.adding', compact('user', 'formattedDate', 'categories', 'money_flows', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($request->type_of_money_flow == 'income') {
            $request->validate([
                'date' => 'required',
                'type_of_money_flow' => 'required',
                'income' => 'required',
                'amount' => 'required',
                'comment' => 'required'
            ]);
        } else {
            $request->validate([
                'date' => 'required',
                'type_of_money_flow' => 'required',
                'spend' => 'required',
                'amount' => 'required',
                'comment' => 'required'
            ]);
        }

        if ($request->type_of_money_flow == 'income') {
            $money_flow = MoneyFlow::create([
                'user_id' => $user->id,
                'date' => $request->date,
                'flow_of_money' => $request->type_of_money_flow,
                'category_id' => $request->income,
                'amount_of_money' => $request->amount,
                'commentary' => $request->comment
            ]);
        } else {
            $money_flow = MoneyFlow::create([
                'user_id' => $user->id,
                'date' => $request->date,
                'flow_of_money' => $request->type_of_money_flow,
                'category_id' => $request->spend,
                'amount_of_money' => $request->amount,
                'commentary' => $request->comment
            ]);
        }

        if (!empty($money_flow)) {
            session()->flash('success', 'Successfully added!');
        } else {
            session()->flash('warning', 'Something went wrong!');
        }

        return redirect()->route('money_flow.create');
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
        $categories = Category::query()->get();
        $flow_of_money = MoneyFlow::query()->with('category')->first()->findOrFail($id);
        $user = Auth::user();
        return view('adding flow of money.edit', compact('user', 'categories', 'flow_of_money'));
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
        $flow_of_money = MoneyFlow::query()->with('category')->find($id);
        $user = Auth::user();
        $category = Category::query()->get();
        if ($request->type_of_money_flow == 'income') {
            $request->validate([
                'date' => 'required',
                'type_of_money_flow' => 'required',
                'income' => 'required',
                'amount' => 'required',
                'comment' => 'required'
            ]);
        } else {
            $request->validate([
                'date' => 'required',
                'type_of_money_flow' => 'required',
                'spend' => 'required',
                'amount' => 'required',
                'comment' => 'required'
            ]);
        }

        if ($request->type_of_money_flow == 'income') {
            $flow_of_money->update([
                'user_id' => $user->id,
                'date' => $request->date,
                'flow_of_money' => $request->type_of_money_flow,
                'category_id' => $request->income,
                'amount_of_money' => $request->amount,
                'commentary' => $request->comment
            ]);
        }
        if ($request->type_of_money_flow == 'spend') {
            $flow_of_money->update([
                'user_id' => $user->id,
                'date' => $request->date,
                'flow_of_money' => $request->type_of_money_flow,
                'category_id' => $request->spend,
                'amount_of_money' => $request->amount,
                'commentary' => $request->comment
            ]);
        }

        if (!empty($flow_of_money)) {
            session()->flash('success', 'Successfully edit!');
        } else {
            session()->flash('warning', 'Something went wrong!');
        }

        return redirect()->route('money_flow.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
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
        return redirect()->route('money_flow.create',compact('total'));
    }
}

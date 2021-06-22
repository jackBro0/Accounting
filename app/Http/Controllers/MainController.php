<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MoneyFlow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
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
        return view('index', compact('user', 'formattedDate', 'categories', 'money_flows', 'total'));
    }
}

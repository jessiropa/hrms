<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myPayrolls()
    {
        Gate::authorize('view-my-payrolls');

        $user = Auth::user();
        $payrolls = collect();

        if($user->employee){
            $payrolls = $user->employee->payrolls()->latest()->paginate(10);
        }

        return view('payrolls.my_payrolls', compact('payrolls'));
    }
}
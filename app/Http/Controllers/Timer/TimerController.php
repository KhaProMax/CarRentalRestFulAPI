<?php

namespace App\Http\Controllers\Timer;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;

class TimerController extends Controller
{
    public function getTimer(string $id) {
        $contract = Contract::query();
        $contract->where('USER_ID', '$id')->where('START_DATE', )->get();

    }
}

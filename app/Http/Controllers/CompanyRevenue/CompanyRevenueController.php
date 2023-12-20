<?php

namespace App\Http\Controllers\CompanyRevenue;

use App\Http\Controllers\Controller;
use App\Models\Company_Revenue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompanyRevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $company_revenues = Company_Revenue::all();

        return response()->json(['message' => 'Company_Revenues retreived successfully!', 'data' => $company_revenues], 200);
    }

    public function belongsToDay(string $dateString)
    {
        $date = Carbon::createFromFormat('d-m-Y', $dateString)->format('Y-m-d');

        $result = Company_Revenue::where('DATE_REVN', $date)->get();

        if (!$result) {
            return response()->json(['error' => 'No revenue at day ' . $dateString, 'statusCode' => 404], 404);
        }

        // Format the money values in the result
        $formattedResult = $result->map(function ($item) {
            list($year, $month, $day) = explode('-', $item->DATE_REVN);
            $item->YEAR = $year;
            $item->MONTH = $month;
            $item->DAY = $day;
            $item->REVENUE = number_format($item->REVENUE, 0, ',', '.');
            $item->PROFIT = number_format($item->PROFIT, 0, ',', '.');
            return $item;
        });

        return response()->json(['message' => 'Revenue of date ' . $dateString . ' retreived successfully!', 'data' => $formattedResult], 200);
    }

    public function belongsToMonth(string $monthString)
    {
        list($month, $year) = explode('-', $monthString);

        $result = Company_Revenue::selectRaw('MONTH(DATE_REVN) as MONTH, YEAR(DATE_REVN) as YEAR')
            ->selectRaw('SUM(REVENUE) as REVENUE, SUM(PROFIT) as PROFIT, SUM(NUM_OF_CLIENTS) as NUM_OF_CLIENTS')
            ->whereYear('DATE_REVN', $year)
            ->whereMonth('DATE_REVN', $month)
            ->groupBy('month')
            ->get();

        if (!$result) {
            return response()->json(['error' => 'No revenue at month ' . $monthString, 'statusCode' => 404], 404);
        }

        // Format the money values in the result
        $formattedResult = $result->map(function ($item) {
            $item->REVENUE = number_format($item->REVENUE, 0, ',', '.');
            $item->PROFIT = number_format($item->PROFIT, 0, ',', '.');
            return $item;
        });

        return response()->json(['message' => 'Revenue of ' . $monthString . ' retreived successfully!', 'data' => $formattedResult], 200);
    }

    public function belongsToYear(string $yearString)
    {
        $result = Company_Revenue::selectRaw('YEAR(DATE_REVN) as YEAR')
            ->selectRaw('SUM(REVENUE) as REVENUE, SUM(PROFIT) as PROFIT, SUM(NUM_OF_CLIENTS) as NUM_OF_CLIENTS')
            ->whereYear('DATE_REVN', $yearString)
            ->groupBy('year')
            ->get();

        if (!$result) {
            return response()->json(['error' => 'No revenue at month ' . $yearString, 'statusCode' => 404], 404);
        }


        // Format the money values in the result
        $formattedResult = $result->map(function ($item) {
            $item->REVENUE = number_format($item->REVENUE, 0, ',', '.');
            $item->PROFIT = number_format($item->PROFIT, 0, ',', '.');
            return $item;
        });

        return response()->json(['message' => 'Revenue of ' . $yearString . ' retreived successfully!', 'data' => $formattedResult], 200);
    }
}

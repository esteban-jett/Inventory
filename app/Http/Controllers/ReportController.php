<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Report::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'business_Id' => 'required|exists:business,business_Id',
            'report_date' => 'required|date',
            'total_sales' => 'required|string|max:255',
            'net_profit' => 'required|string|max:255',
        ]);

        $report = Report::create($request->all());

        return response()->json($report, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return response()->json($report);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'business_Id' => 'required|exists:business,business_Id',
            'report_date' => 'required|date',
            'total_sales' => 'required|string|max:255',
            'net_profit' => 'required|string|max:255',
        ]);

        $report->update($request->all());

        return response()->json($report);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

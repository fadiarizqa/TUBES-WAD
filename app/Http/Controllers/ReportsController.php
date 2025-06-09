<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reports;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id'   => 'required|integer',
            'post_type' => 'required|in:App\Models\LostItem,App\Models\FoundItem',
            'reason'    => 'required|string|max:500',
        ]);

        // Cek apakah user sudah melaporkan postingan yang sama
        $alreadyReported = Reports::where([
            'user_id'   => Auth::id(),
            'post_id'   => $request->post_id,
            'post_type' => $request->post_type
        ])->exists();

        if ($alreadyReported) {
            return back()->with('error', 'Kamu sudah melaporkan postingan ini sebelumnya.');
        }

        Reports::create([
            'user_id'   => Auth::id(),
            'post_id'   => $request->post_id,
            'post_type' => $request->post_type,
            'reason'    => $request->reason,
            'status'    => 'pending'
        ]);

        return back()->with('success', 'Laporan berhasil dikirim dan akan ditinjau oleh admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,rejected',
        ]);

        $report = Reports::findOrFail($id);
        $report->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status laporan diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $report = Reports::findOrFail($id);
        $report->delete();

        return back()->with('success', 'Laporan berhasil dihapus.');
    }
}

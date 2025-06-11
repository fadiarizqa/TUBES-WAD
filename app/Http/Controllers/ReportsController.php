<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reports;
use App\Models\LostItem;
use App\Models\FoundedItem;
use Illuminate\Validation\Rule;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Reports::with(['post', 'user'])->latest()->get();
        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    $request->validate([
            'post_id'   => 'required|integer',
            'post_type' => ['required', Rule::in(['lost', 'found'])],
        ]);

        $postId = $request->query('post_id');
        $postType = $request->query('post_type');
        $item = null;
        $modelClass = null;

        if ($postType === 'lost') {
            $item = LostItem::findOrFail($postId);
            $modelClass = 'App\\Models\\LostItem';
        } else {
            $item = FoundedItem::findOrFail($postId);
            $modelClass = 'App\\Models\\FoundedItem';
        }

        return view('reports.create', [
            'item' => $item,
            'postType' => $modelClass, // Kirim nama kelas model yang lengkap
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id'   => 'required|integer',
            'post_type' => 'required|in:App\Models\LostItem,App\Models\FoundedItem',
            'reason'    => 'required|string|max:500',
        ]);

        $alreadyReported = Reports::where('user_id', Auth::id())
            ->where('post_id', $validated['post_id'])
            ->where('post_type', $validated['post_type'])
            ->exists();

        if ($alreadyReported) {
            // Kembali dengan pesan error untuk memicu popup
            return back()->with('error', 'Anda sudah pernah melaporkan postingan ini sebelumnya.');
        }

        Reports::create([
            'user_id'   => Auth::id(),
            'post_id'   => $validated['post_id'],
            'post_type' => $validated['post_type'],
            'reason'    => $validated['reason'],
            'status'    => 'pending'
        ]);

        // Kembali dengan pesan sukses untuk memicu popup
        return back()->with('success', 'Laporan berhasil dikirim dan akan segera ditinjau oleh admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = Reports::with('post', 'user')->findOrFail($id);
        return view('reports.show', compact('report'));
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

        return redirect()->route('reports.show', $report->id)->with('success', 'Status laporan berhasil diperbarui.');  
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

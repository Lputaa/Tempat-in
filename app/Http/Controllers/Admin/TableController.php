<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    public function index()
    {
        $tables = Auth::user()->restaurant->tables()->paginate(10);
        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        Auth::user()->restaurant->tables()->create($validated);

        return redirect()->route('admin.tables.index')->with('success', 'Meja baru berhasil ditambahkan.');
    }

    public function edit(Table $table)
    {
        if ($table->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }
        return view('admin.tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        if ($table->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        $table->update($validated);

        return redirect()->route('admin.tables.index')->with('success', 'Data meja berhasil diperbarui.');
    }

    public function destroy(Table $table)
    {
        if ($table->restaurant_id !== Auth::user()->restaurant->id) {
            abort(403);
        }

        $table->delete();

        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil dihapus.');
    }
}
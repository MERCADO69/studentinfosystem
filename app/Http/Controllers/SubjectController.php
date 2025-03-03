<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:50|unique:subjects,subject_code',
            'units' => 'required|integer|min:1|max:10',
        ]);

        Subject::create($request->all());
        return redirect()->route('admin.subjects.index')->with('success', 'Subject added successfully.');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:50|unique:subjects,subject_code,' . $id,
            'units' => 'required|integer|min:1|max:10',
        ]);

        $subject->update($request->all());
        return redirect()->route('admin.subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();

        // Reset the IDs to fill the missing gaps
        DB::statement('SET @count = 0;');
        DB::statement('UPDATE subjects SET id = @count:= @count + 1;');
        DB::statement('ALTER TABLE subjects AUTO_INCREMENT = 1;');

        return redirect()->route('admin.subjects.index')->with('success', 'Subject deleted and IDs reordered.');
    }
}

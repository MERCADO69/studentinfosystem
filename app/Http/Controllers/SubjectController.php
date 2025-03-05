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
        $subject = Subject::findOrFail($id);

        // Check if there are any enrollments tied to this subject via the pivot table
        if ($subject->enrollments()->count() > 0) {
            // If students are enrolled in the subject, prevent deletion and return an error message
            return redirect()->route('admin.subjects.index')
                ->with('error', 'Subject cannot be deleted because students are enrolled.');
        }

        // Proceed to delete the subject if no enrollments are linked
        $subject->delete();

        // Optionally reset the IDs to fill missing gaps
        DB::statement('SET @count = 0;');
        DB::statement('UPDATE subjects SET id = @count:= @count + 1;');
        DB::statement('ALTER TABLE subjects AUTO_INCREMENT = 1;');

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully and IDs reordered.');
    }


}

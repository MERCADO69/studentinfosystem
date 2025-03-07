<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
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

    public function store(StoreSubjectRequest $request)
    {
        Subject::create($request->validated());

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject added successfully.');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(UpdateSubjectRequest $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->update($request->validated());

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);

        // Check if there are any enrollments tied to this subject
        if ($subject->enrollments()->count() > 0) {
            return redirect()->route('admin.subjects.index')
                ->with('error', 'Unable to delete the subject, students are enrolled.');
        }

        // Proceed to delete the subject
        $subject->delete();

        // Reset auto-increment (optional)
        DB::statement('SET @count = 0;');
        DB::statement('UPDATE subjects SET id = @count:= @count + 1;');
        DB::statement('ALTER TABLE subjects AUTO_INCREMENT = 1;');

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully and IDs reordered.');
    }
}

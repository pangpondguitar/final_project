<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terms;
use App\Models\Program;

class TermsControllor extends Controller
{
    public function index()
    {
        $term = Terms::all();

        return view('admin.terms', compact('term'));
    }

    public function term_insert(Request $request)
    {
        $term = Terms::create([
            't_name' => $request->t_num,
            't_year' => $request->t_year
        ]);

        return redirect()->back();
    }
    public function term_delete($id)
    {
        $term = Terms::where('t_id', $id)->first();
        $term->delete();
        return redirect()->back();
    }
    public function term_edit(Request $request, $id)
    {
        $term = Terms::where('t_id', $id)->first();


        $term->t_name = $request->t_num;
        $term->t_year = $request->t_year;
        $term->save();

        return redirect()->back();
    }
    public function program($id)
    {
        $programs = Program::all();
        return view('admin.term_program', compact('programs'));
    }
}

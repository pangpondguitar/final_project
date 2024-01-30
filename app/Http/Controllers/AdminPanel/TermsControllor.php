<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terms;
use App\Models\Program;
use App\Models\Terms_courses;

class TermsControllor extends Controller
{
    public function index()
    {
        $term = Terms::all();

        return view('admin.terms', compact('term'));
    }

    public function term_insert(Request $request)
    {
        $programs = Program::all();
        $term = Terms::create([
            't_name' => $request->t_num,
            't_year' => $request->t_year
        ]);
        foreach ($programs as $item) {
            Terms_courses::create([
                't_id' => $term->t_id,
                'p_id' => $item->p_id,
                'c_id' => $item->c_id
            ]);
        }
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

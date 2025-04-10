<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Professions;
use App\WorkingWith;
use App\Qualifications;

use DB;
use Session;
use File;
use App\Traits\Features;

class QWPController extends Controller

{
    use Features;
    public function index()
    {

        $promocode = Professions::get();
        $features = $this->getfeatures();
        if (empty($features)) {

            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {
            return view('templates.myadmin.profession')->with(['professions' => $promocode, 'allfeatures' => $features]);
        }
    }



    public function add()
    {


        return view('templates.myadmin.add_profession');
    }



    public function store(Request $request)
    {

        $this->validate(
            $request,
            [

                'name' => 'required',
            ],
            [

                'name.required' => 'Enter Professions',
            ]
        );
        
        $pid = $request->get('name');
        $pids = array();
        $product_ids = explode(',', $pid);
        foreach ($product_ids as $data1) {
            $pids[] = $data1;
        }
        $emailArray = $pids;
        $totalEmails = count($emailArray);
        for ($i = 0; $i < $totalEmails; $i++) {
            $promocode = new Professions();
            $data = $emailArray[$i];
            $promocode->name = $data;
            $promocode->save();
        }

        return redirect('profession')->with('success', 'Added Successfully');
    }

    public function edit($id)
    {
        $promocode = Professions::where('_id', '=', $id)->get();
        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {
            return view('templates.myadmin.edit_profession')->with(['professions' => $promocode, 'allfeatures' => $features]);
        }
    }


    public function update(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Enter Professions',
            ]
        );

        $promocode = Professions::find($request->get('id'));
        $promocode->name = $request->input('name');
        $promocode->save();

        return redirect('profession')->with('success', 'Updated Successfully');
    }

    public function delete($id)

    {

        $promocode = Professions::find($id);
        $promocode->delete();

        return redirect('profession')->with('success', 'Deleted Successfully');
    }

    //working with
    public function index_working()
    {
        $promocode = WorkingWith::get();
        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {
            return view('templates.myadmin.working')->with(['workings' => $promocode, 'allfeatures' => $features]);
        }
    }



    public function add_working()
    {
        return view('templates.myadmin.add_working');
    }



    public function store_working(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Enter working with',
            ]
        );
        $pid = $request->get('name');
        $input = $request->all();
        $pids = array();
        $product_ids = explode(',', $pid);
        foreach ($product_ids as $data1) {
            $pids[] = $data1;
        }
        $emailArray = $pids;
        $totalEmails = count($emailArray);
        for ($i = 0; $i < $totalEmails; $i++) {
            $promocode = new WorkingWith();
            $data = $emailArray[$i];
            $promocode->name = $data;
            $promocode->save();
        }


        return redirect('working')->with('success', 'Added Successfully');
    }

    public function edit_working($id)
    {
        $promocode = WorkingWith::where('_id', '=', $id)->get();
        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {

            return view('templates.myadmin.edit_working')->with(['workings' => $promocode, 'allfeatures' => $features]);
        }
    }


    public function update_working(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Enter working with',
            ]
        );

        $promocode = WorkingWith::find($request->get('id'));
        $promocode->name = $request->input('name');
        $promocode->save();

        return redirect('working')->with('success', 'Updated Successfully');
    }

    public function delete_working($id)

    {

        $promocode = WorkingWith::find($id);
        $promocode->delete();

        return redirect('working')->with('success', 'Deleted Successfully');
    }


    //qualification

    public function index_qualification()
    {


        $promocode = Qualifications::get();
        $features = $this->getfeatures();
        if (empty($features)) {

            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {
            return view('templates.myadmin.qualification')->with(['qualifications' => $promocode, 'allfeatures' => $features]);
        }
    }



    public function add_qualification()
    {
        return view('templates.myadmin.add_qualification');
    }

    public function store_qualification(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Enter qualification',
            ]
        );
        $pid = $request->get('name');
        $input = $request->all();
        $pids = array();
        $product_ids = explode(',', $pid);
        foreach ($product_ids as $data1) {
            $pids[] = $data1;
        }
        $emailArray = $pids;
        $totalEmails = count($emailArray);
        for ($i = 0; $i < $totalEmails; $i++) {
            $promocode = new Qualifications();
            $data = $emailArray[$i];
            $promocode->name = $data;
            $promocode->save();
        }


        return redirect('qualification')->with('success', 'Added Successfully');
    }

    public function edit_qualification($id)
    {
        $promocode = Qualifications::where('_id', '=', $id)->get();
        $features = $this->getfeatures();
        if (empty($features)) {
            return redirect('MyDashboard')->with('error', "Something went wrong");
        } else {

            return view('templates.myadmin.edit_qualification')->with(['qualifications' => $promocode, 'allfeatures' => $features]);
        }
    }


    public function update_qualification(Request $request)
    {

        $this->validate(
            $request,
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Enter qualifications',
            ]
        );

        $promocode = Qualifications::find($request->get('id'));
        $promocode->name = $request->input('name');
        $promocode->save();

        return redirect('qualification')->with('success', 'Updated Successfully');
    }

    public function delete_qualification($id)
    {

        $promocode = Qualifications::find($id);
        $promocode->delete();

        return redirect('qualification')->with('success', 'Deleted Successfully');
    }
}
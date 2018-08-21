<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\PopulationResource;
use App\Models\Population;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class PopulationsController extends Controller
{
    
    public function index()
    {
        $query = Population::query();

        $list = $query->paginate();

        return view('admin.population.index', compact('list'));
    }

    public function search(Request $request)
    {
        $query = Population::query();

        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where(function ($query) use ($name) {
                $query->where('name', 'like', '%'.$name.'%');
                $query->orWhere('old_name', 'like', '%'.$name.'%');
            });
        }

        if ($request->filled('id_number')) {
            $query->where('id_number', 'like', '%'.$request->input('id_number').'%');
        }

        if ($request->filled('key')) {
            $key = $request->input('key');
            $query->where(function ($query) use ($key) {
                $query->where('name', 'like', '%'.$key.'%');
                $query->orWhere('old_name', 'like', '%'.$key.'%');
                $query->orWhere('id_number', 'like', '%'.$key.'%');
            });
        }

        if ($request->filled('id_number')) {
            $query->where('id_number', 'like', '%'.$request->input('id_number').'%');
        }

        $list = $query->paginate();

        return PopulationResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.population.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

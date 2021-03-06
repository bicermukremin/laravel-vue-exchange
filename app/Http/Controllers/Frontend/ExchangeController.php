<?php

namespace App\Http\Controllers\Frontend;

use App\Exchange;
use App\Http\Controllers\Controller;
use App\Tag;
use Auth;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $returnArray = [];
        $returnArray['status'] = false;
        $search = request()->query('title');

        if ($search) {

            $exchanges = Exchange::where('title', 'LIKE', "%$search%")->orderByDesc('created_at')->with('user')->with('tags')->paginate(3);
        } else {
            $exchanges = Exchange::orderByDesc('created_at')->with('user')->with('tags')->paginate(3);
        }
        $returnArray['status'] = true;
        $returnArray['exchanges'] = $exchanges;
        return response()->json($returnArray);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $returnArray = [];
        $returnArray['status'] = false;
        $all = $request->except('token', 'tags');
        $all['user_id'] = Auth::user()->id;
        $tags = $request->tags;

        $create = Exchange::create($all);

        if ($tags) {

            foreach ($tags as $key => $tag) {
                Tag::create([
                    'name' => $tags[$key],
                    'exchange_id' => $create->id
                ]);
            }
        }



        if ($create) {
            $exchange = Exchange::where('id', $create->id)->with('user')->with('tags')->first();

            $returnArray['status'] = true;
            $returnArray['exchange'] = $exchange;
            $returnArray['message'] = 'You have created exchange successfully!';
            return response()->json($returnArray);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $returnArray = [];
        $returnArray['status'] = false;

        $exchange = Exchange::where('id', $id)->with('user')->with('tags')->first();

        $returnArray['status'] = true;
        $returnArray['exchange'] = $exchange;
        return response()->json($returnArray);
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
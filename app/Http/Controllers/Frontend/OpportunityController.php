<?php

namespace App\Http\Controllers\Frontend;

use App\Exchange;
use App\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class OpportunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)
            ->with('opportunities')->with('opportunities.exchanges')->with('opportunities.exchanges.user')->get();



        $returnArray['status'] = true;

        $returnArray['user'] = $user;

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
        $all = $request->except('token');

        //dd($all);

        if (isset($request->exchangeFromC)) {
            $cash = $request->exchangeFromC;
            $user1 = User::where('id', $all['fromUser'])->first();
            $fromUserName = $user1->name;
            $user2 = User::where('id', $all['toUser'])->first();
            $toUserName = $user2->name;
        } else {
            $user1 = User::where('id', $all['fromUser'])->first();
            $fromUserName = $user1->name;
            $user2 = User::where('id', $all['toUser'])->first();
            $toUserName = $user2->name;
            $cash = null;
        }

        $create = Opportunity::create([
            'title' => $all['title'],
            'cash' => $cash,
            'toUser' => $all['toUser'],
            'fromUser' => $all['fromUser'],
            'fromUserName' => $fromUserName,
            'toUserName' => $toUserName,
        ]);


        DB::table('opportunity_user')->insert(['user_id' => $all['toUser'], 'opportunity_id' => $create->id]);
        DB::table('opportunity_user')->insert(['user_id' => $all['fromUser'], 'opportunity_id' => $create->id]);
        DB::table('exchange_opportunity')->insert(['exchange_id' => $all['exchangeTo'], 'opportunity_id' => $create->id]);
        if (isset($request->exchangeFrom)) {

            DB::table('exchange_opportunity')->insert(['exchange_id' => $all['exchangeFrom'], 'opportunity_id' => $create->id]);
            Exchange::where('id', $all['exchangeTo'])->update(['grade' => 'first']);
            Exchange::where('id', $all['exchangeFrom'])->update(['grade' => 'second']);
        }

        if ($create) {
            $user = User::where('id', Auth::user()->id)
                ->with('opportunities')->with('opportunities.exchanges')->with('opportunities.exchanges.user')->get();

            $returnArray['status'] = true;

            $returnArray['user'] = $user;

            $returnArray['message'] = 'You have created opportunity successfully!';
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

        if ($request->query('status') == 'decline') {
            $returnArray = [];
            $returnArray['status'] = false;

            $update = Opportunity::where('id', $id)->update([
                'status' => 'declined'
            ]);

            if ($update) {

                $returnArray['status'] = true;

                $returnArray['message'] = 'You have declined opportunity!';
                return response()->json($returnArray);
            }
        }
        $returnArray = [];
        $returnArray['status'] = false;

        $update = Opportunity::where('id', $id)->update([
            'status' => 'accepted'
        ]);

        if ($update) {

            $returnArray['status'] = true;

            $returnArray['message'] = 'You have accepted opportunity please contact to offer owner!';
            return response()->json($returnArray);
        }
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
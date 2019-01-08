<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\WatchList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WatchListController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	    $this->middleware('auth:admin');
	}

    public function index()
    {
    	return view('admin.watchlist.list');
    }

    public function alldata()
    {
    	DB::statement(DB::raw('set @rownum=0'));
    	$watchlist = WatchList::get(['watch_lists.*', 
    	            DB::raw('@rownum  := @rownum  + 1 AS rownum')]);

    	return DataTables::of($watchlist)
    			->addColumn('user_name',function($single_user){
    				return $single_user->user->name.'('.$single_user->totalIp($single_user->id).')';
    			})
    			->addColumn('action',function($single_user){
    				$col_to_show = '';
	                $col_to_show .= '<a href="#" class="btn btn-primary" id="userLocationModalSwitch" data-id='.$single_user->id.'><i class="fa fa-eye"></i></a>';
	                $col_to_show .= '  <a href="#" id="UserWatchlistDelete" class="btn btn-danger" data-id='.$single_user->id.'><i class="fa fa-trash-o"></i></a>';
	                return $col_to_show;
    			})
    			->rawColumns(['action'])
    			->make(true);
    }


}

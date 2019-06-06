<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityResource;
use App\Model\Admin\Activity;
use App\Model\Admin\Book;
use App\Model\Admin\Utilities;
use App\Model\User\User;
use Illuminate\Http\Request;

class UtilitiesController extends Controller
{
    public function __construct(){
        $this->middleware('jwt.auth')->only([]);
    }

    public function utilites()
    {
    	$utilites  = Utilities::get()->first();
        $users     = User::all()->count();
        $books     = Book::all()->count();
        $downloads = Activity::where('activity','downloaded')->get()->count();

        $data = [
            'title'     => $utilites->title,
            'date_time' => $utilites->date_time,
            'facebook'  => $utilites->facebook,
            'youtube'   => $utilites->youtube,
            'email'     => $utilites->email,
            'messenger' => $utilites->messenger,
            'user_total'=> $users,
            'book_total'=> $books,
            'download_total'=> $downloads,

        ];
    	return response()->json($data);
    	// $res = fractal($data, new UtilityResource())->toArray();
    	// return $res;
    }
}

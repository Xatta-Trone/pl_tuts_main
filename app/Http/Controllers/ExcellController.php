<?php

namespace App\Http\Controllers;

use App\ExellTest;
use App\Model\Admin\Userdata;
use App\Model\User\User;
use File;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class ExcellController extends Controller
{
    public function index()
    {
        return view('excell');
    }

    public function import(Request $request)
    {
        //return $request->all();
        //validate the xls file
        $this->validate($request, array(
                'file'      => 'required'
            ));
     
        $file = Input::file('file');
        $fileName = $file->getClientOriginalName();
        //return $fileName;
        $file->move('files', $fileName);

        $results = Excel::load('files/'.$fileName, function ($reader) {
            $reader->all();
        })->get();
        $this->insertData($results);

        return view('data')->with('results', $results);
    }

       
    public function insertData($results)
    {
        $results->each(function ($sheet) {
            $row = json_decode($sheet, true);
            if ($row['merit'] != null || !empty($row['merit'])) {
                $merit = $row['merit'];
                                        
                $student_no = $row['student_id'];

                $student_name = $row['name_english'];

                $hall_name = $row['hall_name'];

                // $Excel = new ExellTest;
                // $Excel->merit = $merit;
                // $Excel->student_no = $student_no;
                // $Excel->student_name = $student_name;
                // $Excel->hall_name = $hall_name;
                // $Excel->status = 0;
                // $Excel->save();
                try {
                    //$data = [ 'merit'=> $merit,'student_no'=> $student_no,'student_name'=> $student_name,'hall_name'=> $hall_name,'status'=>'0'];
                    //dd($data);

                    //DB::table('exell_tests')->insert($data);
                    $Excel = new ExellTest;
                    $Excel->merit = $merit;
                    $Excel->student_no = $student_no;
                    $Excel->student_name = $student_name;
                    $Excel->hall_name = $hall_name;
                    $Excel->status = 0;
                    $Excel->save();
                } catch (QueryException $e) {
                    if ($this->isDuplicateEntryException($e)) {
                        echo "Data Not inserted because duplicate student id found";
                    }

                    throw $e;
                }
            }
        });
    }

    private function isDuplicateEntryException(QueryException $e)
    {
        $sqlState = $e->errorInfo[0];
        $errorCode  = $e->errorInfo[1];
        if ($sqlState === "23000" && $errorCode === 1062) {
            return true;
        }

        return false;
    }

    public function DuplicateEntryException($data)
    {
        return $data;
    }

    public function resolveuser()
    {
        DB::table('users')->orderBy('id')->chunk(100, function ($users) {
            foreach ($users as $user) {
                $student_id = 'S20'.$user->student_id;
                $check_user = DB::table('userdatas')->where('student_id', $student_id)->get()->first();
                if ($check_user != null) {
                    // $check_user->update(['status'=>1]);
                    DB::table('userdatas')->where('student_id', $student_id)->update(['status'=>1]);
                    echo $student_id." updated <br>";
                } else {
                    echo $student_id." not updated <br>";
                }
                    
                // dd($check_user);
            }
        });
    }
}

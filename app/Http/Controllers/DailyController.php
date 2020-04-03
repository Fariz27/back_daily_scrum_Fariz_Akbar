<?php

namespace App\Http\Controllers;
use JWTAuth;
use Illuminate\Http\Request;
use App\Daily;   
use Illuminate\Support\Facades\Validator;


class DailyController extends Controller
{
    public function index()
    {
    	try{
			$user = JWTAuth::parseToken()->authenticate();
	        $data["count"] = Daily::where('id_user', $user->id)->count();
	        $daily = array();
	        $data["daily"] = Daily::where('id_user', $user->id)->orderBy('created_at', 'DESC')->take(3)->get();
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }
    public function getAll($limit = 10, $offset = 0)
    {
    	try{
			$user = JWTAuth::parseToken()->authenticate();
	        $data["count"] = Daily::count();
	        $daily = array();
	        $data["daily"] = Daily::where('id_user', $user->id)->orderBy('created_at', 'DESC')->take($limit)->skip($offset)->get(); 
	        $data["status"] = 1;
	        return response($data);

	    } catch(\Exception $e){
			return response()->json([
			  'status' => '0',
			  'message' => $e->getMessage()
			]);
      	}
    }

    public function store(Request $request, $id)
    {
      try{
    		$validator = Validator::make($request->all(), [
    			'team'                        => 'required|string|max:255',
				'activity_today'			  => 'required|string|max:500',
                'problem_today'			      => 'required|string|max:500',
				'solution'			          => 'required|string|max:500',
                
    		]);

    		if($validator->fails()){
    			return response()->json([
    				'status'	=> 0,
    				'message'	=> $validator->errors()
    			]);
    		}

    		$data = new Daily();
	        $data->id_user = $id;
	        $data->team = $request->input('team');
            $data->activity_today = $request->input('activity_today');
	        $data->problem_today = $request->input('problem_today');
	        $data->solution = $request->input('solution');
	        $data->save();

    		return response()->json([
    			'status'	=> '1',
    			'message'	=> 'Data scrum berhasil ditambahkan!'
    		], 201);

      } catch(\Exception $e){
            return response()->json([
                'status' => '0',
                'message' => $e->getMessage()
            ]);
        }
      }

      

      public function delete($id)
      {
          try{
  
              $delete = Daily::where("id", $id)->delete();
  
              if($delete){
                return response([
                    "status"	=> 1,
                    "message"   => "Data scrum berhasil dihapus."
                ]);
              } else {
                return response([
                  "status"  => 0,
                    "message"   => "Data scrum gagal dihapus."
                ]);
              }
          } catch(\Exception $e){
              return response([
                  "status"	=> 0,
                  "message"   => $e->getMessage()
              ]);
          }
      }  
      

}

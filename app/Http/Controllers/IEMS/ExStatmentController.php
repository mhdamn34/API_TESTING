<?php

namespace App\Http\Controllers\IEMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\encode;
use Illuminate\Contracts\Enencodeion\DeencodeException;
use Illuminate\Database\QueryException;
use Validator;
use DB;
use Storage;


class ExStatmentController extends Controller
{
   public function GetRecordReturnData($id)
   {
       
      try { 
            if (base64_decode($id, true)) {
               
               $sqlq = base64_decode($id);
               \LogActivity::addToLog($sqlq);
               if (strpos($sqlq, 'tb') !== false) {
                  $slt = DB::select($sqlq);
                  if($slt==NULL){
                     \LogActivity::addToLog("Record not found!");
                     return response()->json([ "success" => "false",
                     "mesage" => "Record not found!","result" =>""], 404); 
                  }else{
                     \LogActivity::addToLog('success get record');  
                     $dat = response()->json($slt);
                     $ciphertext = base64_encode($dat);
                     return response()->json([ "success" => "true",
                     "mesage" => "","result" =>$ciphertext], 200);
                     //return response()->json($slt, 200);                
                  }
               }else{
                  \LogActivity::addToLog('invalid encode value');
                  return response()->json([ "success" => "false",
                  "mesage" => "invalid encode value","result" =>""], 400);   
               }
            }else{
               \LogActivity::addToLog('invalid encode value');
               return response()->json([ "success" => "false",
               "mesage" => "invalid encode value","result" =>""], 400);   
            }
         } catch(QueryException $ex){ 
            \LogActivity::addToLog($ex->getMessage());
            return response()->json([ "success" => "false",
            "mesage" => $ex->getMessage(),"result" =>""], 400);
         }
   }
   
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function daily()
    {
        try {
            $data = [];
            $data['success'] = true;
            $data['message'] = 'Daily Sale Information';
            $data['date'] = date('Y-m-d');
            $data['daily_sales_reports'] = Sale::with(['sales_details'=>function($query){
                $query->with('product');
            }])->where('status','=',2)->whereDate('updated_at','=',Carbon::today()->toDateString())->get();
//            $data['total_daily_sale'] = Sale::where('status','=',2)->whereDate('updated_at','=',Carbon::today()->toDateString())->sum('net_total');
            return response()->json($data,200);
        }catch (\Exception $exception){
            return response()->json([
               'error'=>true,
               'message'=>$exception->getMessage(),
            ],404);
        }
    }

    public function monthly()
    {
        try {
            $data = [];
            $data['success'] = true;
            $data['message'] = 'Monthly Sale Information';
            $data['date'] = date('Y-m-d');
            $data['daily_sales_reports'] =Sale::with(['sales_details'=>function($query){
                $query->with('product');
            }])->where('status','=',2)
                ->whereMonth('updated_at','=',Carbon::now()->month)
                ->whereYear('updated_at','=',Carbon::now()->year)->get();
            return response()->json($data,200);
        }catch (\Exception $exception){
            return response()->json([
                'error'=>true,
                'message'=>$exception->getMessage(),
            ],404);
        }
    }

    public function yearly()
    {
        try {
            $data = [];
            $data['success'] = true;
            $data['message'] = 'Yearly Sale Information';
            $data['date'] = date('Y-m-d');
            $data['yearly_sales_reports'] =Sale::with(['sales_details'=>function($query){
                $query->with('product');
            }])->where('status','=',2)->whereYear('updated_at','=',Carbon::now()->year)->get();
            return response()->json($data,200);
        }catch (\Exception $exception){
            return response()->json([
                'error'=>true,
                'message'=>$exception->getMessage(),
            ],404);
        }
    }

    public function specific_date(Request $request)
    {
        try {
            $data = [];
            $data['success'] = true;
            $data['message'] = 'Daily Sale Information of '. $request->date;
            $data['date'] = $request->date;
            $data['daily_sales_reports'] =Sale::with(['sales_details'=>function($query){
                $query->with('product');
            }])->where('status','=',2)->whereDate('updated_at','=',$request->date)->get();
            return response()->json($data,200);
        }catch (\Exception $exception){
            return response()->json([
                'error'=>true,
                'message'=>$exception->getMessage(),
            ],404);
        }
    }
    public function specific_monthly(Request $request)
    {
        try {
            $data = [];
            $data['success'] = true;
            $data['message'] = 'Monthly Sale Information for '.$request->month;
            $data['date'] = date("$request->year-$request->month-01");
            $data['daily_sales_reports'] =Sale::with(['sales_details'=>function($query){
                $query->with('product');
            }])->where('status','=',2)
                ->whereMonth('updated_at','=',$request->month)
                ->whereYear('updated_at','=',$request->year)->get();
            return response()->json($data,200);
        }catch (\Exception $exception){
            return response()->json([
                'error'=>true,
                'message'=>$exception->getMessage(),
            ],404);
        }
    }
    public function specific_yearly(Request $request)
    {
        try {
            $data = [];
            $data['success'] = true;
            $data['message'] = 'Yearly Sale Information of '.$request->year;
            $data['date'] = date("$request->year-01-01");
            $data['yearly_sales_reports'] =Sale::with(['sales_details'=>function($query){
                $query->with('product');
            }])->where('status','=',2)->whereYear('updated_at','=',$request->year)->get();
            return response()->json($data,200);
        }catch (\Exception $exception){
            return response()->json([
                'error'=>true,
                'message'=>$exception->getMessage(),
            ],404);
        }
    }
}

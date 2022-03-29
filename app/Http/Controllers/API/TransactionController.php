<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $status = $request->input('status');

        if($id){
            $transactions = Transaction::with(['items.product'])->find($id);
            if($transactions){
                return ResponseFormatter::success(
                    $transactions, 
                    'Data transaksi berhasil diambil');
            }else{
                return ResponseFormatter::error(
                    null, 
                    'Data transaksi tidak ada', 
                    404
                );
            }
        }

        $transactions = Transaction::with('[items.product]')->where('users_id', Auth::user()->id);

        if($status){
            $transactions->where('status', $status);
        }
                return ResponseFormatter::success(
                    $transactions->paginate($limit),
                    'Data list transaksi berhasil diambil'
                );
            
    }
}

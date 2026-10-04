<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pledge;
use Illuminate\Http\Request;

class QRScanController extends Controller
{
    public function scan(Request $request)
    {
        $request ->validate([
            'qr_code' =>'required | string',
        ]);
          $qrCode = $request->input('qr_code');
        $pledge =Pledge::with('user') ->where('qr_code',$request->qr_code) ->first();
       
        if (!$pledge) {
            return response()->json([
                'success' => false,
                'message' => 'QR code not found',
                
            ],404);
        }
        $alreadyScanned = (bool) $pledge->is_scanned ;
        if (!$alreadyScanned) {
            $pledge->is_scanned = true;
            $pledge->save();
        }
        return response()->json([
            'success' => true,
            'message' =>'QR code found',
            'already_scanned' => $alreadyScanned,
            'data' =>[
                'qr_code' => $pledge->qr_code,
                'name' => $pledge->user->name ?? unknown,
                'category' => $pledge->category,
                'amount' => $pledge->amount,
                'paid' => $pledge->paid,
                'remain' => $pledge->remain,
                'payment_method' => $pledge->payment_method,
                'status' => $pledge->status,
            ],
        ]);
    }
}

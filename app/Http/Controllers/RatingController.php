<?php

namespace App\Http\Controllers;

use App\Models\RatingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    private $response;
    private $responseCode;
    private $responseStatus;
    private $responseMessage;

    public function store(Request $request)
    {
        try {
            $validate = validator::make($request->all(), [
                'rating' => 'required|integer|min:1',
                'item_id' => 'required',
                'user_id' => 'required',
            ]);

            if ($validate->fails()) {
                $this->responseMessage = $validate->errors();
                $this->responseStatus = false;
                $this->responseCode = 401;
            } else {
                $data = RatingModel::create([
                    'item_id' => $request->input('item_id'),
                    'user_id' => $request->input('user_id'),
                    'rating' => $request->input('rating'),
                ]);

                if ($data) {
                    $this->responseMessage = "Success Input Rating";
                    $this->responseStatus = true;
                    $this->responseCode = 200;
                    $this->response['data'] = $data;
                } else {
                    $this->responseMessage = "Failed Inputing Rating";
                    $this->responseStatus = false;
                    $this->responseCode = 400;
                }
            }
        } catch (\Throwable $th) {
            $this->responseCode = 500;
            $this->responseStatus = false;
            $this->responseMessage = $th->getMessage();
        }
        $this->response['success'] = $this->responseStatus;
        $this->response['message'] = $this->responseMessage;
        return response()->json($this->response, $this->responseCode);
    }

    public function show(Request $request)
    {
        try {
            $itemId = $request->id;

            if ($itemId == null) {
                $this->responseMessage = "Id Can Not Be Null";
                $this->responseStatus = false;
                $this->responseCode = 401;
            } else {

                $item = RatingModel::where('item_id', $itemId)->get();
                if (count($item) > 0) {
                    $this->responseMessage = "Data Found";
                    $this->responseStatus = true;
                    $this->responseCode = 200;
                    $this->response['data'] = $item;

                    $sum = 0;
                    foreach ($item as $items) {
                        $sum += $items['rating'];
                    }
                    $this->response['sum'] = $sum;

                    $this->response['count'] = count($this->response['data']);
                    $this->response['rating'] = floatval(number_format($this->response['sum'] / $this->response['count'], 2));
                } else {
                    $this->responseMessage = "Item Not Found";
                    $this->responseStatus = false;
                    $this->responseCode = 404;
                }
            }
        } catch (\Throwable $th) {
            $this->responseCode = 500;
            $this->responseStatus = false;
            $this->responseMessage = $th->getMessage();
        }
        $this->response['success'] = $this->responseStatus;
        $this->response['message'] = $this->responseMessage;
        return response()->json($this->response, $this->responseCode);
    }
}

<?php


namespace App\Http\Controllers;

use App\Models\ItemModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class Item extends Controller
{
    private $response;
    private $responseCode;
    private $responseStatus;
    private $responseMessage;

    public function index()
    {
        try {
            $data = ItemModel::all();
            $filePath = base_path('public/image/kayu-manis.jpg');
            $base64Image = base64_encode(Storage::get($filePath));
            $this->responseMessage = "Success Fetch All Data";
            $this->responseStatus = true;
            $this->responseCode = 200;
            $this->response['data'] = $data;
            $this->response['total'] = count($data);
            foreach ($data as $items) {
                $items['picture'] = $base64Image ;
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

    public function create(Request $request)
    {
        try {
            $validate = validator::make($request->all(), [
                'judul'             => 'required',
                'bahan'             => 'required',
                'cara_pembuatan'    => 'required',
                // 'status'            => 'required',
                'user_id'           => 'required',
            ]);

            if ($validate->fails()) {
                $this->responseMessage = $validate->errors();
                $this->responseStatus = false;
                $this->responseCode = 401;
            } else {
                $data = ItemModel::create([
                    'judul' => $request->input('judul'),
                    'bahan' => $request->input('bahan'),
                    'cara_pembuatan' => $request->input('cara_pembuatan'),
                    'picture' => $request->input('picture'),
                    // 'status' => $request->input('status'),
                    'user_id' => $request->input('user_id'),
                ]);

                if($data){
                    $this->responseMessage = "Success Input Data";
                    $this->responseStatus = true;
                    $this->responseCode = 200;
                    $this->response['data'] = $data;
                }else{
                    $this->responseMessage = "Failed Input Data";
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

    public function update(Request $request) {
        try {
            $itemId = $request->id;

            $item = ItemModel::find($itemId);

            if ($item) {
                $item->update([
                    'judul' => $request->input('judul'),
                    'bahan' => $request->input('bahan'),
                    'cara_pembuatan' => $request->input('cara_pembuatan'),
                    'picture' => $request->input('picture'),
                    // 'status' => $request->input('status'),
                    // 'user_id' => $request->input('user_id'),
                ]);

                $this->responseMessage = "Success Update Data";
                $this->responseStatus = true;
                $this->responseCode = 200;
                $this->response['data'] = $item;
            
            } else {
                $this->responseMessage = "Item Not Found";
                $this->responseStatus = false;
                $this->responseCode = 404;
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

    public function destroy(Request $request) {
        try {
            $itemId = $request->id;

            if ($itemId == null) {
                $this->responseMessage = "Id Can Not Be Null";
                $this->responseStatus = false;
                $this->responseCode = 401;
            } else {
                $item = ItemModel::find($itemId);

                if ($item) {

                    $item->delete();

                    $this->responseMessage = "Success Deleting Data";
                    $this->responseStatus = true;
                    $this->responseCode = 200;
                    $this->response['data'] = $item;
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

    public function show(Request $request) {
        try {
            $itemId = $request->id;

            if ($itemId == null) {
                $this->responseMessage = "Id Can Not Be Null";
                $this->responseStatus = false;
                $this->responseCode = 401;
            } else {

                $item = ItemModel::find($itemId);
                $filePath = base_path('public/image/lemon.jpg');
                $base64Image = base64_encode(Storage::get($filePath));

                if ($item) {
                    $this->responseMessage = "Data Found";
                    $this->responseStatus = true;
                    $this->responseCode = 200;
                    $this->response['data'] = $item;

                    foreach ($item as $items) {
                        $items['picture'] = $base64Image ;
                    }
                
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

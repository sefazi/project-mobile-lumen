<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    private $response;
    private $responseCode;
    private $responseStatus;
    private $responseMessage;
    
    public function index() {
        try {
            $data = User::all();
            $this->responseMessage = "Success Fetch All Data User";
            $this->responseStatus = true;
            $this->responseCode = 200;
            $this->response['data'] = $data;

        } catch (\Throwable $th) {
            $this->responseCode = 500;
            $this->responseStatus = false;
            $this->responseMessage = $th->getMessage();

        }
        $this->response['success'] = $this->responseStatus;
        $this->response['message'] = $this->responseMessage;
        return response()->json($this->response, $this->responseCode);

    }

    public function store(Request $request)
    {
        try {
            $validate = validator::make( $request->all(), [
                'username' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);
    
            if ($validate->fails()) {
                $this->responseMessage = $validate->errors();
                $this->responseStatus = false;
                $this->responseCode = 401;
            } else {
                $data = User::create([
                    'username' => $request->input('username'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                ]);

                if($data){
                    $this->responseMessage = "Success Create User";
                    $this->responseStatus = true;
                    $this->responseCode = 200;
                    $this->response['data'] = $data;
                }else{
                    $this->responseMessage = "Failed Create User";
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

    public function show(Request $request) {
        try {
            $itemId = $request->id;

            if ($itemId == null) {
                $this->responseMessage = "Id Can Not Be Null";
                $this->responseStatus = false;
                $this->responseCode = 401;
            } else {

                $item = User::find($itemId);
                if ($item) {
                    $this->responseMessage = "Data Found";
                    $this->responseStatus = true;
                    $this->responseCode = 200;
                    $this->response['data'] = $item;
                    // $this->response['data']->bebek=Hash::check($this->response['data']->password,'');
                
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

    public function update(Request $request) {
        try {
            $itemId = $request->id;

            $item = User::find($itemId);

            if ($item) {
                $item->update([
                    'username' => $request->input('username'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
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
                $item = User::find($itemId);

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

    public function check(Request $request) {
        try {
            $userEmail = $request->input('email');
            $userPassword = $request->input('password');

            if ($userEmail == null) {
                $this->responseMessage = "Id Can Not Be Null";
                $this->responseStatus = false;
                $this->responseCode = 401;
            } else {
                $item = User::where('email',$userEmail)->first();

                if ($item) {

                    if (Hash::check($userPassword,$item->password)) {
                        $this->responseMessage = "Account Found";
                        $this->responseStatus = true;
                        $this->responseCode = 200;
                        $this->response['data'] = $item;
                    }else {
                        $this->responseMessage = "Password Not Match";
                        $this->responseStatus = false;
                        $this->responseCode = 401;
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

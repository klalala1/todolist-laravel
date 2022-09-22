<?php

namespace App\Http\Controllers\API;

use App\Models\Item;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Throwable;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
    protected $item;
    protected $responseCode;
    protected $responseData;
    protected $casts = [
        'tags_list' => 'array'
    ];
    public function __construct()
    {
        $this->item = new Item;
        $this->responseData = [];
        $this->responseCode = 200;
    }
    public function index(Request $request)
    {
        $header = $request->header('username');

        if ($request->header('completed') !== "true") {
            try {
                $dataList = $this->item->getItems($header);
                // throw ValidationException::withMessages(['your error msessage']);
                return response()->json($dataList, 200);
            } catch (\Exception $e) {

                return response()->json($e, 500);
            }
        } else {
            try {
                $dataList = $this->item->getCompleted($header);
                // throw ValidationException::withMessages(['your error msessage']);
                return response()->json($dataList, 200);
            } catch (\Exception $e) {

                return response()->json($e, 500);
            }
        }
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $dataList = $this->item->createItem($request);

            return response()->json($dataList, 200);
        } catch (\Exception $e) {
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $dataList = $this->item->updateItem($id);

            // array_push($this->responseData, $dataList);
            return response()->json($dataList, 200);
        } catch (\Exception $e) {
            // array_push($this->responseData, $e->getMessage());
            // $this->responseCode = $e->getCode();
        }
        return response()->json($this->responseData, $this->responseCode);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        try {
            $dataList = $this->item->editItem($request, $id);

            // array_push($this->responseData, $dataList);
            return response()->json($dataList, 200);
        } catch (\Exception $e) {

            // array_push($this->responseData, $e->getMessage());
            // $this->responseCode = $e->getCode();
        }
        return response()->json($this->responseData, $this->responseCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $dataList = $this->item->deleteItem($id);

            array_push($this->responseData, $dataList);
        } catch (\Exception $e) {
            array_push($this->responseData, $e->getMessage());
            $this->responseCode = $e->getCode();
        }
        return response()->json($this->responseData, $this->responseCode);
    }
}

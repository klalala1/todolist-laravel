<?php

namespace App\Http\Controllers\API;

use App\Models\Tags;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Throwable;
use Illuminate\Validation\ValidationException;

class TagsController extends Controller
{
    protected $tags;
    protected $responseCode;
    protected $responseData;

    public function __construct()
    {
        $this->tags = new Tags;
        $this->responseData = [];
        $this->responseCode = 200;
    }
    public function index(Request $request)
    {
        $username = $request->header('username');
        try {

            $dataList = $this->tags->getTags($username);

            return response()->json($dataList, 200);
        } catch (\Exception $e) {
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
            $dataList = $this->tags->createTag($request);

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
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $dataList = $this->item->updateItem($request, $id);

            array_push($this->responseData, $dataList);
        } catch (\Exception $e) {
            array_push($this->responseData, $e->getMessage());
            $this->responseCode = $e->getCode();
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

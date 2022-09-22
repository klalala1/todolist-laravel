<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tags extends Model
{

    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'completed', 'username'];
    public function getTags(string $username)
    {

        // $dataList = $this->all();
        return $this->where('username', $username)->orderBy('created_at', 'DESC')->get();
        // return $this->orderBy('created_at', 'DESC')->get();
    }
    public function createTag(Request $request)
    {


        $this->tag_name = $request->tag;
        $this->username = $request->username;
        $this->created_at = Carbon::now();
        $this->updated_at = Carbon::now();
        $this->save();

        return  $this;
    }
    public function updateItem(Request $request, $id)
    {
        $isUpdated = false;
        try {
            $existingItem = $this::find($id);
            if (!$existingItem) {
                throw new Exception('Unable to find item', 404);
            }
            $this::where('id', $id)
                ->update([
                    'completed' => $request->item['completed'] ? true : false,
                    "completed_at" => $request->item['completed'] ? Carbon::now() : null
                ]);
            $isUpdated = true;
        } catch (Throwable $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return  $isUpdated;
    }
    public function deleteItem($id)
    {
        $isDeleted = false;
        try {
            $existingItem = $this::find($id);
            if (!$existingItem) {
                throw new Exception('Unable to find item', 404);
            }
            $this::where('id', $id)->delete();
            $isDeleted = true;
        } catch (Throwable $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        return  $isDeleted;
    }
}

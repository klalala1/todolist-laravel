<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection as SupportCollection;

class Item extends Model
{

    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'completed', 'tags_list', 'due_dates', 'tags_list', 'description'];

    protected $casts = [
        'tags_list' => 'array'
    ];
    public function getItems(string $username): Collection
    {
        $items = collect([]);

        try {


            // $dataList = $this->all();

            // $items->push(['item' => $this->where([['username', '=', $username], ['completed', '=', false]])->whereDate('due_dates', '<', Carbon::today())->orderBy('created_at', 'DESC')->get(), 'due' => 'overdued']);
            // $items->push(['item' => $this->where([['username', '=', $username], ['completed', '=', false]])->whereDate('due_dates', Carbon::today())->orderBy('created_at', 'DESC')->get(), 'due' => 'today']);
            // $items->push(['item' => $this->where([['username', '=', $username], ['completed', '=', false]])->whereDate('due_dates', '<=', Carbon::now()->endOfWeek())->whereDate('due_dates', '>', Carbon::today())->orderBy('created_at', 'DESC')->get(), 'due' => 'week']);
            // $items->push(['item' => $this->where([['username', '=', $username], ['completed', '=', false]])->whereDate('due_dates', '>',  Carbon::now()->endOfWeek())->orderBy('created_at', 'DESC')->get(), 'due' => 'later']);

            // $items.put('week',$this->where([['username', '=', $username], ['completed', '=', false]])->orderBy('created_at', 'DESC')->get();) 
            $items = $this->where([['username', '=', $username], ['completed', '=', false]])->orderBy('due_dates', 'ASC')->get();

            // return $this->where([['username', '=', $username], ['completed', '=', false]])->orderBy('created_at', 'DESC')->get();

            // return $this->orderBy('created_at', 'DESC')->get();

        } catch (\Throwable $th) {
        }

        return  $items;
    }
    public function getCompleted(string $username): Collection
    {
        $items = collect([]);

        try {

            $items = $this->where([['username', '=', $username], ['completed', '=', true]])->orderBy('completed_at', 'DESC')->get();
        } catch (\Throwable $th) {
        }

        return  $items;
    }
    public function createItem(Request $request)
    {
        $this->name = $request->item['name'];
        $this->username = $request->item['username'];
        $this->description = $request->item['description'];
        $this->due_dates = $request->item['due_dates'];
        $this->tags_list = $request->item['tags_list'];
        $this->update_at = Carbon::now();
        $this->created_at = Carbon::now();

        $this->save();
        return $this->where([['username', '=', $this->username], ['completed', '=', false]])->orderBy('created_at', 'DESC')->get();
        // return $this->where('username', $this->username)->orderBy('created_at', 'DESC')->get();
    }
    public function updateItem($id)
    {

        $isUpdated = false;
        try {
            $existingItem = $this::find($id);
            if (!$existingItem) {
                throw new Exception('Unable to find item', 404);
            }
            $existingItem->completed = $existingItem->completed ? false : true;
            $existingItem->completed_at = $existingItem->completed ? Carbon::now() : null;
            $existingItem->save();
        } catch (Throwable $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        // return $this->where('username', $existingItem['username'])->orderBy('created_at', 'DESC')->get();
        // return $this->where([['username', '=',  $existingItem['username']], ['completed', '=', false]])->orderBy('created_at', 'DESC')->get();

        return $existingItem;
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
    public function editItem($request, $id)
    {

        $isUpdated = false;
        try {
            $existingItem = $this::find($id);

            if (!$existingItem) {
                throw new Exception('Unable to find item', 404);
            }

            $existingItem->name = $request->item['name'];
            $existingItem->description = $request->item['description'];
            $existingItem->due_dates = $request->item['due_dates'];
            $existingItem->tags_list = $request->item['tags_list'];

            $existingItem->save();
        } catch (Throwable $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        // return $this->where('username', $existingItem['username'])->orderBy('created_at', 'DESC')->get();
        // return $this->where([['username', '=',  $existingItem['username']], ['completed', '=', false]])->orderBy('created_at', 'DESC')->get();

        return $existingItem;
    }
}

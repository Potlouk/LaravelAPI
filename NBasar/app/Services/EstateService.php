<?php
namespace App\Services;

use App\Http\Requests\EstateRequest;
use App\Http\Resources\EstateResource;
use App\Mail\DeletedByAdmin;
use App\Models\Equipment;
use App\Models\EquipmentList;
use App\Models\Estate;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class EstateService {

    public function search($request){
        $query = Estate::with([
            'elocation',
            'photos',
            'price',
            'user'
        ]);
    
        $fields = [
            'price',
            'floor',
            'sub_type',
            'building_material',
            'ownership_type',
            'energy_consumption',
            'type',
            'condition',
            'room_type',
            'furniture',
            'area',
            'transaction_type',
        ];
    
        foreach ($fields as $field) {
            if ($request->has($field) && !empty($request->input($field))) {
                $query->where($field, $request->input($field));
            }
        }
    
        if ($request->has('equipment') && !empty($request->input('equipment'))) {
            $equipmentIds = $request->input('equipment');
            $query->whereHas('equipment', function ($query) use ($equipmentIds) {
                $query->whereIn('equipment_id', $equipmentIds);
            });
        }
    
        $estates = $query->get();
    
        return EstateResource::collection($estates);
    }


    public function get($key,$value){
        $estates = Estate::with([
            'elocation',
            'ownershipType',
            'energy',
            'etype',
            'subType',
            'roomType',
            'buildingMaterial',
            'conditionType',
            'equipment',
            'user'
        ])->whereIn($key, $value)->get();

        return EstateResource::collection($estates);
    }

    public function getFavorites($id){
       return $this->get('uuid',(array) User::findById($id)->watched_estates);
    }

    public function getOwned($id){
        return $this->get('user_id', [$id]);
    }

    public function getAll($limit){
        $users = Estate::all()->paginate($limit);
        return $users;
    }
    public function patch($uuid, $data){
        $parsedData = [];
        foreach ($data as $item)
        $parsedData[$item['name']] = $item['value'];

        $estate = Estate::findByUuid($uuid);
        $locationId = Location::findByAdress((object)$parsedData['location']);

       if ($locationId)
            $estate->location = $locationId->id;
        else {
            $location = new Location($parsedData['location']);
            $location->save();
            $estate->location = $location->id;
        }

        $patchData = (object) Arr::only((array) $parsedData, Estate::$patchable);

        foreach ($patchData as $key => $value)
            $estate->$key = $value;
        
        $estate->equipment()->detach();
        $estate->equipment()->attach($parsedData['additional_equipment']);

        $estate->save();
    }

    public function delete($uuid, $byAdmin = false){


        $estate = Estate::findByUuid($uuid);

        if ($estate->user_id != Auth::guard('sanctum')->user()->id && !$byAdmin)
            return false; //add error throw

        if ($byAdmin)
        if (in_array('Admin', User::findById(Auth::guard('sanctum')->user()->id)->getRoleNames()))
        Mail::to(User::findById($estate->user_id)->email)->send(new DeletedByAdmin($estate));

        $estate->delete();
    }

    public function create($data){
        $estate = new Estate();
        $user = User::findById(Auth::guard('sanctum')->user()->id);
        $parsedData = [];

        foreach ($data as $item)
        $parsedData[$item['name']] = $item['value'];
        
        $estate->user_id = $user->id;
        $locationId = Location::findByAdress((object)$parsedData['location']);
       if ($locationId)
            $estate->location = $locationId->id;
        else {
            $location = new Location($parsedData['location']);
            $location->save();
            $estate->location = $location->id;
        }

        $patchData = (object) Arr::only((array) $parsedData, Estate::$patchable);
        foreach ($patchData as $key => $value)
            $estate->$key = $value;
        
        $estate->info = json_encode($parsedData['info']);
        $estate->reported_count = 0;
        $estate->uuid = Str::uuid()->toString();
        $estate->save();
        $estate->equipment()->attach($parsedData['additional_equipment']);

        return $estate->uuid;
    }

    public function getwithIDs($uuid){
        $estate = Estate::findByUuid($uuid);
        $estate->equipment = EquipmentList::where('estate_id', $estate->id)->get()->pluck('equipment_id');
        $estate->location = Location::findById($estate->location);
        return $estate;
    }
}
?>
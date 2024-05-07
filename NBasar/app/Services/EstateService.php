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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class EstateService {
    

    public function __construct(private ErrorCheckService $errorCheck) {
    }

    public function search($request){
        $this->errorCheck->checkPaginateRequest($request);

        $query = Estate::query();
    
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
                $values = explode(',', $request->input($field));
                $query->whereIn($field, $values);
            }
        }
    
        if ($request->has('equipment') && !empty($request->input('equipment'))) {
            $equipmentIds = $request->input('equipment');
            $query->whereHas('equipment', function ($query) use ($equipmentIds) {
                $query->whereIn('equipment_id', $equipmentIds);
            });
        }
    
        if ($request->has('county') && !empty($request->input('county'))) {
            $countyIds = explode(',', $request->input('county'));
            $query->whereHas('elocation', function ($query) use ($countyIds) {
                $query->whereIn('county', $countyIds);
            });
        }

        $estates = $query->orderBy('id', 'desc')->paginate($request->input('limit'), ['*'], 'page', $request->input('page'));
        
        return [EstateResource::collection($estates),  $estates];
    }

    public function get($uuid){
        return new EstateResource(Estate::whereIn('uuid', [$uuid])->first());
    }

    public function getPaginated($key,$value,$request){
        $this->errorCheck->checkPaginateRequest($request);
        $estates = Estate::whereIn($key, $value)->paginate($request->input('limit'), ['*'], 'page', $request->input('page'));
        return [EstateResource::collection($estates), $estates];
    }

    public function getFavorites($id,$request){
       return $this->getPaginated('uuid',(array) User::findById($id)->watched_estates, $request);
    }

    public function patch($uuid, $data){
        $parsedData = $this->parseData($data);
        $estate = Estate::findByUuid($uuid);
        $locationId = Location::findByAdress((object)$parsedData['location']);
        
        $locationId ? $estate->location = $locationId->id : $estate->location = $this->createLocation($parsedData);

        $patchData = (object) Arr::only((array) $parsedData, Estate::$patchable);

        foreach ($patchData as $key => $value)
        $estate->$key = $value;

        $estate->equipment()->detach();
        $estate->equipment()->attach($parsedData['additional_equipment']);

        $estate->save();
    }

    public function delete($uuid){
        $estate = Estate::findByUuid($uuid);
        $user = User::findById(Auth::guard('sanctum')->user()->id);
        
        if ($estate->user_id != Auth::guard('sanctum')->user()->id && !$user->hasRole('Admin'))
        return false; //add error throw

       // if ($user->hasRole('Admin'))
        //Mail::to(User::findById($estate->user_id)->email)->send(new DeletedByAdmin($estate));

        $estate->delete();
    }

    public function create($data){
        $estate = new Estate();
        $user = User::findById(Auth::guard('sanctum')->user()->id);
        $parsedData = $this->parseData($data);
        
        $estate->user_id = $user->id;
        $locationId = Location::findByAdress((object)$parsedData['location']);
        $locationId ? $estate->location = $locationId->id : $estate->location = $this->createLocation($parsedData);

        $patchData = (object) Arr::only((array) $parsedData, Estate::$patchable);
        foreach ($patchData as $key => $value)
            $estate->$key = $value;
        
        $estate->info = json_encode($parsedData['info']);
        $estate->reported_count = 0;
        $estate->uuid = Str::uuid()->toString();
        $estate->images = [];
        $estate->save();
        $estate->equipment()->attach($parsedData['additional_equipment']);

        return $estate->uuid;
    }

    public function getwithIDs($uuid){
        $estate = Estate::findByUuid($uuid);
        $estate->additional_equipment = EquipmentList::where('estate_id', $estate->id)->get()->pluck('equipment_id');
        $estate->location = Location::findById($estate->location);
        return $estate;
    }

    private function createLocation($data){
        $location = new Location($data['location']);
        $location->save();
        return $location->id;
    }

    private function parseData($data){
        $parsedData = [];
        foreach ($data as $item)
        $parsedData[$item['name']] = $item['value'];
        
        $this->errorCheck->checkIfEmpty($parsedData,'Data');
        return $parsedData;
    }
}
?>
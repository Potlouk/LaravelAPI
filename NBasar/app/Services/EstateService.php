<?php
namespace App\Services;


use App\Mail\DeletedByAdmin;
use App\Models\Equipment;
use App\Models\Location;
use App\Models\RealEstate;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class EstateService {

    public function get($uuid){
        $estate = DB::table('estates')
        ->join('estate_locations', 'estates.location', '=', 'estate_locations.id')
        ->join('estate_ownership_types', 'estates.ownership_type', '=', 'estate_ownership_types.id')
        ->join('estate_energy_consumptions', 'estates.energy_consumption', '=', 'estate_energy_consumptions.id')
        ->join('estate_types', 'estates.type', '=', 'estate_types.id')
        ->join('estate_sub_types', 'estates.sub_type', '=', 'estate_sub_types.id')
        ->join('estate_building_material_types', 'estates.building_material', '=', 'estate_building_material_types.id')
        ->join('estate_conditions_types', 'estates.condition', '=', 'estate_conditions_types.id')
        ->join('users', 'estates.user_id', '=', 'users.id')
        ->select('estates.location as location','estates.title','estates.price','estates.floor','estates.uuid', 'estate_ownership_types.type as ownership_type', 
        'estate_energy_consumptions.type as energy_consumption', 'estate_types.type as type', 
        'estate_sub_types.type as sub_type', 'estate_building_material_types.type as building_material',
         'estate_conditions_types.type as condition', 'users.id as user_id', 'estates.reported_count','estates.info')
        ->where('estates.uuid', $uuid)
        ->first();

        $estate->location = Location::findById($estate->location);
        $estate->user = User::GetFilteredUser($estate->user_id);
        return $estate;
    }

    public function getAll($limit){
        $users = RealEstate::all()->paginate($limit);
        return $users;
    }
    public function patch($uuid, $data){
        $estate = RealEstate::findByUuid($uuid);
        $location = Location::findByAdress( (object) $data->location);
        
        if($location)
        $estate->location = $estate->id;
    else{
        $location = new Location($data->location);
        $location->save();
        $estate->location = $location->id;
    }
    
    if (!RealEstate::where('location', $location->id)->exists())
      $location->delete();

        $patchData = (object) Arr::only((array) $data, RealEstate::$patchable);

        foreach ($patchData as $key => $value)
            $estate->$key = $value;
        
        $estate->info = json_encode($data->info);
        $estate->save();
        return $estate;
    }

    public function delete($uuid, $byAdmin = false){
        $estate = RealEstate::findByUuid($uuid);

        if ($byAdmin)
        if (in_array('Admin', User::findById(Auth::guard('sanctum')->user()->id)->getRoleNames()))
        Mail::to(User::findById($estate->user_id)->email)->send(new DeletedByAdmin($estate));

        $estate->delete();
    }

    public function create($data){
        $estate = new RealEstate();
        $estate->user_id = $data->user_id;

        $locationId = Location::findByAdress((object)$data->location);
        if ($locationId)
            $estate->location = $locationId->id;
        else {
            $location = new Location($data->location);
            $location->save();
            $estate->location = $location->id;
        }

        $patchData = (object) Arr::only((array) $data, RealEstate::$patchable);
        foreach ($patchData as $key => $value)
            $estate->$key = $value;

        $estate->info = json_encode($data->info);
        $estate->reported_count = 0;
        $estate->uuid = Str::uuid()->toString();
        $estate->save();
        addEquipment($estate, $data->additional_equipment);
      
        return $estate->uuid;
    }
}

 function addEquipment(&$estate, $data){
     foreach ($data as $value){
        $equipment = new Equipment();
        $equipment->equipment_id = $value;
        $equipment->estate_id = $estate->id;
        $equipment->save();
     }
     
    $equipment->save();
    return $equipment->id;
}

?>
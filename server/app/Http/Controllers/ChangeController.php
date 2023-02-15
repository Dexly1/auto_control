<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;
use App\Models\ChangesList;
use App\Models\Auto;
use App\Models\AutoBrand;
use App\Models\AutoModel;

class ChangeController extends Controller
{
    public function allChanges() {
        $changes = DB::table("autos")
        ->join("changes_lists", "autos.id", '=', 'changes_lists.auto_id')
        ->join("auto_brands", "autos.brand_id", '=', 'auto_brands.id')
        ->join("auto_models", "autos.model_id", '=', 'auto_models.id')
        ->join("record_types", "changes_lists.record_type", '=', 'record_types.id')
        ->select(
            'changes_lists.id',
            'auto_brands.brand_name',
            'auto_models.model_name',
            'autos.register_sign',
            'record_types.record_type_name',
            'changes_lists.record_id',
            'changes_lists.comment',
            'changes_lists.img_old',
            'changes_lists.img_new',
            'changes_lists.create_date')
        ->orderBy('id', 'desc')
        ->get();

        return response()->json($changes);
    }
}

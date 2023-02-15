<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Intervention\Image\Facades\Image as Image;
use App\Models\Record;
use App\Models\RecordType;
use App\Models\Auto;
use App\Models\AutoBrand;
use App\Models\AutoModel;
use App\Models\ChangesList;

class RecordController extends Controller
{
    public function allRecords() {
        $records = DB::table("autos")
        ->join("records", "autos.id", '=', 'records.auto_id')
        ->join("auto_brands", "autos.brand_id", '=', 'auto_brands.id')
        ->join("auto_models", "autos.model_id", '=', 'auto_models.id')
        ->select(
            'records.id',
            'auto_brands.brand_name',
            'auto_models.model_name',
            'autos.register_sign',
            'records.auto_time_out',
            'records.edit_img_out',
            'records.img_out',
            'records.auto_time_in',
            'records.edit_img_in',
            'records.img_in',
            'records.created_at')
        ->where('auto_time_in', '<>', 0)
        ->orderBy('id', 'desc')
        ->get();
        return response()->json($records);
    }

    public function getRecord($id) {
        $record = Record::find($id);
        return response()->json($record);
    }

    public function allRecordTypes() {
        $recordtypes = RecordType::all();
        return response()->json($recordtypes);
    }

    public function addRecord(Request $req) {
        $record = new Record([
            'auto_id' => $req->input('auto_id'),
            'img_out' => $req->input('img_out'),
            'auto_time_out' => now('GMT+3'),
            'edit_img_out' => 0
        ]);
    
        $record->save();
        
        return response()->json($record->id);
    }

    public function editRecord(Request $req) {
        $record = Record::find($req->id);
        $record->auto_id = $req->auto_id;
        $record->img_out = $req->img_out;
        $record->edit_img_out = $req->edit_img_out;
        $record->auto_time_out = $req->auto_time_out;
        $record->img_in = $req->img_in;
        $record->edit_img_in = $req->edit_img_in;
        $record->auto_time_in = $req->auto_time_in;
        $record->save();

        return response()->json("asd");
    }

    public function updateRecord(Request $req, $id) {
        $auto = Auto::find($id);

        $record = Record::find($auto->current_record);
        $record->img_in = $req->img_in;
        $record->auto_time_in = now('GMT+3');
        $record->edit_img_in = 0;
        $record->save();

        $autoused = Auto::find($id);
        $autoused->current_record = null;
        $autoused->save();

        return response()->json("asd");
    }

    public function upload(Request $req) {
        $path = $req->file('image')->store('', 'public');       

        // $this->validate($req, [
        //     'file' => 'required|mimes:jpg,jpeg,png'
        // ]);
            //$x = 10;
            //$image = $req->file('image');
            // $filename = time().'_'.$file->getClientOriginalName(); 
            // $img = \Image::make($image);
            // $image->save(\public_path($filename), $x);
        

        return response()->json($path);
    }

    public function accessEditOut(Request $req, $id) {
        $record = Record::find($id);

        $record->edit_img_out = $req->value;
        $record->save();

        return response()->json($record->edit_img_out);
    }

    public function accessEditIn(Request $req, $id) {
        $record = Record::find($id);

        $record->edit_img_in = $req->value;
        $record->save();

        return response()->json($record->edit_img_in);
    }

    public function addChange(Request $req) {
        $record = Record::find($req->id);
        if ($req->record_type == 0)
        $img = $record->img_out;
        else
        $img = $record->img_in;

        $change = new ChangesList([
            'auto_id' => $record->auto_id,
            'record_id' => $record->id,
            'record_type' => $req->record_type,
            'comment' => $req->comment,
            'img_old' => $img,
            'img_new' => $req->img,
            'create_date' => now('GMT+3')
        ]);

        $change->save();

        return response()->json($change);
    }

    public function editImage(Request $req) {
        $record = Record::find($req->id);

        if ($req->record_type == 0) {
            $record->img_out = $req->img;
            $record->edit_img_out = 0;
        }
        else
        {
            $record->img_in = $req->img;
            $record->edit_img_in = 0;
        }

        $record->save();

        return response()->json("asd");
    }
}

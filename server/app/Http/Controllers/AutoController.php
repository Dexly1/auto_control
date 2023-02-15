<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Auto;
use App\Models\AutoModel;
use App\Models\AutoBrand;

class AutoController extends Controller
{
    //ВЫБОРКИ

    //Вывод всех автомобилей
    public function allAutos() {
        $autos = Auto::addSelect(['brand_name' => AutoBrand::select('brand_name')
        ->whereColumn('auto_brands.id','autos.brand_id')])
        ->addSelect(['model_name' => AutoModel::select('model_name')
        ->whereColumn('auto_models.id','autos.model_id')])
        ->get();
        return response()->json($autos);
    }

    //Вывод всех автомобилей НА ПАРКОВКЕ
    public function allAutosInPlace() {
        $autos = Auto::addSelect(['brand_name' => AutoBrand::select('brand_name')
        ->whereColumn('auto_brands.id','autos.brand_id')])
        ->addSelect(['model_name' => AutoModel::select('model_name')
        ->whereColumn('auto_models.id','autos.model_id')])
        ->get()
        ->where('current_record', 0);
        return response()->json($autos);
    }

    //Вывод всех автомобилей НА ВЫЕЗДЕ
    public function allAutosOutPlace() {
        $autos = Auto::addSelect(['brand_name' => AutoBrand::select('brand_name')
        ->whereColumn('auto_brands.id','autos.brand_id')])
        ->addSelect(['model_name' => AutoModel::select('model_name')
        ->whereColumn('auto_models.id','autos.model_id')])
        ->get()
        ->where('current_record', '>', 0);
        return response()->json($autos);
    }

    //Вывод всех марок
    public function allBrands() {
        $brands = AutoBrand::all();
        return response()->json($brands);
    }

    //Вывод всех моделей и марок, которым они принадлежат
    public function allModels() {
        $models = AutoModel::select("id", "brand_id", "model_name")
        ->addSelect(['brand_name' => AutoBrand::select('brand_name')
        ->whereColumn('auto_models.brand_id','auto_brands.id')])
        ->orderBy('brand_name', 'asc')
        ->get();
        return response()->json($models);
    }
    
    //Вывод всех моделей определенной марки
    public function allModelsByBrand($id) {
        $models = AutoModel::select("id", "brand_id", "model_name")
        ->where('brand_id',$id)
        ->get();
        return response()->json($models);
    }

    //ДОБАВЛЕНИЯ

    //Добавление автомобиля
    public function addAuto(Request $req) {
        $auto = new Auto([
            'brand_id' => $req->input('brand_id'),
            'model_id' => $req->input('model_id'),
            'register_sign' => $req->input('register_sign')
        ]);
    
        $auto->save();
        return response()->json('auto created');
    }

    //Добавление марки
    public function addBrand(Request $req) {
        $brand = new AutoBrand([
            'brand_name' => $req->input('brand_name'),
        ]);
    
        $brand->save();
        return response()->json('brand created');
    }

    //Добавление модели
    public function addModel(Request $req) {
        $model = new AutoModel([
            'brand_id' => $req->input('brand_id'),
            'model_name' => $req->input('model_name')
        ]);
    
        $model->save();
        return response()->json('model created');
    }

    public function updateAuto(Request $req, $id) {
        $auto = Auto::find($id);
        $auto->current_record = $req->current_record;
        $auto->save();
        return response()->json('asd');
    }

    //УДАЛЕНИЯ

    public function deleteAuto($id){
        $auto = Auto::findOrFail($id);
        $auto->delete();
    }

    public function deleteBrand($id){
        $brand = AutoBrand::findOrFail($id);
        $brand->delete();
    }   

    public function deleteModel($id){
        $model = AutoModel::findOrFail($id);
        $model->delete();
    }   
}

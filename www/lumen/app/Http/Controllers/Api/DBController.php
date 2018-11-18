<?php
/**
 * Created by PhpStorm.
 * User: roydekleijn
 * Date: 30/07/2017
 * Time: 19:59
 */

namespace TestApi\Http\Controllers;

use Illuminate\Support\Facades\DB;
use TestApi\Models\ActorModel;
use TestApi\Models\AddressModel;
use TestApi\Models\CategoryModel;
use TestApi\Models\CityModel;
use TestApi\Models\CountryModel;
use TestApi\Models\CustomerModel;
use TestApi\Models\FilmModel;
use TestApi\Models\InventoryModel;
use TestApi\Models\LanguageModel;
use TestApi\Models\PaymentModel;
use TestApi\Models\RentalModel;
use TestApi\Models\StaffModel;
use TestApi\Models\StoreModel;

class DBController extends Controller

{

    public function reset()
    {

        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

//        ActorModel::truncate();
//        AddressModel::truncate();
//        CategoryModel::truncate();
//        CityModel::truncate();
//        CountryModel::truncate();
//        CustomerModel::truncate();
//        FilmModel::truncate();
//        DB::table('film_actor')->truncate();
//        DB::table('film_category')->truncate();
//        DB::table('film_text')->truncate();
//        InventoryModel::truncate();
//        LanguageModel::truncate();
//        PaymentModel::truncate();
//        RentalModel::truncate();
//        StaffModel::truncate();
//        StoreModel::truncate();
        DB::table('users')->truncate();


//        $path = getcwd() . '/../../test-api/database/seeds/sakila-data.sql';
//        DB::unprepared(file_get_contents($path));
        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return response()->json("ok");
    }

}
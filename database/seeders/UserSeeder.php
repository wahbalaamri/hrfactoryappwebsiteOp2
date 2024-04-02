<?php

namespace Database\Seeders;

use App\Models\Clients;
use App\Models\FocalPoints;
use App\Models\PolicyMBFile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // check if Users table is empty
        if (\App\Models\User::count() > 0) {
            return;
        }
        $contents = json_decode(file_get_contents('https://www.hrfactoryapp.com/Home/shipData'), true);
        //insert content to database
        foreach ($contents['users'] as  $user) {
            if ($user['IsAdmin'] == 1) {
                //create new admin
                $admin = User::where('email', $user['Email'])->get()->first();
                $admin = $admin == null ? new User() : $admin;
                $admin->name = $user['Name'];
                $admin->email = $user['Email'];
                $admin->client_id = null;
                $admin->sector_id = null;
                $admin->comp_id = null;
                $admin->dep_id = null;
                $admin->user_type = 'admin';
                $admin->isAdmin = true;
                $admin->password = bcrypt($user['Password']);
                $admin->is_active = $user['IsDeleted'] == 1 ? false : true;
                //delete_at
                $admin->deleted_at = $user['IsDeleted'] == 1 ? now()->format('Y-m-d H:i:s') : null;
                $admin->save();

                //seed policy file
                $PloicyFile = new PolicyMBFile();
                $PloicyFile->user_id = $admin->id;
                $PloicyFile->name = $user['DocumentName'];
                $PloicyFile->name_ar = $user['DocumentNameAr'];
                $PloicyFile->save();
            } else {
                //create new client
                $olduser = User::where('email', $user['Email'])->get()->first();
                if ($olduser == null) {

                    $client = new Clients();
                    $client->name = $user['Name'];
                    $client->name_ar = $user['NameAr'];
                    $client->country = $user['CountryId'];
                    $client->industry = $user['IndustryId'];
                    $client->client_size = $user['NumberOFEmployees'];
                    $client->partner_id = null;
                    $client->logo_path = null;
                    $client->webiste = null;
                    $client->use_sections = true;
                    $client->is_active = $user['IsDeleted'] == 1 ? false : true;
                    //delete_at
                    $client->deleted_at = $user['IsDeleted'] == 1 ? now()->format('Y-m-d H:i:s') : null;
                    $client->save();
                    //create new focal point
                    $focal_point = new FocalPoints();
                    $focal_point->client_id = $client->id;
                    $focal_point->name = $user['ContactPerson'];
                    $focal_point->name_ar = $user['ContactPerson'];
                    $focal_point->email = $user['Email'];
                    $focal_point->phone = $user['ContactInformation'];
                    $focal_point->position = null;
                    $focal_point->is_active = $user['IsDeleted'] == 1 ? false : true;
                    //delete_at
                    $focal_point->deleted_at = $user['IsDeleted'] == 1 ? now()->format('Y-m-d H:i:s') : null;
                    $focal_point->save();
                    //seed users
                    $user_ = new User();
                    $user_->name = $user['Name'];
                    $user_->email = $user['Email'];
                    $user_->client_id = $client->id;
                    $user_->sector_id = null;
                    $user_->comp_id = null;
                    $user_->dep_id = null;
                    $user_->user_type = 'client';
                    $user_->isAdmin = false;
                    $user_->password = bcrypt($user['Password']);
                    $user_->is_active = $user['IsDeleted'] == 1 ? false : true;
                    //delete_at
                    $user_->deleted_at = $user['IsDeleted'] == 1 ? now()->format('Y-m-d H:i:s') : null;
                    $user_->save();
                    //seed policy file
                    $PloicyFile = new PolicyMBFile();
                    $PloicyFile->user_id = $client->id;
                    $PloicyFile->name = $user['DocumentName'];
                    $PloicyFile->name_ar = $user['DocumentNameAr'];
                    $PloicyFile->save();
                }
            }
        }
    }
}

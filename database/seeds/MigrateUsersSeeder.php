<?php

use Illuminate\Database\Seeder;


class MigrateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        $this->command->info("Migrating User table");
    
        $old_users = DB::connection('old')->select('SELECT * FROM users ORDER BY id');

        $old_users_distinct = \DB::connection('old')->select('SELECT DISTINCT(usercountry) as country FROM users');


        $countries = \App\Models\Country::get();

        foreach ($countries as $country){
            foreach ($old_users_distinct as $k => $old)
                if($old->country) {
                    if ($country->full_name == trim($old->country) || $country->name == trim($old->country) ) {
                        $array[$country->country_code] = trim($old->country);
                        $a[]=$country->country_code;
                        unset($old_users_distinct[$k]);
                    }
                }
        }

        $countries = \App\Models\Country::whereNotIn('country_code',$a)->get();
        foreach ($countries as $country){
            foreach ($old_users_distinct as $k => $old)
                if($old->country) {
                    if((stristr($country->name, trim($old->country)) !== false) || (stristr($country->full_name, trim($old->country)) !== false) ){
                        $array[$country->country_code] = trim($old->country);
                        unset($old_users_distinct[$k]);
                    }
                }
        }



        $c = 0;

        DB::table('users')->delete();

        foreach ($old_users as $old_user) {

            // show some progress dots
            $c++;
            if ($c % 200 == 0) echo $c;
            
            $user = new \App\Models\User();
            $user->email = $old_user->useremail;
            $user->password = '';
            $user->password_old = $old_user->userpassword;
            $user->first_name = $old_user->userfirstname;
            $user->last_name = $old_user->userlastname;
            $user->nick_name = $old_user->usernickname;
            $user->gender = $old_user->usersex;
            if($old_user->useractive == 'yes')
                $old_user->useractive = 1;
            else
                $old_user->useractive = 0;
            $user->activated = $old_user->useractive;
            //$user->birthday = $old_user->userbirthday;
            $user->postcode = $old_user->userpostcode;
            $user->address =  $old_user->useraddress;

            if(array_search(trim($old_user->usercountry), $array))
                $user->country_code = array_search(trim($old_user->usercountry), $array);
            else
                $user->country_old = trim($old_user->usercountry);

            $user->tel_mobile = $old_user->usermobiletel;
            $user->tel_home = $old_user->userhomeno;
            if($old_user->lastlogin == '0000-00-00 00:00:00')
                $old_user->lastlogin = NULL;
            $user->last_login_time = $old_user->lastlogin;
            $user->save();

        }
    
        $this->command->info(".");
    
    }
}

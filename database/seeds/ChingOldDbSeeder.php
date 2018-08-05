<?php

use Illuminate\Database\Seeder;

class ChingOldDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $this->command->info("Dropping all exising tables (may take some time)...");

        $tables = DB::connection('old')->select('SHOW TABLES');

        if (count($tables)>0) {
            $droplist = [];
            foreach($tables as $table) {
        
                $droplist[] = $table->Tables_in_ching_old;
        
            }
    
            $droplist = implode(',', $droplist);
    
            DB::connection('old')->beginTransaction();
            //turn off referential integrity
            //DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            DB::connection('old')->statement("DROP TABLE $droplist");
            //turn referential integrity back on
            //DB::statement('SET FOREIGN_KEY_CHECKS = 1');
            DB::connection('old')->commit();
        }
        

        $this->command->info("Inserting old Ching site database (may take some time)...");

        $this->command->comment("--- mysql command line output ---");
        passthru("cat ". database_path('database_old/ching_old.sql') ." | mysql -u ".\Config::get('database.connections.old.username')." -p".\Config::get('database.connections.old.password')." ".\Config::get('database.connections.old.database'));
        $this->command->comment("---------------------------------");

        //var_dump($result);
        $this->command->info("Finished inserting old database.");

    }

}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@biltk.com',
            'created_at' => date("Y-m-d H:i:s"),
            'password' => bcrypt('secret'),
        ]);

        DB::table('roles')->insert([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);
        */

        $this->call('LinkCodeGenerate');
    }
}


class LinkCodeGenerate extends Seeder
{
    public function run()
    {
        $links = DB::table('links')->get();

        foreach($links as $link)
        {
            $code = $this->generateCode();

            DB::table('links')->where('id', $link->id)
            ->update(['code' => $code]);
        }
    }


    function generateCode()
    {
        $random_string = "";

        $numeric = false;

        $not_exists = true;

        while ($not_exists)
        {
            $length = 10;

            while(strlen($random_string) < $length && $length > 0) 
            {
                if($numeric === false) 
                {
                    $randnum = mt_rand(0,61);

                    $random_string .= ($randnum < 10) ? chr($randnum+48) : ($randnum < 36 ?  chr($randnum+55) : $randnum+61);
                } 
                else 
                {
                    $randnum = mt_rand(0,9);
                    $random_string .= chr($randnum+48);
                }
            }
            
            $not_exists = DB::table('links')->where('code', $random_string)->get()->toArray();    

            
        }

        return $random_string;
    }
}

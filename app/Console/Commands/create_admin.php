<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use DB;
use Illuminate\Console\Command;

class create_admin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin  {name} {email} {pass}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('pass');

        $validName = false;
        $validEmail = false;
        $validPassword = false;

        if (strlen($password) >= 6) {
            $validPassword = true;
        } else {
            $this->error('The password must be at least 6 characters in length');
        }

        if (strlen($name) >= 3) {
            $validName = true;
        } else {
            $this->error('The name must be at least 3 characters in length');
        }

        if (stristr($email, '@') && stristr($email, '.')) {
            $validEmail = true;
        } else {
            $this->error('Invalid email');
        }



        if ($validName == true && $validEmail == true && $validPassword == true) {
            $user =  User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

            DB::table('users_roles')->insert([
            'user_id' => $user->id,
            'role_id' => 1
            ]);

            
            $this->line('Admin create successfully!');
        }
    }
}

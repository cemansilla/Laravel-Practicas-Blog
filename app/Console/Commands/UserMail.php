<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserWelcome;
use App\User;

class UserMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:mail 
                            {id=0 : Representa al ID de usuario}
                            {--flag=0 : Condicional}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio email a un usuario';

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
     * @return int
     */
    public function handle()
    {
        $uid = (int) $this->argument('id');

        if($uid > 0){
            $user = User::find($uid);
    
            if($user){
                $option = $this->option('flag');
                echo $option . PHP_EOL;
                Mail::to($user->email)->send(new UserWelcome($user));
                echo "Email enviado.".PHP_EOL;
            }else{
                echo sprintf("El usuario de id %s no existe.".PHP_EOL, $uid);
            }
        }else{
            echo "El parámetro id es incorrecto.".PHP_EOL;
        }
    }
}

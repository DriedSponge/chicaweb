<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SetAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-admin {discordID} {--revoke}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets the given discord ID as an admin. Note: The user must be seeded first.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $discordID =  $this->argument("discordID");
        try{
            $user = User::where(['did'=>$discordID])->firstOrFail();
            if ($this->hasOption("revoke")){
                $user->admin = false;
                echo $user->admin ;
                $user->save();
                $this->info("User ".$user->name." (".$user->did.") has had their admin access revoked.");
            }else if($user->admin){
               if($this->confirm("This user is already an admin. Would you like to revoke their access?")){
                   $user->admin = false;
                   $user->save();
                   $this->info("User ".$user->name." (".$user->did.") has had their admin access revoked.");
               }else{
                   $this->info("No action was taken.");
               };
            }else{
                $user->admin = true;
                $user->save();
                $this->info("User ".$user->name." (".$user->did.") has been granted admin access.");
            }
        }catch (ModelNotFoundException){
            $this->error("User not found by discordID ".$discordID.".");
        }
    }
}

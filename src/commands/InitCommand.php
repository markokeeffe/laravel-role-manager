<?php namespace MOK\RoleManager;
/**
 * Author:  Mark O'Keeffe

 * Date:    04/09/13
 *
 * [Laravel Workbench] InitCommand.php
 */
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InitCommand extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'rolemanager:init';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Sets up a Superuser role and assigns it to a user.';


  /**
   * Initialise the role manager superuser by:
   *  - Creating a Superuser role
   *  - Finding a user to attach the role to
   *  - Attaching the Superuser role to the user
   */
  public function fire()
  {
    $user_id = $this->option('user_id');
    $roleName = $this->option('superuser_role');

    $user = User::find($user_id);
    if (!$user) {
      $this->error('Unable to load user with ID '.$user_id
        .'. Please specify a valid user ID (php artisan rm:init --user_id=2)');
    }

    $role = Role::where('name', '=', $roleName)->first();

    if (!$role) {
      $this->line('Creating Superuser role...');
      $role = new Role(array(
        'name' => 'Superuser',
      ));
      if (!$role->save()) {
        $this->error('Unable to save Superuser role...');
      }

    } else {
      $this->line('Superuser role already exists.');
    }

    if ($user->hasRole($roleName)) {
      $this->error('User: '.$user->username.' is already Superuser!');
    }

    $user->roles()->attach($role->id);

    $this->line('Superuser role attached to user: '.$user->username);


  }


  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions()
  {
    return array(
      array('user_id', 'id', InputOption::VALUE_OPTIONAL, 'Superuser ID.', 1),
      array('superuser_role', null, InputOption::VALUE_OPTIONAL, 'Superuser Role Name.', 'Superuser'),
    );
  }
}

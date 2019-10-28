<?php


namespace Drupal\bwinsurance_dev;


use Drupal;
use Drupal\user\Entity\Role;
use Drupal\user\Entity\User;
use RuntimeException;

class DevelFixtures extends Drupal\data_fixtures\AbstractGenerator implements Drupal\data_fixtures\Interfaces\Generator {

  /**
   * Load fixture.
   *
   * @return void
   */
  public function load() {
    $this->addFixtureUsers();
  }

  /**
   * Unloads fixture.
   */
  public function unload() {
    throw new RuntimeException('Not yet implemented');
  }

  /**
   * Adds all fixture users.
   */
  protected function addFixtureUsers() {
    // Ensure a user of each role type exists.  Their login
    // will be [role_type]@example.com, with password 123456.
    array_map(
      function (Role $r) {
        $ids = Drupal::entityQuery('user')
          ->condition('status', 1)
          ->condition('roles', $r->id())
          ->execute();
        $users = User::loadMultiple($ids);
        if (empty($users)) {
          // Create a single fixture with this role.
          User::create(
            [
              'name' => $r->label(),
              'email' => sprintf('%s@example.com', $r->label()),
              'password' => '123456',
            ]
          )->save();

        }
      },
      Role::loadMultiple()
    );
  }
}

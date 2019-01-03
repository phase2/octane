<?php

namespace Octane\Tests\ExistingSite;

/**
 * Demonstrates how to use ExistingSite tests.
 *
 * Unlike the other PHPUnit-based test types, ExistingSite tests run against the
 * fully-configured site. This is similar to Behat, but allows testing things
 * that Behat was never meant to test.
 *
 * Thinks like access, views, content types, and other heavily configuration-
 * dependent things are ideally suited for this type of test since any enabled
 * module can potentially alter the expected behavior of these things.
 *
 * Additional tests can be placed in this namespace/directory, but typically in
 * a project they will go into a base module, or a module specifically related
 * to the test: `src/modules/foo_base/tests/src/ExistingSite`.
 *
 * @group octane
 */
class FrontPageTest extends OctaneExistingSiteTestBase {

  /**
   * An authenticated user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $normalUser;

  /**
   * An admin user.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $adminUser;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    // Typically a user is created with no arguments and a role is assigned later.
    // This differs from the other phpunit test types where roles are unimportant,
    // but permissions are. Since this is just an authenticated user, no special
    // permissions or roles are assigned.
    //
    // Users (and nodes and terms) created this way are automatically removed
    // in the `tearDown` method. See the parent classes for more details.
    //
    // Additional entity types can be added for cleanup by simply calling:
    //
    // @code
    //   $this->markEntityForCleanup($entity);
    // @endcode
    $this->normalUser = $this->createUser();

    // Create an administrator user. This assumes the site has a role called
    // 'administrator'.
    $this->adminUser = $this->createUser();
    $this->adminUser->addRole('administrator');
    $this->adminUser->save();
  }

  /**
   * Tests the front page as an anonymous user.
   */
  public function testAnonymous() {
    $this->visit('/');
    $this->assertSession()->statusCodeEquals(200);
  }

  /**
   * Tests the front page as a normal authenticated user.
   */
  public function testAuthenticated() {
    $this->drupalLogin($this->normalUser);
    $this->visit('/');
    $this->assertSession()->statusCodeEquals(200);

    // Admin pages should not be available.
    $this->visit('/admin');
    $this->assertSession()->statusCodeEquals(403);
  }

  /**
   * Tests the front page as an admin and performs other operations.
   */
  public function testAdmin() {
    $this->drupalLogin($this->adminUser);
    $this->visit('/');
    $this->assertSession()->statusCodeEquals(200);

    // Admin pages should be available.
    $this->visit('/admin');
    $this->assertSession()->statusCodeEquals(200);
  }

}

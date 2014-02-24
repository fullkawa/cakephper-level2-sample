<?php
App::uses('User', 'Model');

/**
 * User Test Case
 *
 */
class UserTest extends CakeTestCase {

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array('app.user');

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        $this->User = ClassRegistry::init('User');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->User);

        parent::tearDown();
    }

    /**
     * 登録中の場合、trueとなる。
     */
    public function testIsRegisted_true() {
        $user = array('User' => array('registed' => '2014-01-02 03:04:56', 'canceled' => null));
        $result = $this->User->isRegisted($user);

        $this->assertEquals(true, $result);
    }

    /**
     * 未登録の場合、falseとなる。
     */
    public function testIsRegisted_false_1() {
        $user = array('User' => array('registed' => null, 'canceled' => null));
        $result = $this->User->isRegisted($user);

        $this->assertEquals(false, $result);
    }

    /**
     * 解約済みの場合、falseとなる。
     */
    public function testIsRegisted_false_2() {
        $user = array('User' => array('registed' => '2014-01-02 03:04:56', 'canceled' => '2014-02-03 23:59:59'));
        $result = $this->User->isRegisted($user);

        $this->assertEquals(false, $result);
    }
}

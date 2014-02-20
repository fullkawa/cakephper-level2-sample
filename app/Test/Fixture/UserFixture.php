<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'ID'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'comment' => '??', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 16, 'collate' => 'utf8_general_ci', 'comment' => '?????', 'charset' => 'utf8'),
		'registed' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '????'),
		'canceled' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '????'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '????'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null, 'comment' => '????'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum do',
			'registed' => '2014-02-20 10:43:51',
			'canceled' => '2014-02-20 10:43:51',
			'created' => '2014-02-20 10:43:51',
			'modified' => '2014-02-20 10:43:51'
		),
	);

}

<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Permission_privilege extends Model {

	/**
	 *
	 * @var integer
	 */
	public $id;

	/**
	 *
	 * @var string
	 */
	public $name;

	/**
	 *
	 * @var string
	 */
	public $controller;

	/**
	 *
	 * @var string
	 */
	public $action;

	/**
	 *
	 * @var integer
	 */
	public $position;


	public function columnMap()
	{
		return array(
				'id'        =>  'id',
				'name'      =>  'name',
				'controller'=>  'controller',
				'action'    =>  'action',
				'position'  =>  'position',
		);
	}

	public function initialize(){

	}


}
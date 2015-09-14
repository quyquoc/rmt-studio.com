<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Permission_group_privilege extends Model {

	/**
	 *
	 * @var integer
	 */
	public $id;

	/**
	 *
	 * @var string
	 */
	public $privilege_id;

	/**
	 *
	 * @var string
	 */
	public $group_id;

	/**
	 *
	 * @var string
	 */
	public $status;


	public function columnMap()
	{
		return array(
				'id'        	=>  'id',
				'privilege_id'  =>  'privilege_id',
				'group_id'		=>  'group_id',
				'status'    	=>  'status',
		);
	}

	public function initialize(){
		$this->belongsTo('privilege_id', '\Modules\Backend\Models\Permission_privilege', 'id', array(
				'alias' => 'privilege',
				'reusable' => true
		));
		
		$this->belongsTo('group_id', '\Modules\Backend\Models\Permission_group', 'id', array(
				'alias' => 'group',
				'reusable' => true
		));
	}


}
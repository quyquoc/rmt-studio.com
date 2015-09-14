<?php

namespace Modules\Backend\Models;

use Phalcon\Mvc\Model;

class Permission_resource_config extends Model {

	/**
	 *
	 * @var integer
	 */
	public $id;

	/**
	 *
	 * @var string
	 */
	public $resource_id;

	/**
	 *
	 * @var string
	 */
	public $config_id;




	public function columnMap()
	{
		return array(
				'id'        	=>  'id',
				'resource_id'  =>  'resource_id',
				'config_id'		=>  'config_id',
		);
	}

	public function initialize(){
		$this->belongsTo('resource_id', '\Modules\Backend\Models\Permission_resource', 'id', array(
				'alias' => 'resource',
				'reusable' => true
		));
		
		$this->belongsTo('config_id', '\Modules\Backend\Models\Permission_config', 'id', array(
				'alias' => 'config',
				'reusable' => true
		));
	}


}
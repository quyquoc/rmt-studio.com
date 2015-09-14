<?php
namespace Modules\Backend\Forms;
use Phalcon\Forms\Form,
Phalcon\Forms\Element\Text,
Phalcon\Forms\Element\TextArea,
Phalcon\Forms\Element\Select,
Phalcon\Forms\Element\Hidden,
Phalcon\Forms\Element\Password,
Phalcon\Validation\Validator\PresenceOf,
Phalcon\Validation\Validator\Email;
use \Modules\Backend\Models\Member_Department,
	\Modules\Backend\Models\Permission_Group;
class Member extends Form {


	public function initialize(){	

        $this->add(new Text("firstname"));
        $lastname = new Text("lastname");
        $this->add($lastname);


        $username = new Text("username");
        $username->setFilters(array('striptags', 'string'));
		$username->addValidators(array(new PresenceOf()));
        $this->add($username);
        

        // password
    	$password = new Password('password');
		$password->addValidator(new PresenceOf(array(
				'message' => 'password'
		)));
        $this->add($password);

        $this->add(new Text("avatar"));

        $email = new Text("email");
		$email->addValidators(array(new PresenceOf(),new Email()));
        $this->add($email);


		$this->add(new Select('gender',array('0'=>'Nữ','1'=>'Nam')));
		
		$this->add(new Text("birthday"));
		$this->add(new Text("address"));
		$this->add(new Text("phone"));

		$this->add(new Select('gender',array('0'=>'Không','1'=>'Có')));
		$this->add(new Select('status',array('0'=>'Không','1'=>'Có'),array('class'=>'medium')));

		$department_id = new Select('department_id',\Modules\Backend\Models\Member_department::find(), array('using' => array('id', 'name'),'class'=>'medium'));
		$this->add($department_id);
		
		$group_id = new Select('group_id',\Modules\Backend\Models\Permission_group::find(), array('using' => array('id', 'name'),'class'=>'medium'));
		$this->add($group_id);

	}
}

/* End of file Member.php */
/* Location: ./apps/backend/forms/Member.php */


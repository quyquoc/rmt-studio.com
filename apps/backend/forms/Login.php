<?php

namespace Modules\Backend\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;

class Login extends Form
{

    public function initialize()
    {
        // username
        $username = new Text('username', array(
            'placeholder' => 'Username or Email'
        ));

        $username->addValidators(array(
            new PresenceOf(array(
                'message' => 'The e-mail is required'
            ))
        ));

        $this->add($username);

        // Password
        $password = new Password('password', array(
            'placeholder' => 'Password'
        ));

        $password->addValidator(new PresenceOf(array(
            'message' => 'The password is required'
        )));

        $this->add($password);

        $this->add(new Submit('go', array(
            'class' => 'btn btn-success',
            'value' =>  'Login'
        )));
    }
}

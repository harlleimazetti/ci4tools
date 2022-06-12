<?php namespace Harlleimazetti\Ci4tools\Auth\Validation;

class PasswordValidation
{
	protected $rules = [
    'password' => [
      'rules'  => 'required|min_length[8]|max_length[14]|regex_match[/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}\S+$/]',
      'errors' => [
        'required'    => 'Campo Senha não foi informado corretamente',
        'min_length'  => 'Senha deve ter entre 8 e 14 caracteres',
        'max_length'  => 'Senha deve ter entre 8 e 14 caracteres',
        'regex_match' => 'Senha deve ter obrigatoriamente pelo menos 1 letra minúscula, 1 letra maiúscula, 1 número e 1 caractere especial (#?!@$%^&*-)',
      ],
    ],
    'password_confirm' => [
      'rules'  => 'required|matches[password]',
      'errors' => [
        'required' => 'Campo Confirmar Senha não foi informado corretamente',
        'matches'  => 'Campo Senha e Confirmar Senha não conferem',
      ],
    ],
  ];

	function __construct() {

	}

  public function getRules()
  {
    return $this->rules;
  }
}

/* End of File PasswordValidation.php */
/* Path: ./vendor/Harlleimazetti/Ci4tools/src/Auth/Validation/PasswordValidation.php */

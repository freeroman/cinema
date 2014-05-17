<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Nette\Application\UI\Form;
		$form->addText('username', 'Login:')
			->setRequired('Please enter your username.')
                        ->setAttribute('class', 'form-control')
                        ->setAttribute('placeholder', 'Enter login');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.')
                        ->setAttribute('class', 'form-control')
                        ->setAttribute('placeholder', 'Password');

		$form->addCheckbox('remember', ' Keep me signed in');

		$form->addSubmit('send', 'Sign in')
                        ->setAttribute('class', 'btn btn-default');
                
                $renderer = $form->getRenderer();
                $renderer->wrappers['controls']['container'] = null;
                //$renderer->wrappers['pair']['container'] = 'div class=form-group';
                $renderer->wrappers['pair']['.error'] = 'has-error';
                $renderer->wrappers['control']['container'] = 'div class=form-group';
                //$renderer->wrappers['label']['container'] = 'small';
                $renderer->wrappers['control']['description'] = 'span class=help-block';
                $renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';

		// call method signInFormSucceeded() on success
		$form->onSuccess[] = $this->signInFormSucceeded;
		return $form;
	}


	public function signInFormSucceeded($form)
	{
		$values = $form->getValues();

		if ($values->remember) {
			$this->getUser()->setExpiration('14 days', FALSE);
		} else {
			$this->getUser()->setExpiration('20 minutes', TRUE);
		}

		try {
			$this->getUser()->login($values->username, $values->password);
			$this->redirect('Administration:');

		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($e->getMessage());
		}
	}


	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.', 'warning');
		$this->redirect('in');
	}

}

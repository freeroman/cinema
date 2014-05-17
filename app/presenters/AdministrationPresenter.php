<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Sign in/out presenters.
 */
class AdministrationPresenter extends SecurePresenter
{
    protected function createComponentNewPerformance()
    {
        $form = new Nette\Application\UI\Form;
        $form->addText('start_dt', 'Start:')
                ->addRule(Nette\Application\UI\Form::PATTERN, 'Start date time format is wrong.', '(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2})')
                ->setRequired('Please enter start time.')
                ->setAttribute('class', 'form-control')
                ->setAttribute('placeholder', 'Example 2014-05-19 14:00');
        $form->addSelect('film', 'Film', $this->context->cinema->getFilms())
                ->setAttribute('class', 'form-control')
                ->setRequired('Please enter film.');
        $form->addSelect('cinema', 'Cinema', $this->context->cinema->getCinemas())
                ->setAttribute('class', 'form-control')
                ->setRequired('Please enter your cinema.');

        $form->addSubmit('send', 'Create')
                ->setAttribute('class', 'btn btn-default');

        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = null;
        $renderer->wrappers['pair']['.error'] = 'has-error';
        $renderer->wrappers['control']['container'] = 'div class=form-group';
        $renderer->wrappers['control']['description'] = 'span class=help-block';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';

        // call method signInFormSucceeded() on success
        $form->onSuccess[] = $this->newPerformanceFormSucceeded;
        return $form;
    }


    public function newPerformanceFormSucceeded($form)
    {
        $values = $form->getValues();

        $performance = array(
            'id_cinemas' => 1,
            'id_films' => $values['film'],
            'id_cinemas' => $values['cinema'],
            'start_dt' => $values['start_dt']
        );

        $this->context->cinema->insertPerformance($performance);
        $this->flashMessage('Performance has been added.', 'success');
        $this->redirect('this');
    }
    
    protected function createComponentNewFilm()
    {
        $form = new Nette\Application\UI\Form;
        $form->addText('name', 'Name')
                ->setAttribute('class', 'form-control')
                ->setAttribute('placeholder', 'Name');

        $form->addSubmit('send', 'Create')
                ->setAttribute('class', 'btn btn-default');

        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = null;
        $renderer->wrappers['pair']['.error'] = 'has-error';
        $renderer->wrappers['control']['container'] = 'div class=form-group';
        $renderer->wrappers['control']['description'] = 'span class=help-block';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';

        // call method signInFormSucceeded() on success
        $form->onSuccess[] = $this->newFilmFormSucceeded;
        return $form;
    }


    public function newFilmFormSucceeded($form)
    {
        $values = $form->getValues();

        $film = array(
            'name' => $values['name']
        );

        $this->context->cinema->insertFilm($film);
        $this->flashMessage('Film has been added.', 'success');
        $this->redirect('this');
    }
    
    protected function createComponentNewCinema()
    {
        $form = new Nette\Application\UI\Form;
        $form->addText('name', 'Name')
                ->setAttribute('class', 'form-control')
                ->setAttribute('placeholder', 'Name');
        
        $form->addText('address', 'Address')
                ->setAttribute('class', 'form-control')
                ->setAttribute('placeholder', 'Address');

        $form->addSubmit('send', 'Create')
                ->setAttribute('class', 'btn btn-default');

        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = null;
        $renderer->wrappers['pair']['.error'] = 'has-error';
        $renderer->wrappers['control']['container'] = 'div class=form-group';
        $renderer->wrappers['control']['description'] = 'span class=help-block';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';

        // call method signInFormSucceeded() on success
        $form->onSuccess[] = $this->newCinemaFormSucceeded;
        return $form;
    }


    public function newCinemaFormSucceeded($form)
    {
        $values = $form->getValues();

        $cinema = array(
            'name' => $values['name'],
            'address' => $values['address']
        );

        $this->context->cinema->insertCinema($cinema);
        $this->flashMessage('Cinema has been added.', 'success');
        $this->redirect('this');
    }
}
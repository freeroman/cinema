<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{
    private $performance;

    public function renderBooking($id)
    {
        $this->template->registerHelper('stateColor', 'Helpers::StateColor');
        $bookings = $this->context->cinema->getBookingsByPerformanceId($id);
        $data = array_fill(0, 50, 'free');
        $this->template->seats = array_replace($data, $bookings);
        $this->template->performance = $this->context->cinema->getPerformances($id);
    }
    
    public function renderDefault() {
        $this->template->performances = $this->context->cinema->getPerformances();        
    }
    
    public function renderCompleted($code) {
        $this->template->code = $code;        
    }
    
    public function actionBooking($id) {
        $this->performance = $id;        
    }

    public function handleReload() {
        $this->redrawControl('seats');
    }
    
    public function handleReservation($seat) {
        if(!$this->context->cinema->reserveSeat($seat, $this->performance)){
            $this->flashMessage('We are sorry, but this seat is taken!');
            $this->redrawControl('flash');
        }
        $this->redrawControl();
    }
    
    public function actionCheck($seat) {
        $this->setLayout(FALSE);
        if(!$this->context->cinema->reserveSeat($seat, $this->performance)){
            echo json_encode(array('a' => 'false'));
        } else {
            echo json_encode(array('a' => 'true'));
        }
    }
    
    protected function createComponentTickets()
    {
        $form = new Nette\Application\UI\Form();
        $form->addGroup('Tickets');
        $form->addText('first_name', 'First name*')
                ->setRequired('Name is mandatory')
                ->addRule(\Nette\Application\UI\Form::INTEGER, 'Cislo')
                ->setAttribute('class', 'form-control');
        /*
        $form->addText('surname', 'Surname*')
                ->setRequired('Surname is mandatory')
                ->setAttribute('class', 'form-control');
        $form->addText('job_title', 'Job title*')
                ->setRequired('Job title is mandatory')
                ->setAttribute('class', 'form-control');
        //$form->addDateTimePicker('datum_narozeni', 'Datum narozeni:', 16, 16);
        $form->setCurrentGroup(NULL);

        //$form->addGroup()
        //        ->setOption('container', 'div class=prazdna_skupina');

        $form->addGroup('Account info')
                ->setOption('container', 'fieldset id=adress');
        $form->addText('login', 'Login*')
                ->setRequired('Login is mandatory')
                ->setAttribute('class', 'form-control');
        $form->addText('password', 'Password*')
                ->setRequired('Password is mandatory')
                ->setAttribute('class', 'form-control');            
        $form->addText('role', 'Role*')
                ->setRequired('Role is mandatory')
                ->setAttribute('class', 'form-control');
        $form->addUpload('avatar', 'Portrait')
                ->addRule(\Nette\Application\UI\Form::IMAGE, 'File has to be image');*/
                //->addRule(\Nette\Application\UI\Form::MAX_FILE_SIZE, 'File is too large (maximum 64 kB).', 64 * 1024 /* v bytech */);
        $form->addSubmit('send', 'Create')
            ->setAttribute('class', 'btn btn-default');

        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = 'div class=col-md-4';
        //$renderer->wrappers['pair']['container'] = 'div class=form-group';
        $renderer->wrappers['pair']['.error'] = 'has-error';
        $renderer->wrappers['control']['container'] = 'div class=form-group';
        //$renderer->wrappers['label']['container'] = 'small';
        $renderer->wrappers['control']['description'] = 'span class=help-block';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';

        $form->onSuccess[] =  callback($this, 'processTickets');
        return $form;
    }
    
    public function processTickets($form) {
        $values = $form->getValues();
        //$this->redirect('Homepage:booking', $this->performance);
    }
}

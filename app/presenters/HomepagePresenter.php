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
    
     /** @persistent */
    public $cinema;

    public function renderBooking($id)
    {
        $this->template->registerHelper('stateColor', 'Helpers::StateColor');
        $bookings = $this->context->cinema->getBookingsByPerformanceId($id);
        $data = array_fill(0, 50, 'free');
        $this->template->seats = array_replace($data, $bookings);
        $this->template->performance = $this->context->cinema->getPerformances($id);
    }
    
    public function renderDefault() {
        $this->template->performances = $this->cinema === null ? $this->context->cinema->getPerformancesByCinema(1) : $this->context->cinema->getPerformancesByCinema($this->cinema);        
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
    
    protected function createComponentSelectCinemas()
    {
        $form = new Nette\Application\UI\Form;
        $form->addSelect('cinema', 'Cinema', $this->context->cinema->getCinemas())
                ->setAttribute('class', 'form-control');

        $renderer = $form->getRenderer();
        $renderer->wrappers['controls']['container'] = null;
        $renderer->wrappers['pair']['.error'] = 'has-error';
        $renderer->wrappers['control']['container'] = 'div class=form-group';
        $renderer->wrappers['control']['description'] = 'span class=help-block';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=help-block';
        return $form;
    }
    
    public function handleCinemas($id) {
        $this->cinema = $id;
        $this->redrawControl('cinemas');
    }
    
    public function handleReservation($seat) {
        if(!$this->context->cinema->reserveSeat($seat, $this->performance)){
            $this->flashMessage('We are sorry, but this seat is taken!');
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
}

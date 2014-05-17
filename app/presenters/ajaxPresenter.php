<?php

namespace App\Presenters;

use Nette,
	App\Model;
/**
 * Description of ajaxPresenter
 *
 * @author pecha_000
 */
class ajaxPresenter extends BasePresenter {
    
    public function handleCheck($seat) {
        if(!$this->context->cinema->reserveSeat($seat, $this->performance)){
            echo json_encode(array('a' => 'false'));
        } else {
            echo json_encode(array('a' => 'true'));
        }
    }
    
}

<?php

class user extends controller {
	
    public function __call($method, $args) {
        if(!is_callable($method)) {
            $this->sgException->errorPage(404);
        }
    }
	
    public function main() { }

    
    public function index() {
        
        $this->model->user;
        $this->main->metatags_helper;
        $this->main->head_helper;
        $this->main->loader_helper;
        $this->main->module_helper;
        $this->main->model_helper;
        $this->main->directory_helper;
    }

    
    public function dashboard_user() {
    
        $this->model->user;
        $this->main->metatags_helper;
        $this->main->head_helper;
        $this->main->loader_helper;
        $this->main->module_helper;
        $this->main->model_helper;
        $this->main->directory_helper;
    }
    
    public function summary_user() {
    
        $this->model->user;
        $this->main->metatags_helper;
        $this->main->head_helper;
        $this->main->loader_helper;
        $this->main->module_helper;
        $this->main->model_helper;
        $this->main->directory_helper;
    }

   
    public function profile_user() {
    
        $this->model->user;
        $this->addSubpage(__FUNCTION__, "edit");
        $this->main->metatags_helper;
        $this->main->head_helper;
        $this->main->loader_helper;
        $this->main->module_helper;
        $this->main->model_helper;
        $this->main->directory_helper;

    }

    
    public function campaigns_user() {
    
        $this->model->user;
        $this->addSubpage(__FUNCTION__, "edit");
        $this->main->metatags_helper;
        $this->main->head_helper;
        $this->main->loader_helper;
        $this->main->module_helper;
        $this->main->model_helper;
        $this->main->directory_helper;

    }
    
    public function investments_user() {
    
        $this->model->user;
        $this->main->metatags_helper;
        $this->main->head_helper;
        $this->main->loader_helper;
        $this->main->module_helper;
        $this->main->model_helper;
        $this->main->directory_helper;

    }
   
    
        
    public function application_user() {
    
        $this->model->user;
        $this->addSubpage(__FUNCTION__, "edit");
        $this->main->metatags_helper;
        $this->main->head_helper;
        $this->main->loader_helper;
        $this->main->module_helper;
        $this->main->model_helper;
        $this->main->directory_helper;

    }

    
    
    public function new_registration_user() {
        $this->model->registration_user->saveNewUser();
    }
    
     public function logout_user() {
        $this->model->user->logout();
    }
    
    public function facebook_user() {
        $this->model->facebook_user;
    }
    
     public function summary_payment_user() {
        $this->model->summary_payment_user;
    }
    
    public function registration_user() {
        
        $this->model->registration_user;
        $this->main->metatags_helper;
        $this->main->head_helper;
        $this->main->loader_helper;
        $this->main->module_helper;
        $this->main->model_helper;
        $this->main->directory_helper;

    }
    
    public function password_reminder_user() {
        
        $this->model->registration_user;
        $this->main->metatags_helper;
        $this->main->head_helper;
        $this->main->loader_helper;
        $this->main->module_helper;
        $this->main->model_helper;
        $this->main->directory_helper;

    }

   
    
}

?>
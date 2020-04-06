<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog;

/**
 * Description of FormHandler
 *
 * @author constancelaloux
 */
class FormHandler 
{
    protected $form;
    protected $manager;
    protected $request;

    public function __construct(Form $form, Manager $manager, HTTPRequest $request)
    {
        $this->setForm($form);
        $this->setManager($manager);
        $this->setRequest($request);
    }

    public function process()
    {
        if($this->request->method() == 'POST' && $this->form->isValid())
        {
            $this->manager->save($this->form->entity());

            return true;
        }
        return false;
    }

    public function setForm(Form $form)
    {
        $this->form = $form;
    }

    public function setManager(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function setRequest(HTTPRequest $request)
    {
        $this->request = $request;
    }
}

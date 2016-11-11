<?php

class Maintenance extends Application{
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('formfields');
    }
    
    public function index() {
        // Warning: Below prevents access to the index page ONLY 
        // Get current user's role
        $userrole = $this->session->userdata('userrole');
        
        // Prevent access unless user is admin.
        if ($userrole != 'admin') {
            $message = 'You are not authorized to access this page. Go away';
            $this->data['content'] = $message;
            $this->render();
            return;
        }
        
        // Display CRUD controls
        $message = 'Get ready to fix stuff.';
        $this->data['pagebody'] = 'maintenance-index';
        $this->data['items'] = $this->menu->all();
        $this->render();
    }
    
    public function create($id) {
        
    }
    
    public function edit($id=null) {
        /* Note: Too unreliable (Back button, click index, manual search) 
        // find the record through the session first
        $key = $this->session->userdata('key');
        $record = $this->session->userdata('record'); */

        // Retrieve record 
        if (empty($key)) {
            $record = $this->menu->get($id);        // Warning: Record not found not handled  
            $key = $id;
            $this->session->set_userdata('key',$id);
            $this->session->set_userdata('record',$record);
        }
        
        // initialize any other related data
        $categories = $this->categories->all();     // get an array of category objects
        foreach($categories as $code => $category)  // make it into an associative array
            $codes[$code] = $category->name;
        
        // build the form fields
        $this->data['fid'] = makeTextField('Menu code', 'id', $record->id);
        $this->data['fname'] = makeTextField('Item name', 'name', $record->name);
        $this->data['fdescription'] = makeTextArea('Description', 'description', $record->description);
        $this->data['fprice'] = makeTextField('Price, each', 'price', $record->price);
        $this->data['fpicture'] = makeTextField('Item image', 'picture', $record->picture);
        $this->data['fcategory'] = makeCombobox('Category', 'category', $record->category,$codes);
        $this->data['zsubmit'] = makeSubmitButton('Save', 'Submit changes');
        
        // show the editing form
        $this->data['pagebody'] = "maintenance-edit";
        //$this->data['content'] = "Looking at " . $key . ': ' . $record->name;
        $this->render();
    }
    
    public function delete($id) {
        
    }
    
    function cancel() {
        $this->session->unset_userdata('key');
        $this->session->unset_userdata('record');
        $this->index();
    }
    
}
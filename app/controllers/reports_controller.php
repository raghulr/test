<?php

class ReportsController extends AppController {

    var $uses = array(
        'Report'
    );

    function super_index() {
      $reports = $this->Report->find('all',array(
          'order'=>array('created_at')
      ));
      $this->set(compact('reports'));
      $this->layout = 'superadmin';  
    }

}

<?php

class SlideshowsController extends AppController {

    var $uses = array(
        'Slideshow',
        'Restaurant'
    );
    var $components = array('Image');

    function admin_index() {
        $userid = $this->Auth->user('id');
        App::import('Model', 'Table');
        $instance = new Table();
        $id = $instance::getRestaurantId();
        $imagelist = $this->Slideshow->find('all', array('conditions' => array('Slideshow.restaurant_id' => $id), 'order' => 'Slideshow.order_list'));
        $this->set(compact('imagelist'));
        $this->layout = 'adminpopup';
    }

    function admin_add() {
        $this->layout = 'adminpopup';
        $this->set('title_for_popup', 'Add Profile Image');
        App::import('Model', 'Table');
        $instance = new Table();
        $id = $instance::getRestaurantId();
        if (!empty($this->data)) {
            $this->Slideshow->set($this->data);
            if ($this->Slideshow->validates()) {
                list($width, $height, $type, $attr) = getimagesize($this->data['Slideshow']['path']['tmp_name']);

                if ($width > 130 && $height > 130) {
                    $image_path = $this->Image->upload_image_and_thumbnail($this->data['Slideshow'], "path", 2758, 660, 1316, '', true);
                    //exit;
                    $this->data['Slideshow']['path'] = $image_path;
                    $this->data['Slideshow']['restaurant_id'] = $id;
                    $count = $this->Slideshow->find('count', array('conditions' => array('Slideshow.restaurant_id' => $id)));
                    $this->data['Slideshow']['order_list'] = $count + 1;
                    $this->Slideshow->save($this->data);
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(sprintf(__l('Image width should be greater than 130 and height also'), $this->data), 'default', null, 'error');
                }
            }
        }
    }

    function admin_edit($id = null) {
        $this->layout = 'adminpopup';
        $this->set('title_for_popup', 'Edit Profile Image');

        if (!empty($this->data)) {
            $imagedetails = $this->Slideshow->findByid($this->data['Slideshow']['id']);
            $this->set(compact('imagedetails'));
            $this->Slideshow->set($this->data);
            unset($this->Slideshow->validate['path']);
            if ($this->Slideshow->validates()) {
                list($width, $height, $type, $attr) = getimagesize($this->data['Slideshow']['path']['tmp_name']);
                if ($width > 130 && $height > 130) {
                    if (!empty($this->data['Slideshow']['path']['name'])) {
                        $this->Image->delete_image($imagedetails['Slideshow']['path']);
                        $image_path = $this->Image->upload_image_and_thumbnail($this->data['Slideshow'], "path", 2758, 660, 1316, '', true);
                        $this->data['Slideshow']['path'] = $image_path;
                    } else {
                        $this->data['Slideshow']['path'] = $imagedetails['Slideshow']['path'];
                    }
                    $this->Slideshow->save($this->data);
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(sprintf(__l('Image width should be greater than 130 and height also'), $this->data), 'default', null, 'error');
                }
            }
        } else {
            $imagedetails = $this->Slideshow->findByid($id);
            $this->set(compact('imagedetails'));
        }
    }

    function admin_delete($id = null) {
        $filename = $this->Slideshow->findByid($id);
        $this->Image->delete_image($filename['Slideshow']['path']);
        $this->Slideshow->delete($id);
        $this->redirect(array('action' => 'index'));
    }

    function admin_orderedlist() {
        $this->layout = false;
        $this->render = false;
        App::import('Model', 'Table');
        $instance = new Table();
        $id = $instance::getRestaurantId();
        $list = $this->params['form']['list'];
        $order = explode(',', $this->params['form']['list']);
        $k = 1;
        for ($i = 0; $i < count($order); $i++) {
            $this->Slideshow->updateAll(array('order_list' => $k), array('restaurant_id' => $id, 'id' => $order[$i]));
            $k++;
        }
    }

    function resizeImageForAppication() {
        Configure::write('debug',2);
        $this->Image->reize_for_application();
        $this->autoRender = false;
    }
}
?>
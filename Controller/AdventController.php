<?php

class AdventController extends AdventAppController
{

    private $collect_month = 12;


    public function index()
    {
        $this->set('title_for_layout', $this->Lang->get('ADVENT__TITLE'));
        $this->loadModel('Advent.AdventHistory');
        $get_day_info = [];
        $user_id = $this->User->getKey('id');
        if (!$user_id)
            $user_id = 0;
        $good_month = date('m') == $this->collect_month;
        for ($day = 1; $day <= 24; $day++) {
            $get_day_info[$day - 1]['collected'] = $this->AdventHistory->check_if_collected($user_id, date('Y-m-') . $day);
            $get_day_info[$day - 1]['can_collect'] = (!$get_day_info[$day - 1]['collected'] && $day == date('d') && $good_month);
            $get_day_info[$day - 1]['forget'] = (!$get_day_info[$day - 1]['collected'] && $day < date('d') && $good_month);
        }

        $this->set(compact('get_day_info'));


    }

    public function check($day = false)
    {
        $this->autoRender = false;
        $this->loadModel('Advent.AdventGifts');
        $this->loadModel('Advent.AdventHistory');
        $this->loadModel('User');
        $gifts = $this->AdventGifts->find('all', array('conditions' => array('day' => $day)));
        if (empty($gifts)) {
            $this->Session->setFlash($this->Lang->get('ADVENT__ERROR_CHECK_GIFT'), 'default.error');
            $this->redirect(array('controller' => 'advent', 'action' => 'index'));
        } else if ($this->isConnected) {
            if ($this->AdventHistory->check_if_collected($this->User->getKey('id'), date('Y-m-') . $day)) {
                $this->Session->setFlash($this->Lang->get('ADVENT__ERROR_ALLREADY'), 'default.error');
                $this->redirect(array('controller' => 'advent', 'action' => 'index'));
            }
            if ($day == date('j') && date('m') == $this->collect_month) {
                $this->loadModel('Advent.AdventConfig');
                $advent_config = $this->AdventConfig->find('first')['AdventConfig'];
                if (!$this->AdventGifts->collect($gifts, $this->User, $this->Server, $advent_config)) {
                    $this->Session->setFlash($this->Lang->get('ADVENT__ERROR_COLLECT'), 'default.error');
                    $this->redirect(array('controller' => 'advent', 'action' => 'index'));
                }

            } else {
                $this->Session->setFlash(str_replace("{DAY}", $day, $this->Lang->get('ADVENT__ERROR_COLLECT_DATE')), 'default.error');
                $this->redirect(array('controller' => 'advent', 'action' => 'index'));
            }

            $this->AdventHistory->add($this->User->getKey('id'), date('Y-m-') . $day, $this->Util->getIP());

            $this->Session->setFlash($this->Lang->get('ADVENT__SUCCESS_GIVE'), 'default.success');
            $this->redirect(array('controller' => 'advent', 'action' => 'index'));
        } else {
            $this->Session->setFlash($this->Lang->get('ADVENT__ERROR_MUST_BE_LOGGED'), 'default.error');
            $this->redirect(array('controller' => 'advent', 'action' => 'index'));
        }


    }

    public function admin_config()
    {

        if ($this->isConnected and $this->User->isAdmin()) {
            $this->set('title_for_layout', $this->Lang->get('ADVENT__CONFIG'));
            $this->layout = 'admin';
            $this->loadModel('Advent.AdventConfig');
            $this->loadModel('Server');
            $advent_config = $this->AdventConfig->find('first')['AdventConfig'];
            $servers = $this->Server->findSelectableServers();

            if ($this->request->is('ajax')) {
                $this->response->type('json');
                $this->autoRender = null;
                if (!empty($this->request->data['server_id']) and ($this->request->data['auto_select'] == 0 || $this->request->data['auto_select'] == 1)) {
                    $this->AdventConfig->edit(
                        $this->request->data['broadcast'],
                        $this->request->data['server_id'],
                        $this->request->data['need_online'],
                        $this->request->data['auto_select']
                    );
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('GLOBAL__SUCCESS'))));
                } else {
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('ERROR__FILL_ALL_FIELDS'))));
                }
            } else {
                $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('ERROR__BAD_REQUEST'))));
            }


            $this->set(compact('advent_config', 'servers'));

        } else {
            $this->redirect('/');
        }

    }

    public function admin_index()
    {
        if ($this->isConnected and $this->User->isAdmin()) {
            $this->set('title_for_layout', $this->Lang->get('ADVENT__TITLE'));
            $this->layout = 'admin';


            $this->loadModel('Advent.AdventGifts');
            $get_gifts = $this->AdventGifts->find('all');
            $get_gift = [];
            if (!empty($get_gifts))
                foreach ($get_gifts as $v) {
                    $get_gift[$v['AdventGifts']['day']] = $this->AdventGifts->find('all', array('conditions' => array('day' => $v['AdventGifts']['day'])));
                }

            $this->set(compact('get_gift'));

        } else {
            $this->redirect('/');
        }
    }

    public function admin_add_gift($day = false)
    {
        if (($this->isConnected and $this->User->isAdmin())) {
            $this->set('title_for_layout', $this->Lang->get('ADVENT__ADD_GIFT'));
            $this->layout = 'admin';
            $this->set(compact('day'));

            if ($this->request->is('ajax')) {
                $this->loadModel('Advent.AdventGifts');
                $this->response->type('json');
                $this->autoRender = null;
                if (!empty($this->request->data['name']) and !empty($this->request->data['command'])) {
                    $this->AdventGifts->add(
                        $day,
                        $this->request->data['name'],
                        $this->request->data['command']
                    );
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('GLOBAL__SUCCESS'))));
                } else {
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('ERROR__FILL_ALL_FIELDS'))));
                }
            } else {
                $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('ERROR__BAD_REQUEST'))));
            }


        } else {
            $this->redirect('/');
        }
    }

    public function admin_edit_gift($id = false)
    {
        if (($this->isConnected and $this->User->isAdmin())) {
            $this->set('title_for_layout', $this->Lang->get('ADVENT__ADD_GIFT'));
            $this->layout = 'admin';


            $this->loadModel('Advent.AdventGifts');
            $gift = $this->AdventGifts->find('first', array('conditions' => array('id' => $id)))['AdventGifts'];
            $this->set(compact('gift'));

            if (!empty($gift)) {
                if ($this->request->is('ajax')) {
                    $this->response->type('json');
                    $this->autoRender = null;
                    if (!empty($this->request->data['name']) and !empty($this->request->data['command'])) {
                        $this->AdventGifts->edit(
                            $id,
                            $gift['day'],
                            $this->request->data['name'],
                            $this->request->data['command']
                        );
                        $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('GLOBAL__SUCCESS'))));
                    } else {
                        $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('ERROR__FILL_ALL_FIELDS'))));
                    }
                } else {
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('ERROR__BAD_REQUEST'))));
                }
            } else {
                $this->Session->setFlash($this->Lang->get('UNKNONW_ID'), 'default.error');
                $this->redirect(array('controller' => 'advent', 'action' => 'index', 'admin' => true));
            }


        } else {
            $this->redirect('/');
        }
    }

    public function admin_delete($id = false)
    {
        $this->autoRender = false;
        if (($this->isConnected and $this->User->isAdmin())) {
            $this->loadModel('Advent.AdventGifts');
            $find = $this->AdventGifts->find('first', array('conditions' => array('id' => $id)));

            if (!empty($find)) {
                $this->AdventGifts->delete($id);
                $this->Session->setFlash($this->Lang->get('ADVENT__SUCCESS_DELETE'), 'default.success');
                $this->redirect(array('controller' => 'advent', 'action' => 'index', 'admin' => true));
            } else {
                $this->Session->setFlash($this->Lang->get('UNKNONW_ID'), 'default.error');
                $this->redirect(array('controller' => 'advent', 'action' => 'index', 'admin' => true));
            }

        }
    }

}
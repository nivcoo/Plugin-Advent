<?php

class AdventHistory extends AdventAppModel
{
    public $useTable = "history";

    public function add($user_id, $day, $user_ip)
    {
        $this->create();
        $this->set(array(
            'user_id' => $user_id,
            'day' => $day,
            'ip' => $user_ip,
        ));
        $this->save();
    }

    public function check_if_collected($user_id, $date)
    {
        $history = $this->find('first', array('conditions' => array('user_id' => $user_id, 'day' => $date)));
        if (empty($history))
            return false;
        return true;
    }
}
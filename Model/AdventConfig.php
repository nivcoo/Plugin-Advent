<?php

class AdventConfig extends AdventAppModel
{
    public $useTable = "config";

    public function add($broadcast, $server_id, $need_online, $auto_select)
    {
        $this->create();
        $this->set(array(
            'broadcast' => $broadcast,
            'server_id' => $server_id,
            'need_online' => $need_online,
            'auto_select' => $auto_select
        ));
        $this->save();
    }

    public function edit($broadcast, $server_id, $need_online, $auto_select)
    {
        $find = $this->find('first');
        if(empty($find))
            return $this->add($broadcast, $server_id, $need_online, $auto_select);
        $broadcast = $this->getDataSource()->value($broadcast, 'string');
        $server_id = $this->getDataSource()->value($server_id, 'int');
        $need_online = $this->getDataSource()->value($need_online, 'int');
        $auto_select = $this->getDataSource()->value($auto_select, 'int');

        return $this->updateAll([
            'broadcast' => $broadcast,
            'server_id' => $server_id,
            'need_online' => $need_online,
            'auto_select' => $auto_select
        ], ['id' => 1]);
    }
}
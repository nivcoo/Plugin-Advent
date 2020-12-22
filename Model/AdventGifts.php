<?php

class AdventGifts extends AdventAppModel
{
    public $useTable = "gifts";

    public function edit($id, $day, $name, $command)
    {
        $day = $this->getDataSource()->value($day, 'int');
        $name = $this->getDataSource()->value($name, 'string');
        $command = $this->getDataSource()->value($command, 'string');


        return $this->updateAll([
            'day' => $day,
            'name' => $name,
            'command' => $command
        ], ['id' => $id]);
    }

    public function add($day, $name, $command)
    {
        $this->create();
        $this->set(array(
            'day' => $day,
            'name' => $name,
            'command' => $command
        ));
        $this->save();
    }

    public function collect($gifts, $user, $server, $advent_config)
    {
        $server_id = $advent_config['server_id'];
        $username = $user->getKey('pseudo');
        if ($advent_config['auto_select'])
            $server_id = $server->getServerIdConnected($user->getKey('pseudo'));
        if (($advent_config['need_online'] && !$server->userIsConnected($username, $server_id)) || !$server_id)
            return false;
        $commands = [];
        $commands[] = str_replace('{PLAYER}', $user->getKey('pseudo'), str_replace('{DAY}', $gifts[0]['AdventGifts']['day'], $advent_config['broadcast']));
        foreach ($gifts as $command) {
            $commands[] = str_replace('{PLAYER}', $user->getKey('pseudo'), $command['AdventGifts']['command']);
        }
        $server->commands($commands, $server_id);
        return true;

    }
}
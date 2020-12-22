<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title"><?= $Lang->get('ADVENT__CONFIG') ?></h3>
                </div>

                <div class="card-body">

                    <form method="post" data-ajax="true"
                            data-redirect-url="<?= $this->Html->url(array('controller' => 'advent', 'action' => 'config', 'admin' => true)) ?>">

                        <div class="ajax-msg"></div>

                        <div class="form-group">
                            <label><?= $Lang->get('ADVENT__CONFIG_COMMAND') ?></label>
                            <input value="<?= $advent_config['broadcast'] ?>" name="broadcast" class="form-control" type="text">
                            <small><?= $Lang->get('ADVENT__CONFIG_COMMAND_DESC') ?></small>
                        </div>

                        <div class="form-group">
                            <label><?= $Lang->get('SERVER__TITLE') ?></label>
                            <small class="text-info">(<?= $Lang->get('ADVENT__CONFIG_SERVER_REQ') ?>)</small>
                            <select class="form-control" name="server_id">
                                <?php foreach ($servers as $key => $value) { ?>
                                    <option <?= (isset($advent_config) && $advent_config['server_id'] == $key) ? 'selected' : '' ?> value="<?= $key ?>"><?= $value ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="need_online"<?= ($advent_config['need_online']) ? ' checked=""' : '' ?>>
                                <label><?= $Lang->get('ADVENT__CONFIG_NEED_ONLINE') ?></label>
                                <small class="text-info">(<?= $Lang->get('ADVENT__CONFIG_SERVER_REQ') ?>)</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="auto_select"<?= ($advent_config['auto_select']) ? ' checked=""' : '' ?>>
                                <label><?= $Lang->get('ADVENT__CONFIG_AUTO_SELECT') ?></label>
                            </div>

                            <small class="text-danger"><?= $Lang->get('ADVENT__CONFIG_AUTO_SELECT_DESC') ?></small>
                        </div>


                        <div class="pull-right">
                            <a href="<?= $this->Html->url(array('controller' => 'advent', 'action' => 'index', 'admin' => true)) ?>"
                               class="btn btn-default"><?= $Lang->get('GLOBAL__CANCEL') ?></a>
                            <button class="btn btn-primary" type="submit"><?= $Lang->get('GLOBAL__SUBMIT') ?></button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</section>

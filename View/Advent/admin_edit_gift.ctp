<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title"><?= $Lang->get('ADVENT__EDIT_GIFT') ?>
                        (<?= $Lang->get('GLOBAL__DATE_DAY') . ' ' . $gift['day'] ?>)</h3>
                </div>
                <div class="card-body">
                    <form action="<?= $this->Html->url(array('controller' => 'advent', 'action' => "edit_gift/" . $gift['id'], 'admin' => true)) ?>"
                          method="post" data-ajax="true"
                          data-redirect-url="<?= $this->Html->url(array('controller' => 'advent', 'action' => 'index', 'admin' => true)) ?>">

                        <div class="ajax-msg"></div>

                        <div class="form-group">
                            <label><?= $Lang->get('GLOBAL__NAME') ?></label>
                            <input value="<?= $gift['name'] ?>" name="name" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <label><?= $Lang->get('SERVER__COMMAND') ?></label>
                            <input value="<?= $gift['command'] ?>" name="command" class="form-control" type="text">
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

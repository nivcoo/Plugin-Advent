<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title"><?= $Lang->get('ADVENT__TITLE') ?></h3>
                </div>

                <div class="card-body">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <?php for ($i = 1; $i <= 24; $i++) {
                                echo '<li class="nav-item"><a class="nav-link text-dark' . (($i == 1) ? ' active' : '') . '" href="#day-' . $i . '" data-toggle="tab">' . $Lang->get('GLOBAL__DATE_DAY') . ' ' . $i . '</a></li>';
                            } ?>
                        </ul>
                        <div class="tab-content">
                            <?php for ($i = 1; $i <= 24; $i++) { ?>

                                <div class="tab-pane fade <?= ($i == 1) ? 'show active' : '' ?>" id="day-<?= $i ?>">

                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th><?= $Lang->get('GLOBAL__NAME') ?> &nbsp;&nbsp;
                                                <a style="display:inline"
                                                   href="<?= $this->Html->url(array('controller' => 'advent', 'action' => 'add_gift/' . $i, 'admin' => true)) ?>"
                                                   class="btn btn-sm btn-success">
                                                    <?= $Lang->get('ADVENT__ADD_GIFT') ?>
                                                </a>
                                            </th>
                                            <th><?= $Lang->get('SERVER__TITLE') ?></th>
                                            <th><?= $Lang->get('SERVER__COMMAND') ?></th>
                                            <th class="right"><?= $Lang->get('GLOBAL__ACTIONS') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($get_gift)) foreach ($get_gift[$i] as $v) { ?>
                                            <tr class="item">
                                                <td><?= $v['AdventGifts']['name'] ?></td>
                                                <td>All</td>
                                                <td><?= $v['AdventGifts']['command'] ?></td>
                                                <td class="right">
                                                    <a href="<?= $this->Html->url(array('controller' => 'advent', 'action' => "edit_gift/" . $v['AdventGifts']['id'], 'admin' => true)) ?>"
                                                       class="btn btn-info"> <?= $Lang->get('GLOBAL__EDIT') ?></a>
                                                    <a onclick="confirmDel('<?= $this->Html->url(array('controller' => 'advent', 'action' => 'delete/' . $v['AdventGifts']['id'], 'admin' => true)) ?>')"
                                                       class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE') ?></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="content-wrapper">
        <?= $this->Session->flash(); ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="text-center">
                        <h1><?= $Lang->get('ADVENT__TITLE') ?></h1>
                    </div>
                    <br>
                    <div class="text-center" style="margin-bottom:10px;">
                        <?= $Lang->get('ADVENT__INDEX_DESC') ?>
                    </div>
                </div>
            </div>

        </div>
        <?php $i = 0;
        foreach ($get_day_info as $day) {
            $i++; ?>
            <div class="col-lg-2 col-sm-6 col-xs-6">

                <div class="panel">
                    <?php
                    $class = "warning";
                    $message = '';
                    $disabled = true;
                    $color = ['btn' => "#181818", 'box' => "#262626"];
                    if ($day['collected']) {
                        $message = $Lang->get('ADVENT__INDEX_COLLECT');
                    } else if ($day['can_collect']) {
                        $disabled = false;
                        $class = "success";
                        $message = $Lang->get('ADVENT__INDEX_CAN_COLLECT');
                    } else if ($day['forget']) {
                        $message = $Lang->get('ADVENT__INDEX_FORGET');
                        $class = "danger";
                    } else {
                        $message = $Lang->get('ADVENT__INDEX_NOT_AVAILABLE');
                    }
                    ?>
                    <div class="panel-body" style="padding:5px">

                        <div class="text-center"
                             style="padding: 10px;text-transform: uppercase; font-size: 18px;font-weight: 900;">
                            <?= $i ?> <?= $Lang->get('ADVENT__DECEMBER') ?>
                        </div>

                        <div class="text-center">
                            <a class="btn btn-<?= $class ?>"
                               style="border-radius:0"
                                <?= ($disabled) ? "disabled" : "href='" . $this->Html->url(array('controller' => 'advent', 'action' => 'check/' . $i)) . "'" ?>>
                                <?= $message ?>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

</div>

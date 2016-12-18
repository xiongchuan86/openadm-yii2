<?php
use yii\widgets\Breadcrumbs;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="display: none">
        <h1>
            Data Tables
            <small>advanced tables</small>
        </h1>
        <?= Breadcrumbs::widget([
            'tag'   => 'ol',
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);
        ?>
    </section>

    <section class="content">
        <?= $content ?>
    </section>
</div>
<!-- /.content-wrapper -->
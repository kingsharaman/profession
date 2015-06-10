<?php
use yii\helpers\Html;
?>
<p>A(z) <?= Html::encode($model->id) ?> azonosítójú ('<?= Html::encode($model->title) ?>') hirdetést <?= Html::encode($model->activated) ?>-kor sikeresen aktiváltuk. Email: <?= Html::encode($model->email) ?></p>

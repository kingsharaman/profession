<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['action' => '?r=site/activate', 'method' => 'post']); ?>
    
	<?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
<p>Az URL végéhez illesztve a ?r=site/review&id=2 stringet lehet megjeleníteni a hirdetés adatait.</p>
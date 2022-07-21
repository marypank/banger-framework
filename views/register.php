<div class="container">
	<div class="row align-items-center">
		<div class="col"></div>
		<div class="col">
			<h1>Register</h1>
			<?php $form = \app\core\form\Form::begin('', 'post')  ?>
				<?php echo $form->field($model, 'username') ?>
				<?php echo $form->field($model, 'email')->emailField() ?>
				<?php echo $form->field($model, 'password')->passwordField() ?>
				<?php echo $form->field($model, 'confirmPassword')->passwordField() ?>
				<button type="submit" class="btn btn-primary">Register</button>
			<?php echo \app\core\form\Form::end() ?>
		</div>
		<div class="col"></div>
	</div>
</div>
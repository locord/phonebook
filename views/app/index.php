<?php
/**
 * @var PhpViewRenderer $this
 */

use Engine\Http\View\PhpViewRenderer;

?>

<?php $this->extend = 'layout/default'; ?>

<?php $this->params['title'] = 'Hello'; ?>

<div class="jumbotron">
	<h1>Hello!</h1>
	<p>
		Congratulations! You have successfully created your application.
	</p>
</div>
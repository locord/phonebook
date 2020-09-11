<?php
/**
 * @var PhpViewRenderer $this
 * @var                 $content string
 */

use Engine\Http\View\PhpViewRenderer;

?>
<?php $this->extend = 'layout/default'; ?>

<div class="row">
	<div class="col-md-9">
        <?= $content ?>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">Profile</div>
			<div class="panel-body">
				Profile navigation
			</div>
		</div>
	</div>
</div>
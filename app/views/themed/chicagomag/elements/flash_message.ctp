<?php
	if ($session->check('Message.error')):
		$session->flash('error');
	endif;
	if ($session->check('Message.success')):
		$session->flash('success');
	endif;
	if ($session->check('Message.flash')):
			$session->flash();
	endif;//view_compact
?>
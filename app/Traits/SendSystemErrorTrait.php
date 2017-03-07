<?php
namespace App\Traits;
trait SendSystemErrorTrait{
	public function sendSystemErrorMail($mail,$e)
	{
		$exceptionData = [
			'method' => request()->route()->getActionName(),
			'info' => $e->getMessage(),
			'trace' => $e->getTraceAsString()
		];
		dispatch(new \App\Jobs\SendEmail($mail,$exceptionData));
	}
}
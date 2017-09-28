<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

abstract class TestCase extends BaseTestCase
{
	use CreatesApplication;

	protected function setUp()
	{
		parent::setUp();
		$this->disableExceptionHandling();
	}

	protected function signIn($user = null) {
		$user = $user ?: factory(User::class)->create();

		$this->actingAs($user);

		return $this;
	}

	// Hat tip, @adamwathan.
	protected function disableExceptionHandling()
	{
		$this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
		$this->app->instance(ExceptionHandler::class, new class extends Handler {
			public function __construct() {}
			public function report(\Exception $e) {}
			public function render($request, \Exception $e) {
				throw $e;
			}
		});
	}

	protected function withExceptionHandling()
	{
		$this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
		return $this;
	}
}
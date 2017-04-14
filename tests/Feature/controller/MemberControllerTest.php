<?php

namespace Tests\Feature\controller;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Model\Member;

class MemberControllerTest extends TestCase
{
	use DatabaseMigrations;
	use WithoutMiddleware;

	public function testGetListAllMember ()
	{
		$Members = factory(App\User::class,2)->create();

		$this
		->action('GET', 'MemberController@getList')
		->seeStatusCode(200);

		foreach ($Members as $Member) {
			$this->seeJson([
				'name' =>$Member->name,
				'age'  =>$Member->age,
				'address' =>$Member->address,	
			]);
		}
	}

}

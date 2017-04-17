<?php

namespace Tests\Feature\controller;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Member;

class MemberControllerTest extends TestCase
{
	use DatabaseMigrations;
	use WithoutMiddleware;

	/**
     * A basic test example.
     * @test
     * @return void
     */
    // protected function assertFalseState($request_array) {
    //     $response = $this->call('POST', '/add', $request_array);
    //     $data = json_decode($response ->getContent(), true);
    //     $this->assertEquals(405, $response->status());
    //     if ($data['status']==false) {
    //         $this->assertTrue(true);
    //     } else {
    //         $this->assertTrue(false);
    //     }
    // }

	public function testgetList ()
	{
		$Member = factory(Member::class)->create();

		 $response = $this->get('/list');

        $response->assertStatus(200);
		
	}

	public function testgetEdit ()
	{
		$Member = factory(Member::class)->create();

		$response = $this->get(route('get.edit',[$Member->id]));

        $response->assertStatus(200);
		
	}
	
	
	

}

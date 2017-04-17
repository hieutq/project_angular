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

	/** test get list member */

	public function testgetList ()
	{
		$Member = factory(Member::class)->create();

		 $response = $this->get('/list');

        $response->assertStatus(200);
		
	}

	/** test get id  */
	public function testgetEdit ()
	{
		$Member = factory(Member::class)->create();

		$response = $this->get(route('get.edit',[$Member->id]));

        $response->assertStatus(200);
		
	}
	
	/** test add new Member */
	public function testgetAdd() 
	{
		$Member = factory(Member::class)->create([
			'name' => 'jenifer',
			'age'  => 22, 
			'address' => 'Vĩnh Phúc', 
			'gender'	=> 1, 
		]);

		$found_Member  = Member::find($Member->id);

		$this->assertEquals($Member->name,'jenifer');
		$this->assertEquals($Member->age,'22');
		$this->assertEquals($Member->address,'Vĩnh Phúc');
		$this->assertEquals($Member->gender,1);

		$this->assertDatabaseHas('members',['name'=>'jenifer','age'=>22, 'address'=>'Vĩnh Phúc','gender' => 1]);
	}

	/** test can be delete a member */

	public function testdeleteMember() 
	{
		$Member = factory(Member::class)->create([
			'name' => 'jenifer',
			'age'  => 22, 
			'address' => 'Vĩnh Phúc', 
			'gender'	=> 1, 
		]);

		$found_Member  = Member::find($Member->id);

		$found_Member->delete();

		$this->assertDatabaseHas('members',['name'=>'jenifer','age'=>22, 'address'=>'Vĩnh Phúc','gender' => 1]);
	}
	
}

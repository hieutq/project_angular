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



	public function testpostEdit() 
	{
		$Member = factory(Member::class)->create([
			'name' => 'Babylong',
			'age'  => 24, 
			'address' => 'abc', 
			'gender'	=> 1, 
		]);
		$id_member =$Member->id;
		$reuquest_array = [
			'name' => 'Tung',
			'age'  => 23, 
			'address' => 'xyz', 
			'gender'	=> 0, 
		];
        $response = $this->call('POST', '/edit/'.$id_member, $reuquest_array);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members',
            ['name' => $reuquest_array['name'], 'address' =>$reuquest_array['address'], 'age' =>(int)$reuquest_array['age'], 'gender' => (int)$reuquest_array['gender']]);
	}

	/** test can be delete a member */

	public function testdeleteMember() 
	{
		$Member = factory(Member::class)->create([
			'name' => 'jenifer',
			'age'  => 22, 
			'address' => 'Vinh Phuc', 
			'gender'	=> 1, 
		]);

		$found_Member  = Member::find($Member->id);

		$found_Member->delete();

		$this->assertDatabaseMissing('members',['name'=>'jenifer','age'=>22, 'address'=>'Vĩnh Phúc','gender' => 1]);
	}
}

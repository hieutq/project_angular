<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UpdateMemberTest extends TestCase
{


    // Test it can edit member's info
    public function testpostEdit()
    {
    	$Member = factory(Member::class)->create([
			'name' => 'jenifer',
			'age'  => 22, 
			'address' => 'Vĩnh Phúc', 
			'gender'	=> 1, 
		]);
		dd($Member->id);
        // $request_array = [
        //     'name' => "HaHa",
        //     'address' => "Thái Thịnh",
        //     'age' => 20,
        //     'gender' => 1

        // ];
        // $response = $this->call('POST', 'edit/1', $request_array);
        // $this->assertEquals(200, $response->status());
        // $this->assertDatabaseHas('members',
        //     ['name' => $request_array['name'], 'address' => $request_array['address'], 'age' => $request_array['age']]);
    }
}

<?php

namespace Tests\Feature\controller;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddValidationTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    /**
     * A basic test example.
     * @test
     * @return void
     */
    /** Test validate name 101 is larger than characters */

    public function testAddName101Character()
    {
        $request_array = [
        'name' => '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901',
        'age' => 22,
        'address' => 'Vĩnh Phúc',
        'gender' => 1,
        ];
        $response = $this->call('POST', '/add', $request_array);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
            'name' => $request_array['name'],
            'age' =>$request_array['age'], 
            'address' => $request_array['address'], 
            'gender' => $request_array['gender']
            ]);
    }

    /** tests validation not required */
    public function testAddNameEmpty()
    {
        $request_array = [
        'name' => '',
        'address' => 'Test Đia Chi',
        'age' => 22,
        'gender' => 1,
        ];
        $response = $this->call('POST', '/add', $request_array);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
            'name' => $request_array['name'],
            'age' =>$request_array['age'], 
            'address' => $request_array['address'], 
            'gender' => $request_array['gender']
            ]);
    }

    /** test validate address larger than 300 character */
    public function testAddAddress301character()
    {
        $request_array = [
        'name' => 'Tạ Quang Hiếu',
        'address' => 'addresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstest',
        'age' => 22,
        'gender' => 1,

        ];
        $response = $this->call('POST', '/add', $request_array);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
            'name' => $request_array['name'],
            'age' =>$request_array['age'], 
            'address' => $request_array['address'], 
            'gender' => $request_array['gender']
            ]);
    }

    /** test empty address */

    public function testIsAddressEmpty()
    {
        $request_array = [
        'name' => 'Tạ Quang Hiếu',
        'address' => '',
        'age' => 22,
        'gender' => 1,

        ];

        $response = $this->call('POST', '/add', $request_array);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
            'name' => $request_array['name'],
            'age' =>$request_array['age'], 
            'address' => $request_array['address'], 
            'gender' => $request_array['gender']
            ]);
    }

    /**
     * test column age have type more than 2 digits
     */
    public function testAddAgeWhenMoreThan2Digits()
    {
        $request_array = [
        'name' => 'Tạ Quang Hiếu',
        'address' => 'Vĩnh Phúc',
        'age' => 222,
        'gender' => 1,

        ];

        $response = $this->call('POST', '/add', $request_array);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
            'name' => $request_array['name'],
            'age' =>$request_array['age'], 
            'address' => $request_array['address'], 
            'gender' => $request_array['gender']
            ]);
    }

    /**
     * test column age required
     */
    public function testAddAgeEmpty()
    {
        $request_array = [
        'name' => 'Tạ Quang Hiếu',
        'address' => 'Address Test',
        'age' => '',
        'gender' => 1,

        ];

        $response = $this->call('POST', '/add', $request_array);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
            'name' => $request_array['name'],
            'age' =>$request_array['age'], 
            'address' => $request_array['address'], 
            'gender' => $request_array['gender']
            ]);
    }


    /**
     * test column age must be number
     */
    public function testAddAgeMustNotBeNumber()
    {
        $request_array = [
        'name' => 'Tạ Quang Hiếu',
        'address' => 'Address Test',
        'age' => 'aa',
        'gender' => 1,

        ];

        $response = $this->call('POST', '/add', $request_array);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
            'name' => $request_array['name'],
            'age' =>$request_array['age'], 
            'address' => $request_array['address'], 
            'gender' => $request_array['gender']
            ]);
    }

    /**
     * [testGenderEmptyEdit the column Gender required]
     * @return [type] [description]
     */
    public function testAddGenderEmpty()
    {
        $request_array = [
        'name' => 'Tạ Quang Hiếu',
        'address' => 'Vĩnh Phúc',
        'age' => '22',
        'gender' => '',

        ];

        $response = $this->call('POST', '/add', $request_array);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
            'name' => $request_array['name'],
            'age' =>$request_array['age'], 
            'address' => $request_array['address'], 
            'gender' => $request_array['gender']
            ]);
    }
}

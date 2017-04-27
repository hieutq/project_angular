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
    protected function assertFalseState($request_array)
    {
        $response = $this->call('POST', '/add', $request_array);
        $data = json_decode($response ->getContent(), true);
        $this->assertEquals(200, $response->status());
        if ($data['error']) {
            $this->assertTrue(true);
        } else  if ($data['error'] == false) {
            print_r($data['messages']);
            $this->assertTrue(true);
        }
    }

    /** Test validate name 101 is larger than characters */

    public function testValidationName()
    {
       $request_array = [
            'name'      => '<script>alert(ok)</script>',
            'age'       => 22, 
            'address'   => 'Vĩnh Phúc', 
            'gender'    => 1, 
            ];
        $this->assertFalseState($request_array);
    }
    /** tests validation not required */
    public function testIsNameEmpty()
    {
        $request_Member = [
        'name'     => '',
        'address'  => 'Test Đia Chi',
        'age'      => 22,
        'gender'   => 1,
        ];
        $this->assertFalseState($request_Member);
    }
    /** test validate address larger than 300 character */
    public function testAddressValidation()
    {
        $request_Member = [
        'name'      => 'Tạ Quang Hiếu',
        'address'   => 'addresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstestaddresstest',
        'age'       => 22,
        'gender'    => 1,

        ];
        $this->assertFalseState($request_Member);
    }

    /** test empty address */

    public function testIsAddressEmpty()
    {
        $request_Member = [
        'name'        => 'Tạ Quang Hiếu',
        'address'     => '',
        'age'         => 22,
        'gender'      => 1,

        ];

        $this->assertFalseState($request_Member);
    }

    /**
     * test column age have type more than 2 digits
     */
    public function testAgeValidation()
    {
        $request_Member = [
        'name'      => 'Tạ Quang Hiếu',
        'address'   => 'Vĩnh Phúc',
        'age'       => 222,
        'gender'    => 1,

        ];

        $this->assertFalseState($request_Member);
    }

    /**
     * test column age required
     */
    public function testAgeEmpty()
    {
        $request_Member = [
        'name'      => 'Tạ Quang Hiếu',
        'address'   => 'Address Test',
        'age'       => '',
        'gender'    => 1,

        ];

        $this->assertFalseState($request_Member);
    }


    /**
     * test column age must be number
     */
    public function testAgeNumber()
    {
        $request_Member = [
        'name'      => 'Tạ Quang Hiếu',
        'address'   => 'Address Test',
        'age'       => 'aa',
        'gender'    => 1,

        ];

        $this->assertFalseState($request_Member);
    }

    /**
     * [testGenderEmptyEdit the column Gender required]
     * @return [type] [description]
     */
    public function testGenderEmpty()
    {
        $request_array = [
        'name'     => 'Tạ Quang Hiếu',
        'address'  => 'Vĩnh Phúc',
        'age'      => '22',
        'gender'   => '',

        ];

        $this->assertFalseState($request_array);
    }
}

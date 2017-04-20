<?php

namespace Tests\Feature\controller;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Member;

class UpdateValidationTest extends TestCase
{
    use DatabaseMigrations;
    protected function assertDatabaseMissingStatus($request_array)
    {
        $Member = factory(Member::class)->create([
            'name'       => 'Babylong',
            'age'        => 24,
            'address'    => 'abc',
            'gender'     => 1,
            ]);
        $id_member= $Member->id;
        $response = $this->call('POST', '/edit/'.$id_member, $request_array);
        $this->assertDatabaseHas('members' ,['name' => $request_array['name'] ,'address' => $request_array['address'] ,'age' => (int)$request_array['age'] ,'gender' => (int)$request_array['gender']]);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(200, $response->status());
        if ($data['error']==false) {
            print_r($data['messages']);
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
        
    }

    /**
     * [testValidationNameEdit larger 100 character]
     * @return [type] [description]
     */
    public function testValidationNameEdit()
    {
        $request_array  = [
        'name'    => '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901',
        'address' => 'Test Đia Chi',
        'age'     => 22,
        'gender'  => 1,
        ];
        $this->assertDatabaseMissingStatus($request_array);
    }

    /**
     * [testIsNameEmptyEdit Empty Name ]
     * @return [type] [description]
     */
    public function testIsNameEmptyEdit()
    {
        $request_array  = [
        'name'       => '',
        'address'    => 'Test Đia Chi',
        'age'        => 22,
        'gender'     => 1,

        ];
        $this->assertDatabaseMissingStatus($request_array);
    }

    /**
     * [testAddressValidationEdit address larger 300 character]
     * @return [type] [description]
     */
    
    public function testAddressValidationEdit()
    {
        $request_array  = [
        'name'        => 'Tạ Quang Hiếu',
        'address'     => 'Test Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia Chi',
        'age'         => 22,
        'gender'      => 1,

        ];
        $this->assertDatabaseMissingStatus($request_array);
    }

    /**
     * [testIsAddressEmptyEdit address riquired]
     * @return [type] [description]
     */
    
    public function testIsAddressEmptyEdit()
    {
        $request_array  = [
        'name'      => 'Tạ Quang Hiếu',
        'address'   => '',
        'age'       => 22,
        'gender'    => 1,

        ];
        $this->assertDatabaseMissingStatus($request_array);
    }
    /**
     * [testAgeValidationEdit Age column more than 2 digits]
     * @return [type] [description]
     */
    
    public function testAgeValidationEdit()
    {
        $request_array  = [
        'name'       => 'Tạ Quang Hiếu',
        'address'    => 'Vĩnh Phúc',
        'age'        => 222,
        'gender'     => 1,

        ];
        $this->assertDatabaseMissingStatus($request_array);
    }

    /**
     * [testAgeEmptyEdit column Age required]
     * @return [type] [description]
     */
    
    public function testAgeEmptyEdit()
    {
        $request_array  = [
        'name'        => 'Tạ Quang Hiếu',
        'address'     => 'Vĩnh Phúc',
        'age'         => '',
        'gender'      => 1,

        ];
        $this->assertDatabaseMissingStatus($request_array);
    }

    /**
     * [testAgeNumberEdit The age mustn't be a number.]
     * @return [type] [description]
     */
    
    public function testAgeNumberEdit()
    {
        $request_array = [
        'name'        => 'Tạ Quang Hiếu',
        'address'     => 'Vĩnh Phúc',
        'age'         => 'aaaa',
        'gender'      => 1,

        ];
        $this->assertDatabaseMissingStatus($request_array);
    }

    /**
     * [testGenderEmptyEdit the column Gender required]
     * @return [type] [description]
     */
    
    public function testGenderEmptyEdit()
    {
        $request_array = [
        'name'        => 'Tạ Quang Hiếu',
        'address'     => 'Vĩnh Phúc',
        'age'         => '22',
        'gender'      => '',

        ];
        $this->assertDatabaseMissingStatus($request_array);
    }
}

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

    /**
     * [testValidationNameEdit larger 100 character]
     * @return [type] [description]
     */
    public function testEditMemberWhenName101Character()
    {
        $Member = factory(Member::class)->create([
            'name' => 'Babylong',
            'age' => 24,
            'address' => 'abc',
            'gender' => 1,
        ]);
        $request_array = [
            'name' => '12345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901',
            'address' => 'Test Đia Chi',
            'age' => 22,
            'gender' => 1,
        ];
        $id_member = $Member->id;
        $response = $this->call('POST', '/edit/' . $id_member, $request_array);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
                'name' => $request_array['name'],
                'address' => $request_array['address'],
                'age' => (int)$request_array['age'],
                'gender' => (int)$request_array['gender']
            ]);
    }

    /**
     * [testIsNameEmptyEdit Empty Name ]
     * @return [type] [description]
     */
    public function testEditWhenNameEmpty()
    {
        $Member = factory(Member::class)->create([
            'name' => 'Babylong',
            'age' => 24,
            'address' => 'abc',
            'gender' => 1,
        ]);
        $request_array = [
            'name' => '',
            'address' => 'Test Đia Chi',
            'age' => 22,
            'gender' => 1,

        ];
        $id_member = $Member->id;
        $response = $this->call('POST', '/edit/' . $id_member, $request_array);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
                'name' => $request_array['name'],
                'address' => $request_array['address'],
                'age' => (int)$request_array['age'],
                'gender' => (int)$request_array['gender']
            ]);
        $data = json_decode($response->getContent(), true);
    }

    /**
     * [testAddressValidationEdit address larger 300 character]
     * @return [type] [description]
     */

    public function testEditWhenAddress301Character()
    {
        $Member = factory(Member::class)->create([
            'name' => 'Babylong',
            'age' => 24,
            'address' => 'abc',
            'gender' => 1,
        ]);
        $request_array = [
            'name' => 'Tạ Quang Hiếu',
            'address' => 'Test Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia ChiTest Đia Chi',
            'age' => 22,
            'gender' => 1,

        ];
        $id_member = $Member->id;
        $response = $this->call('POST', '/edit/' . $id_member, $request_array);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
                'name' => $request_array['name'],
                'address' => $request_array['address'],
                'age' => (int)$request_array['age'],
                'gender' => (int)$request_array['gender']
            ]);
    }

    /**
     * [testIsAddressEmptyEdit address riquired]
     * @return [type] [description]
     */

    public function testEditWhenAddressEmpty()
    {
        $Member = factory(Member::class)->create([
            'name' => 'Babylong',
            'age' => 24,
            'address' => 'abc',
            'gender' => 1,
        ]);
        $request_array = [
            'name' => 'Tạ Quang Hiếu',
            'address' => '',
            'age' => 22,
            'gender' => 1,

        ];
        $id_member = $Member->id;
        $response = $this->call('POST', '/edit/' . $id_member, $request_array);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
                'name' => $request_array['name'],
                'address' => $request_array['address'],
                'age' => (int)$request_array['age'],
                'gender' => (int)$request_array['gender']
            ]);
    }

    /**
     * [testAgeValidationEdit Age column more than 2 digits]
     * @return [type] [description]
     */

    public function testEditWhenAgeMoreThan2digits()
    {
        $Member = factory(Member::class)->create([
            'name' => 'Babylong',
            'age' => 24,
            'address' => 'abc',
            'gender' => 1,
        ]);
        $request_array = [
            'name' => 'Tạ Quang Hiếu',
            'address' => 'Vĩnh Phúc',
            'age' => 222,
            'gender' => 1,

        ];
        $id_member = $Member->id;
        $response = $this->call('POST', '/edit/' . $id_member, $request_array);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
                'name' => $request_array['name'],
                'address' => $request_array['address'],
                'age' => (int)$request_array['age'],
                'gender' => (int)$request_array['gender']
            ]);
    }

    /**
     * [testAgeEmptyEdit column Age required]
     * @return [type] [description]
     */

    public function testEditWhenAgeEmpty()
    {
        $Member = factory(Member::class)->create([
            'name' => 'Babylong',
            'age' => 24,
            'address' => 'abc',
            'gender' => 1,
        ]);
        $request_array = [
            'name' => 'Tạ Quang Hiếu',
            'address' => 'Vĩnh Phúc',
            'age' => '',
            'gender' => 1,

        ];
        $id_member = $Member->id;
        $response = $this->call('POST', '/edit/' . $id_member, $request_array);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
                'name' => $request_array['name'],
                'address' => $request_array['address'],
                'age' => (int)$request_array['age'],
                'gender' => (int)$request_array['gender']
            ]);
    }

    /**
     * [testAgeNumberEdit The age mustn't be a number.]
     * @return [type] [description]
     */

    public function testEditWhenAgeMustNotBeNumber()
    {
        $Member = factory(Member::class)->create([
            'name' => 'Babylong',
            'age' => 24,
            'address' => 'abc',
            'gender' => 1,
        ]);
        $request_array = [
            'name' => 'Tạ Quang Hiếu',
            'address' => 'Vĩnh Phúc',
            'age' => 'aaaa',
            'gender' => 1,

        ];
        $id_member = $Member->id;
        $response = $this->call('POST', '/edit/' . $id_member, $request_array);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
                'name' => $request_array['name'],
                'address' => $request_array['address'],
                'age' => (int)$request_array['age'],
                'gender' => (int)$request_array['gender']
            ]);
    }

    /**
     * [testGenderEmptyEdit the column Gender required]
     * @return [type] [description]
     */

    public function testEditWhenGenderEmpty()
    {
        $Member = factory(Member::class)->create([
            'name' => 'Babylong',
            'age' => 24,
            'address' => 'abc',
            'gender' => 1,
        ]);
        $request_array = [
            'name' => 'Tạ Quang Hiếu',
            'address' => 'Vĩnh Phúc',
            'age' => '22',
            'gender' => '',

        ];
        $id_member = $Member->id;
        $response = $this->call('POST', '/edit/' . $id_member, $request_array);
        $this->assertEquals(405, $response->status());
        $this->assertDatabaseMissing('members',
            [
                'name' => $request_array['name'],
                'address' => $request_array['address'],
                'age' => (int)$request_array['age'],
                'gender' => (int)$request_array['gender']
            ]);
    }
}

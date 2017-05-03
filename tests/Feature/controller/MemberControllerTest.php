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

    /** test get list member */

    public function testGetListReturnOK()
    {
        $member = factory(Member::class)->create();
        $response = $this->get('/list');
        $response->assertStatus(200);
    }

    /** test get id  */
    public function testGetEditReturnOK()
    {
        $member = factory(Member::class)->create();

        $response = $this->get(route('get.edit', [$Member->id]));

        $response->assertStatus(200);
    }

    /** test add new Member */
    public function testAddMemberReturnOkWhenAllValueValidation()
    {
        $reuquest_array = [
            'name' => 'Tạ Quang Hiếu 123',
            'age' => 22,
            'address' => 'Vĩnh Phúc 123',
            'gender' => 1,
        ];
        $response = $this->call('POST', '/add', $reuquest_array);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members',
            [
                'name' => $reuquest_array['name'],
                'address' => $reuquest_array['address'],
                'age' => (int)$reuquest_array['age'],
                'gender' => (int)$reuquest_array['gender']
            ]);
    }


    public function testEditMemberReturnOkWhenAllValueValidation()
    {
        $member = factory(Member::class)->create([
            'name' => 'Babylong',
            'age' => 24,
            'address' => 'abc',
            'gender' => 1,
        ]);
        $id_member = $member->id;
        $reuquest_array = [
            'name' => 'Tạ Quang Hiếu',
            'age' => 23,
            'address' => 'xyz',
            'gender' => 0,
        ];
        $response = $this->call('POST', '/edit/' . $id_member, $reuquest_array);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseHas('members',
            [
                'name' => $reuquest_array['name'],
                'address' => $reuquest_array['address'],
                'age' => (int)$reuquest_array['age'],
                'gender' => (int)$reuquest_array['gender']
            ]);
    }

    /** test can be delete a member */

    public function testdeleteMember()
    {
        $member = factory(Member::class)->create([
            'name' => 'jenifer',
            'age' => 22,
            'address' => 'Vinh Phuc',
            'gender' => 1,
        ]);
        $memberId = $member->id;
        $response = $this->call('delete', '/delete/' . $memberId);
        $this->assertEquals(200, $response->status());
        $this->assertDatabaseMissing('members',
            ['name' => 'jenifer', 'age' => 22, 'address' => 'Vĩnh Phúc', 'gender' => 1]);
    }
}

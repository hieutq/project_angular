<?php

namespace Tests\Feature\controller;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UploadTest extends TestCase
{
    public function test_upload_works()
    {
    	$name = str_random(8).'.png';
        $path = sys_get_temp_dir().'/'.$name;
        $stub = __DIR__.'\UploadTest'.$name;
        copy($stub, $path);
        $file = new UploadedFile($path, $name, filesize($path), 'image/png', null, true);
        $response = $this->call('POST', '/upload', [], [], ['photo' => $file], ['Accept' => 'application/json']);

        $this->assertResponseOk();
        $content = json_decode($response->getContent());
        $this->assertObjectHasAttribute('name', $content);

        $uploaded = 'images'.DIRECTORY_SEPARATOR.$content->name;
        $this->assertExists(public_path($uploaded));

        @unlink($uploaded);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnalyseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->withHeaders([
                'Accept' => 'application/json',
        ])->json('POST', 'api/analyse', ['string' => 'football vs soccer']);

        $response->assertStatus(200);

        $response->assertJson([
            [
                "f:1:before:o:after:none"
            ],
            [
                "o:3:before:o,t,c:after:f,o,s max_distance:10"
            ],
            [
                "t:1:before:b:after:o"
            ],
            [
                "b:1:before:a:after:t"
            ],
            [
                "a:1:before:l:after:b"
            ],
            [
                "l:2:before:l,v:after:a,l max_distance:0"
            ],
            [
                "v:1:before:s:after:l"
            ],
            [
                "s:2:before:s,o:after:v,s max_distance:1"
            ],
            [
                "c:2:before:c,e:after:o,c max_distance:0"
            ],
            [
                "e:1:before:r:after:c"
            ],
            [
                "r:1:before:none:after:e"
            ]
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', 'api/analyse', ['string' => '      football vs soccer']);

        $response->assertStatus(200);

        $response->assertJson([
            [
                "f:1:before:o:after:none"
            ],
            [
                "o:3:before:o,t,c:after:f,o,s max_distance:10"
            ],
            [
                "t:1:before:b:after:o"
            ],
            [
                "b:1:before:a:after:t"
            ],
            [
                "a:1:before:l:after:b"
            ],
            [
                "l:2:before:l,v:after:a,l max_distance:0"
            ],
            [
                "v:1:before:s:after:l"
            ],
            [
                "s:2:before:s,o:after:v,s max_distance:1"
            ],
            [
                "c:2:before:c,e:after:o,c max_distance:0"
            ],
            [
                "e:1:before:r:after:c"
            ],
            [
                "r:1:before:none:after:e"
            ]
        ]);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', 'api/analyse', ['string' => '']);

        $response->assertStatus(422);

        $response->assertJson([
            "message" => "The given data was invalid.",
            "errors"=> [
                "string"=> [
                    "The string field is required."
                ]
            ]
        ]);


    }
}

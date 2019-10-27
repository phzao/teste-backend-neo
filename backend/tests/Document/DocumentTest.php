<?php

namespace Tests\Document;

use App\Models\Document;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * Class DocumentTest
 * @package Tests\Document
 */
class DocumentTest extends \TestCase
{
    const  URL = 'api/v1/documents';
    use DatabaseTransactions;

    public function testDocumentObject()
    {
        $document = new Document();

        $this->assertInstanceOf(Document::class, $document);
        $data = [
            "status"     => "enable",
            "cnpj"       => null,
            "cpf"        => null,
            "created_at" => "",
            "updated_at" => ""
        ];

        $this->assertEquals($data, $document->getFullDetails());
        $this->assertEquals(5, count($document->getFullDetails()));
        $this->assertEquals(1, count($document->toArray()));
        $this->assertEquals(3, count($document->rules()));
        $this->assertEquals(1, count($document->getCPFRule()));
        $this->assertEquals(1, count($document->getCNPJRule()));
        $this->assertEquals(1, count($document->getRulesID()));
        $this->assertArrayHasKey("id",$document->getRulesID());
        $this->assertArrayHasKey("cnpj",$document->getCNPJRule());
        $this->assertArrayHasKey("cpf",$document->getCPFRule());
    }
    
    public function testFailCreateDocumentCPF()
    {
        $templateBody = [];

        $templateMessage = [
            "status"  => "fail",
            "data"  => [
                "cpf" => [
                    "The cpf field is required when cnpj is ."
                ],
                "cnpj" => [
                    "The cnpj field is required when cpf is ."
                ]
            ]
        ];

        $response = $this->json('POST', self::URL, $templateBody);

        $response
            ->seeJsonEquals($templateMessage)
            ->assertResponseStatus(422);

        $templateBody['cpf'] = "asda";
        $templateMessageCPF  = [
            "status" => "fail",
            "data"   => [
                "cpf" => [
                    "The cpf must be between 11 and 11 digits.",
                    "O CPF deve possuir 11 digitos."
                ],
            ]
        ];

        $response = $this->json('POST', self::URL, $templateBody);

        $response
            ->seeJsonEquals($templateMessageCPF)
            ->assertResponseStatus(422);

        $templateBody['cpf'] = "1239939291a";
        $templateMessageCPF["data"]  = [
                "cpf" => [
                    "The cpf must be between 11 and 11 digits.",
                    "CPF Inválido."
                ],
        ];

        $response = $this->json('POST', self::URL, $templateBody);

        $response
            ->seeJsonEquals($templateMessageCPF)
            ->assertResponseStatus(422);

        $templateBody['cpf'] = "1239939291a1";
        $templateMessageCPF["data"]  = [
            "cpf" => [
                "The cpf must be between 11 and 11 digits.",
                "O CPF deve possuir 11 digitos."
            ],
        ];

        $response = $this->json('POST', self::URL, $templateBody);

        $response
            ->seeJsonEquals($templateMessageCPF)
            ->assertResponseStatus(422);

        $templateBody['cpf'] = "12399392912";
        $templateMessageCPF["data"]  = [
            "cpf" => [
                "CPF Inválido."
            ],
        ];

        $response = $this->json('POST', self::URL, $templateBody);

        $response
            ->seeJsonEquals($templateMessageCPF)
            ->assertResponseStatus(422);
    }

    public function testFailCreateDocumentCNPJ()
    {
        $templateBody = [];

        $templateMessage = [
            "status"  => "fail",
            "data"  => [
                "cpf" => [
                    "The cpf field is required when cnpj is ."
                ],
                "cnpj" => [
                    "The cnpj field is required when cpf is ."
                ]
            ]
        ];

        $response = $this->json('POST', self::URL, $templateBody);

        $response
            ->seeJsonEquals($templateMessage)
            ->assertResponseStatus(422);

        $templateBody['cnpj'] = "asda";
        $templateMessageCNPJ  = [
            "status" => "fail",
            "data"   => [
                "cnpj" => [
                    "The cnpj must be between 14 and 14 digits.",
                    "O CNPJ deve possuir 14 digitos."
                ],
            ]
        ];

        $response = $this->json('POST', self::URL, $templateBody);

        $response
            ->seeJsonEquals($templateMessageCNPJ)
            ->assertResponseStatus(422);

        $templateBody['cnpj'] = "asda";
        $templateMessageCNPJ  = [
            "status" => "fail",
            "data"   => [
                "cnpj" => [
                    "The cnpj must be between 14 and 14 digits.",
                    "O CNPJ deve possuir 14 digitos."
                ],
            ]
        ];

        $response = $this->json('POST', self::URL, $templateBody);

        $response
            ->seeJsonEquals($templateMessageCNPJ)
            ->assertResponseStatus(422);

        $templateBody['cnpj'] = "1233829909182a";
        $templateMessageCNPJ["data"]  = [
            "cnpj" => [
                "The cnpj must be between 14 and 14 digits.",
                "CNPJ inválido."
            ],
        ];

        $response = $this->json('POST', self::URL, $templateBody);

        $response
            ->seeJsonEquals($templateMessageCNPJ)
            ->assertResponseStatus(422);

        $templateBody['cnpj'] = "123382990918a3";
        $templateMessageCNPJ["data"]  = [
            "cnpj" => [
                "The cnpj must be between 14 and 14 digits.",
                "CNPJ inválido."
            ],
        ];

        $response = $this->json('POST', self::URL, $templateBody);

        $response
            ->seeJsonEquals($templateMessageCNPJ)
            ->assertResponseStatus(422);

        $templateBody['cnpj'] = "12338299091823";
        $templateMessageCNPJ["data"]  = [
            "cnpj" => [
                "CNPJ inválido."
            ],
        ];

        $response = $this->json('POST', self::URL, $templateBody);

        $response
            ->seeJsonEquals($templateMessageCNPJ)
            ->assertResponseStatus(422);
    }

    public function testFailUpdateDocumentCNPJ()
    {
        $response = $this->json('PUT', self::URL);

        $response->assertResponseStatus(405);

        $templateMessage = [
            "status"  => "error",
            "message" => "There is not register to this ID!"
        ];

        $response = $this->json('PUT', self::URL."/a");

        $response
            ->seeJsonEquals($templateMessage)
            ->assertResponseStatus(400);
    }

    public function testFailUpdateDocumentCPF()
    {
        $response = $this->json('PUT', self::URL);

        $response->assertResponseStatus(405);

        $templateMessage = [
            "status"  => "error",
            "message" => "There is not register to this ID!"
        ];

        $response = $this->json('PUT', self::URL."/a");

        $response
            ->seeJsonEquals($templateMessage)
            ->assertResponseStatus(400);

        $templateMessage = [
            "status"  => "error",
            "message" => "There is not register to this ID!"

        ];

        $response = $this->json('PUT', self::URL."/10");
        $response
            ->seeJsonEquals($templateMessage)
            ->assertResponseStatus(400);
    }
}

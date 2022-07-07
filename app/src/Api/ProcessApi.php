<?php

namespace Source\Api;

use Dompdf\Dompdf;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use LandKit\Route\Route;

class ProcessApi extends SupeAuthApi
{
    /**
     * @return void
     */
    public function open(): void
    {
        $errors = [];
        $data = (json_decode(file_get_contents('php://input'), true) ?? []);

        if (empty($data['nomeInteressado'])) {
            $errors[12001] = errorByCode(12001);
        } elseif (!is_string($data['nomeInteressado'])) {
            $errors[11003] = errorByCode(11003);
        }

        if (empty($data['tipoInteressado'])) {
            $errors[12002] = errorByCode(12002);
        } elseif (!is_string($data['tipoInteressado'])) {
            $errors[11004] = errorByCode(11004);
        }

        if (empty($data['cpfCnpjInteressado'])) {
            $errors[12003] = errorByCode(12003);
        } elseif (!is_string($data['cpfCnpjInteressado'])) {
            $errors[11005] = errorByCode(11005);
        }

        if (empty($data['origem'])) {
            $errors[12004] = errorByCode(12004);
        } elseif (!is_string($data['origem'])) {
            $errors[11006] = errorByCode(11006);
        }

        if (empty($data['codigoSecretaria'])) {
            $errors[12005] = errorByCode(12005);
        } elseif (!is_int($data['codigoSecretaria'])) {
            $errors[11007] = errorByCode(11007);
        }

        if (empty($data['codigoSetor'])) {
            $errors[12006] = errorByCode(12006);
        } elseif (!is_int($data['codigoSetor'])) {
            $errors[11008] = errorByCode(11008);
        }

        if (empty($data['codigoNatureza'])) {
            $errors[12007] = errorByCode(12007);
        } elseif (!is_int($data['codigoNatureza'])) {
            $errors[11009] = errorByCode(11009);
        }

        if (empty($data['tipoDocumento'])) {
            $errors[12008] = errorByCode(12008);
        } elseif (!is_int($data['tipoDocumento'])) {
            $errors[11010] = errorByCode(11010);
        }

        if ($errors) {
            http_response_code(self::BAD_REQUEST);
            echo json_encode(['erro' => true, 'erros' => $errors]);
            exit;
        }

        $data['documentos'] = $this->treatDocument(($data['documentos'] ?? null));

        try {
            $response = $this->client->post('processo', [
                'headers' => ['Authorization' => "Bearer {$this->getToken($data['codigoSecretaria'])}"],
                'json' => [
                    'assunto' => $data['assunto'] ?? null,
                    'notificarMovimentacoes' => ($data['notificarMovimentacoes'] ?? true),
                    'natureza' => $data['codigoNatureza'],
                    'secretaria' => $data['codigoSecretaria'],
                    'setor' => $data['codigoSetor'],
                    'origem' => $data['origem'],
                    'tipoDocumento' => $data['tipoDocumento'],
                    'requerimento' => ($data['requerimento'] ?? ''),
                    'tipoInteressado' => $data['tipoInteressado'],
                    'nomeInteressado' => $data['nomeInteressado'],
                    'emailInteressado' => $data['emailInteressado'] ?? '',
                    'cpfCnpjInteressado' => $data['cpfCnpjInteressado'],
                    'documentos' => $data['documentos']
                ]
            ]);

            echo $response->getBody();
        } catch (GuzzleException|Exception $e) {
            $this->unexpected();
        }
    }

    /**
     * @return void
     */
    public function origin(): void
    {
        try {
            $response = $this->client->get('processo/origem', [
                'headers' => ['Authorization' => "Bearer {$this->getToken()}"],
                'json' => []
            ]);

            echo $response->getBody();
        } catch (GuzzleException|Exception $e) {
            $this->unexpected();
        }
    }

    /**
     * @return void
     */
    public function receive(): void
    {
        $errors = [];
        $data = (json_decode(file_get_contents('php://input'), true) ?? []);

        if (empty($data['anoProcesso'])) {
            $errors[12012] = errorByCode(12012);
        } elseif (!is_int($data['anoProcesso'])) {
            $errors[11011] = errorByCode(11011);
        }

        if (empty($data['codigoSecretaria'])) {
            $errors[12005] = errorByCode(12005);
        } elseif (!is_int($data['codigoSecretaria'])) {
            $errors[11007] = errorByCode(11007);
        }

        if (empty($data['numeroProcesso'])) {
            $errors[12013] = errorByCode(12013);
        } elseif (!is_int($data['numeroProcesso'])) {
            $errors[11012] = errorByCode(11012);
        }

        if ($errors) {
            http_response_code(self::BAD_REQUEST);
            echo json_encode(['erro' => true, 'erros' => $errors]);
            exit;
        }

        try {
            $this->client->post('processo/receber', [
                'headers' => ['Authorization' => "Bearer {$this->getToken($data['codigoSecretaria'])}"],
                'json' => [
                    'numeroProcesso' => $data['numeroProcesso'],
                    'codigoSecretariaProcesso' => $data['codigoSecretaria'],
                    'anoProcesso' => $data['anoProcesso']
                ]
            ]);
        } catch (GuzzleException|Exception $e) {
            $this->unexpected();
        }
    }

    /**
     * @return void
     */
    public function proceed(): void
    {
        $errors = [];
        $data = (json_decode(file_get_contents('php://input'), true) ?? []);

        if (empty($data['anoProcesso'])) {
            $errors[12012] = errorByCode(12012);
        } elseif (!is_int($data['anoProcesso'])) {
            $errors[11011] = errorByCode(11011);
        }

        if (empty($data['codigoSecretaria'])) {
            $errors[12005] = errorByCode(12005);
        } elseif (!is_int($data['codigoSecretaria'])) {
            $errors[11007] = errorByCode(11007);
        }

        if (empty($data['numeroProcesso'])) {
            $errors[12013] = errorByCode(12013);
        } elseif (!is_int($data['numeroProcesso'])) {
            $errors[11012] = errorByCode(11012);
        }

        if (empty($data['codigoSecretariaDestino'])) {
            $errors[12014] = errorByCode(12014);
        } elseif (!is_int($data['codigoSecretariaDestino'])) {
            $errors[11013] = errorByCode(11013);
        }

        if (empty($data['codigoSetorDestino'])) {
            $errors[12015] = errorByCode(12015);
        } elseif (!is_int($data['codigoSetorDestino'])) {
            $errors[11014] = errorByCode(11014);
        }

        if (empty($data['motivo'])) {
            $errors[12016] = errorByCode(12016);
        } elseif (!is_int($data['codigoSetorDestino'])) {
            $errors[11015] = errorByCode(11015);
        }

        if ($errors) {
            http_response_code(self::BAD_REQUEST);
            echo json_encode(['erro' => true, 'erros' => $errors]);
            exit;
        }

        try {
            $this->client->post('processo/tramitar', [
                'headers' => ['Authorization' => "Bearer {$this->getToken($data['codigoSecretaria'])}"],
                'json' => [
                    'numeroProcesso' => $data['numeroProcesso'],
                    'codigoSecretariaProcesso' => $data['codigoSecretaria'],
                    'anoProcesso' => $data['anoProcesso'],
                    'codigoSecretariaDestino' => $data['codigoSecretariaDestino'],
                    'codigoSetorDestino' => $data['codigoSetorDestino'],
                    'motivo' => $data['motivo']
                ]
            ]);
        } catch (GuzzleException|Exception $e) {
            $this->unexpected();
        }
    }

    /**
     * @param array $data
     * @return void
     */
    public function consult(array $data): void
    {
        $errors = [];

        if (!is_numeric($data['secretary'])) {
            $errors[14001] = errorByCode(14001);
        }

        if (!is_numeric($data['year'])) {
            $errors[14002] = errorByCode(14002);
        }

        if (!is_numeric($data['number'])) {
            $errors[14003] = errorByCode(14003);
        }

        if ($errors) {
            http_response_code(self::BAD_REQUEST);
            echo json_encode(['erro' => true, 'erros' => $errors]);
            exit;
        }

        try {
            $response = $this->client->get(
                "processo/{$data['secretary']}/{$data['number']}/{$data['year']}",
                ['headers' => ['Authorization' => "Bearer {$this->getToken($data['secretary'])}"]]
            );

            echo $response->getBody();
        } catch (GuzzleException|Exception $e) {
            $this->unexpected();
        }
    }

    /**
     * @return void
     */
    public function redirect(): void
    {
        $token = str_replace('Bearer ', '', getallheaders()['Authorization']);
        $headers = ['Authorization' => "Bearer {$token}"];
        $url = str_replace($_SERVER['HTTP_HOST'], 'localhost', Route::route('supe.api.process.open'));
        $data = (json_decode(file_get_contents('php://input'), true) ?? []);
        $protocolSector = $this->getProtocolSector($data['codigoSecretaria']);
        $proceedToSector = $data['codigoSetor'];
        $data['codigoSetor'] = $protocolSector;
        $client = new Client();

        try {
            $open = $client->post($url, [
                'headers' => $headers,
                'json' => $data
            ]);
            $openData = json_decode($open->getBody(), true);

            if ($protocolSector != $proceedToSector) {
                $client->post("{$url}/receber", [
                    'headers' => $headers,
                    'json' => [
                        'codigoSecretaria' => (int) $openData['codigoSecretariaOrigem'],
                        'numeroProcesso' => $openData['numero'],
                        'anoProcesso' => $openData['ano']
                    ]
                ]);

                $client->post("{$url}/tramitar", [
                    'headers' => $headers,
                    'json' => [
                        'codigoSecretaria' => (int) $openData['codigoSecretariaOrigem'],
                        'numeroProcesso' => $openData['numero'],
                        'anoProcesso' => $openData['ano'],
                        'codigoSecretariaDestino' => (int) $openData['codigoSecretariaOrigem'],
                        'codigoSetorDestino' => $proceedToSector,
                        'motivo' => 'Automação Online Maceió'
                    ]
                ]);
            }

            $consult = $client->get(
                "{$url}/{$openData['codigoSecretariaOrigem']}/{$openData['numero']}/{$openData['ano']}",
                ['headers' => $headers]
            );

            echo $consult->getBody();
        } catch (GuzzleException|Exception $e) {
            $this->unexpected();
        }
    }

    /**
     * @param array|null $documents
     * @return array|null
     */
    private function treatDocument(?array $documents): ?array
    {
        if (!$documents) {
            return null;
        }

        $errors = [];
        $allowedFiles = [];

        $allowedMimeTypes = [
            'image/png',
            'image/jpeg'
        ];

        foreach ($documents as $document) {
            $fopen = finfo_open();
            $mimeType = finfo_buffer($fopen, base64_decode($document['bytes']), FILEINFO_MIME_TYPE);

            if ($mimeType == 'application/pdf') {
                $size = (strlen($document['bytes']) / 1024) / 1024; // Megabytes

                if ($size < 10) {
                    $allowedFiles[] = $document;
                } else {
                    $errors[11001][] = $document['descricao'];
                }
            } elseif (in_array($mimeType, $allowedMimeTypes)) {
                $dompdf = new Dompdf();
                $dompdf->loadHtml("<img src='data:{$mimeType};base64,{$document['bytes']}' style='max-width: 100%;' alt='{$document['descricao']}' />");
                $dompdf->render();

                // Faz download do arquivo (apenas para teste)
                // $dompdf->stream('documento.pdf');

                $pdfBase64Encoded = base64_encode($dompdf->output());
                $size = (strlen($pdfBase64Encoded) / 1024) / 1024; // Megabytes

                if ($size < 10) {
                    $document['descricao'] = substr($document['descricao'], 0, strripos($document['descricao'], '.')) . 'pdf';
                    $document['bytes'] = $pdfBase64Encoded;

                    $allowedFiles[] = $document;
                } else {
                    $errors[11001][] = $document['descricao'];
                }
            } else {
                $errors[11002][] = $document['descricao'];
            }

            finfo_close($fopen);
        }

        if ($errors) {
            echo json_encode(['erro' => true, 'erros' => $errors]);
            exit;
        }

        return $allowedFiles ?: null;
    }
}

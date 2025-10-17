<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class DocumentController extends Controller
{
    protected $templatesPath;
    protected $assetsPath;
    protected $tempPath;

    public function __construct()
    {
        $this->templatesPath = app_path('Docs/Templates/');
        $this->assetsPath = app_path('Docs/Templates/Assets/');
        $this->tempPath = storage_path('app/temp/');

        // Crear directorio temporal si no existe
        if (!file_exists($this->tempPath)) {
            mkdir($this->tempPath, 0755, true);
        }
    }

    protected function processLogos($templateProcessor, $logos = null)
    {
        $defaultLogos = [
            'LOGO_INSTITUCION' => [
                'file' => 'logo_colegio.png',
                'width' => 80,
                'height' => 80
            ],
            'LOGO_MINEDU' => [
                'file' => 'logo_ministerio.png',
                'width' => 280,
                'height' => 80
            ],
            'LOGO_UGEL' => [
                'file' => 'ugel_logo.jpg',
                'width' => 80,
                'height' => 80
            ]
        ];

        $logosToProcess = $logos ?? $defaultLogos;

        foreach ($logosToProcess as $placeholder => $logoData) {
            // Si es string (compatibilidad con formato anterior), convertir a array
            if (is_string($logoData)) {
                $logoData = [
                    'file' => $logoData,
                    'width' => 80,
                    'height' => 80
                ];
            }

            $rutaLogo = $this->assetsPath . $logoData['file'];

            if (file_exists($rutaLogo)) {
                try {
                    $templateProcessor->setImageValue($placeholder, [
                        'path' => $rutaLogo,
                        'width' => $logoData['width'],
                        'height' => $logoData['height'],
                        'ratio' => false
                    ]);
                } catch (\Exception $e) {
                    $templateProcessor->setValue($placeholder, '[LOGO]');
                }
            } else {
                $templateProcessor->setValue($placeholder, '[LOGO NO ENCONTRADO: ' . $logoData['file'] . ']');
            }
        }
    }

    protected function generateTempFile($prefix, $extension = 'docx')
    {
        $nombreArchivo = $prefix . '_' . time() . '_' . uniqid() . '.' . $extension;
        return $this->tempPath . $nombreArchivo;
    }

    protected function downloadResponse($filePath, $filename)
    {
        return response()->download($filePath, $filename)->deleteFileAfterSend(true);
    }
}

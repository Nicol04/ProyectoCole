<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Protection;

abstract class BaseExport implements WithCustomStartCell, WithEvents, WithDrawings
{
    protected $titulo; // Título principal
    protected $subtitulo; // Subtítulo
    protected $ultimaColumna; // Última columna de la hoja (dinámica)
    public array $columnasCentradas = [];
    public string $colorSubtitulo;

    public function __construct($titulo = 'Título', $subtitulo = 'Subtítulo', $ultimaColumna = 'G', string $colorSubtitulo = 'C6EFCE')
    {
        $this->titulo = $titulo;
        $this->subtitulo = $subtitulo;
        $this->ultimaColumna = $ultimaColumna;
        $this->colorSubtitulo = $colorSubtitulo;
    }
    /**
     * Punto inicial de la tabla de datos.
     */
    public function startCell(): string
    {
        return 'B8'; // Comienzo estándar para los datos
    }

    /**
     * Registro de eventos para aplicar estilos.
     */
    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // ** Título principal **
                $sheet->mergeCells("B3:{$this->ultimaColumna}3");
                $sheet->setCellValue('B3', $this->titulo);
                $sheet->getStyle("B3:{$this->ultimaColumna}3")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 24,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'D9D9D9'],
                    ],
                ]);

                // ** Subtítulo **
                $sheet->mergeCells("B5:{$this->ultimaColumna}5");
                $sheet->setCellValue('B5', $this->subtitulo);
                $sheet->getStyle("B5:{$this->ultimaColumna}5")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'D9D9D9'], // Aquí se usa el color dinámico
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                // ** Fondo superior general (B3 hasta última fila de encabezados) **
                $sheet->getStyle("B3:{$this->ultimaColumna}6")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'D9D9D9'],
                    ],
                ]);

                // ** Estilo para los encabezados de la tabla (B8 hasta última columna en fila 8) **
                $sheet->getStyle("B8:{$this->ultimaColumna}8")->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => $this->colorSubtitulo],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                // ** Centrar columnas específicas **
                foreach ($this->columnasCentradas as $columna) {
                    $sheet->getStyle("{$columna}8:{$columna}" . $sheet->getHighestRow())
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                // ** Agregar fecha y hora en la esquina superior derecha **
                $fechaHora = Carbon::now()->format('d/m/Y h:i a'); // Formato de fecha y hora
                $ultimaColumnaFecha = "{$this->ultimaColumna}2"; // Combina última columna con la fila 2
                $sheet->mergeCells("F2:{$ultimaColumnaFecha}"); // Combinar celdas para mostrar el texto
                $sheet->setCellValue("F2", "Descargado a: $fechaHora");
                $sheet->getStyle("F2:{$ultimaColumnaFecha}")->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $ultimaFila = $sheet->getHighestRow();
                for ($fila = 9; $fila <= $ultimaFila; $fila++) {
                    $sheet->getRowDimension($fila)->setRowHeight(20);
                }
                // ** Protección de la hoja **
                $sheet->getProtection()->setSheet(true); // Habilitar protección en toda la hoja

                // Desbloquear columnas desde B hasta la última columna
                foreach (range('B', $this->ultimaColumna) as $columna) {
                    $sheet->getStyle("{$columna}1:{$columna}1048576") // Desde la fila 1 hasta la última fila posible en Excel
                        ->getProtection()
                        ->setLocked(Protection::PROTECTION_UNPROTECTED);
                }

                // ** Ajuste automático de columnas **
                foreach (range('B', $this->ultimaColumna) as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }

    /**
     * Dibuja el logo en la hoja.
     */
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('assets/img/logo_colegio.png')); // Ruta al logo
        $drawing->setHeight(90); // Altura del logo
        $drawing->setCoordinates('B3'); // Ubicación inicial

        return $drawing;
    }
}
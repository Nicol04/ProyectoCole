<?php

namespace App\Http\Controllers\Documents;

use App\Models\Unidad;
use App\Models\User;
use App\Models\EnfoqueTransversal;
use App\Models\Curso;
use App\Models\Competencia;
use App\Models\Capacidad;
use App\Models\Desempeno;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class UnidadDocumentController extends DocumentController
{

    public function previsualizar($id, Request $request)
    {
        try {
            $unidad = Unidad::findOrFail($id);
            $detalle = $unidad->detalles->first();
            $orientacion = $request->get('orientacion', 'vertical');

            // Procesar datos
            $profesores = $this->getProfesoresInfo($unidad->profesores_responsables);
            $cursosInfo = $this->procesarContenidoCurricular($detalle);
            $enfoquesInfo = $this->procesarEnfoquesTransversales($detalle);

            // Generar documento
            $rutaArchivo = $this->generarDocumento($unidad, $detalle, $profesores, $cursosInfo, $enfoquesInfo, $orientacion);

            // Nombre del archivo de descarga
            $nombreDescarga = 'Unidad_' . str_replace(' ', '_', $unidad->nombre) . '_' . date('Y-m-d') . '.docx';

            return $this->downloadResponse($rutaArchivo, $nombreDescarga);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error al generar documento: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generarDocumento($unidad, $detalle, $profesores, $cursosInfo, $enfoquesInfo, $orientacion)
    {
        // Seleccionar plantilla
        $plantillaFile = $orientacion === 'horizontal' ? 'plantilla_horizontal.docx' : 'plantilla_vertical.docx';
        $plantilla = $this->templatesPath . 'Unidades/' . $plantillaFile;

        if (!file_exists($plantilla)) {
            throw new \Exception('Plantilla no encontrada: ' . $plantilla);
        }

        $templateProcessor = new TemplateProcessor($plantilla);

        // Procesar variables básicas
        $this->procesarVariablesBasicas($templateProcessor, $unidad, $profesores);

        // Procesar contenido específico
        $this->procesarEnfoques($templateProcessor, $enfoquesInfo);
        $this->procesarContenidoCurricularTemplate($templateProcessor, $cursosInfo);
        $this->procesarMateriales($templateProcessor, $detalle);

        // Procesar logos
        $this->processLogos($templateProcessor);

        // Generar archivo temporal
        $rutaTemp = $this->generateTempFile('unidad_' . $unidad->id);
        $templateProcessor->saveAs($rutaTemp);

        return $rutaTemp;
    }

    private function procesarVariablesBasicas($templateProcessor, $unidad, $profesores)
    {
        $templateProcessor->setValue('NOMBRE_UNIDAD', $unidad->nombre);
        $templateProcessor->setValue(
            'GRADO_SECCIONES',
            $unidad->grado . '° grado - Secciones: ' . implode(', ', $unidad->secciones ?? [])
        );
        $templateProcessor->setValue('FECHA_INICIO', $unidad->fecha_inicio->format('d/m/Y'));
        $templateProcessor->setValue('FECHA_FIN', $unidad->fecha_fin->format('d/m/Y'));

        // Profesores
        $profesoresTexto = '';
        if ($profesores && $profesores->count() > 0) {
            foreach ($profesores as $profesor) {
                $profesoresTexto .= '• ' . $profesor['nombre_completo'] . "\n";
            }
        } else {
            $profesoresTexto = '• No asignado';
        }
        $templateProcessor->setValue('PROFESORES', trim($profesoresTexto));

        $templateProcessor->setValue(
            'SITUACION_SIGNIFICATIVA',
            $unidad->situacion_significativa ?? 'No especificada'
        );
    }

    private function procesarEnfoquesTransversales($detalle)
    {
        if (!$detalle || !$detalle->enfoques) { // ⚠️ Cambiar de 'enfoques_transversales' a 'enfoques'
            return [];
        }

        // Decodificar JSON si es string
        $enfoques = is_string($detalle->enfoques) // ⚠️ Cambiar aquí también
            ? json_decode($detalle->enfoques, true)
            : $detalle->enfoques;

        if (!is_array($enfoques)) {
            return [];
        }

        $enfoquesInfo = [];

        // Procesar cada enfoque del JSON - ⚠️ Cambiar la lógica para coincidir con UnidadController
        foreach ($enfoques as $key => $enfoqueItem) {
            if (!isset($enfoqueItem['enfoque_id'])) {
                continue;
            }

            // Buscar el enfoque en la base de datos
            $enfoque = EnfoqueTransversal::find($enfoqueItem['enfoque_id']);
            if (!$enfoque) continue;

            $valores = [];

            // Procesar los valores del enfoque
            if (isset($enfoqueItem['valores']) && is_array($enfoqueItem['valores'])) {
                foreach ($enfoqueItem['valores'] as $valorKey => $valorData) {
                    if (is_array($valorData) && isset($valorData['valor']) && isset($valorData['actitud'])) {
                        $valores[] = [
                            'valor' => $valorData['valor'],
                            'actitud' => $valorData['actitud']
                        ];
                    }
                }
            }

            $enfoquesInfo[] = [
                'enfoque' => $enfoque,
                'valores' => $valores
            ];
        }

        return $enfoquesInfo;
    }

    private function procesarEnfoques($templateProcessor, $enfoquesInfo)
    {
        if (count($enfoquesInfo) > 0) {
            // Crear arrays para cada columna
            $enfoques = [];
            $valores = [];
            $actitudes = [];

            foreach ($enfoquesInfo as $enfoqueInfo) {
                $nombreEnfoque = $enfoqueInfo['enfoque']->nombre ?? 'Sin nombre';
                $primeraFila = true;

                if (count($enfoqueInfo['valores']) > 0) {
                    foreach ($enfoqueInfo['valores'] as $valor) {
                        $enfoques[] = $primeraFila ? $nombreEnfoque : '';
                        $valores[] = $valor['valor'];
                        $actitudes[] = '● ' . $valor['actitud'];
                        $primeraFila = false;
                    }
                } else {
                    $enfoques[] = $nombreEnfoque;
                    $valores[] = 'No especificado';
                    $actitudes[] = '● No especificado';
                }
            }

            // Reemplazar valores en la plantilla
            $templateProcessor->setValue('ENFOQUES_TRANSVERSALES', implode("\n", $enfoques));
            $templateProcessor->setValue('VALORES_ENFOQUES', implode("\n", $valores));
            $templateProcessor->setValue('ACTITUDES_ENFOQUES', implode("\n", $actitudes));
        } else {
            $templateProcessor->setValue('ENFOQUES_TRANSVERSALES', 'No se han definido enfoques transversales');
            $templateProcessor->setValue('VALORES_ENFOQUES', '');
            $templateProcessor->setValue('ACTITUDES_ENFOQUES', '');
        }
    }

    private function procesarContenidoCurricular($detalle)
    {
        if (!$detalle || !$detalle->contenido) {
            return [];
        }

        $contenido = is_string($detalle->contenido)
            ? json_decode($detalle->contenido, true)
            : $detalle->contenido;

        if (!is_array($contenido)) {
            return [];
        }

        $cursosInfo = [];

        // Procesar el formato nuevo con estructura 'cursos'
        if (isset($contenido['cursos']) && is_array($contenido['cursos'])) {
            foreach ($contenido['cursos'] as $cursoData) {
                if (!isset($cursoData['curso_id'])) continue;

                $curso = Curso::find($cursoData['curso_id']);
                if (!$curso) continue;

                $competenciasInfo = [];

                if (isset($cursoData['competencias']) && is_array($cursoData['competencias'])) {
                    foreach ($cursoData['competencias'] as $compData) {
                        $competencia = Competencia::find($compData['competencia_id']);
                        if (!$competencia) continue;

                        // Obtener capacidades por IDs
                        $capacidades = collect();
                        if (isset($compData['capacidades']) && is_array($compData['capacidades'])) {
                            $capacidadesIds = array_filter($compData['capacidades'], function ($id) {
                                return !empty($id) && is_numeric($id);
                            });

                            if (!empty($capacidadesIds)) {
                                $capacidades = Capacidad::whereIn('id', $capacidadesIds)->get();
                            }
                        }

                        // Obtener desempeños por IDs
                        $desempenos = collect();
                        if (isset($compData['desempenos']) && is_array($compData['desempenos'])) {
                            $desempenosIds = array_filter($compData['desempenos'], function ($id) {
                                return !empty($id) && is_numeric($id);
                            });

                            if (!empty($desempenosIds)) {
                                $desempenos = Desempeno::whereIn('id', $desempenosIds)->get();
                            }
                        }

                        // Procesar instrumentos
                        $instrumentos = [];
                        if (isset($compData['instrumentos']) && is_array($compData['instrumentos'])) {
                            $instrumentos = array_filter($compData['instrumentos'], function ($instrumento) {
                                return !empty($instrumento);
                            });
                        }

                        $competenciasInfo[] = [
                            'competencia' => $competencia,
                            'capacidades' => $capacidades,
                            'desempenos' => $desempenos,
                            'criterios' => $compData['criterios'] ?? 'No especificado',
                            'evidencias' => $compData['evidencias'] ?? 'No especificado',
                            'instrumentos' => $instrumentos
                        ];
                    }
                }

                $cursosInfo[] = [
                    'curso' => $curso,
                    'competencias' => $competenciasInfo
                ];
            }
        }
        // Mantener compatibilidad con formato anterior
        else {
            foreach ($contenido as $cursoId => $cursoData) {
                $curso = Curso::find($cursoId);
                if (!$curso) continue;

                $competenciasInfo = [];

                if (isset($cursoData['competencias']) && is_array($cursoData['competencias'])) {
                    foreach ($cursoData['competencias'] as $competenciaId => $competenciaData) {
                        $competencia = Competencia::find($competenciaId);
                        if (!$competencia) continue;

                        // Obtener capacidades
                        $capacidadesIds = $competenciaData['capacidades'] ?? [];
                        $capacidades = collect();
                        if (is_array($capacidadesIds) && count($capacidadesIds) > 0) {
                            $capacidades = Capacidad::whereIn('id', $capacidadesIds)->get();
                        }

                        // Obtener desempeños
                        $desempenosIds = $competenciaData['desempenos'] ?? [];
                        $desempenos = collect();
                        if (is_array($desempenosIds) && count($desempenosIds) > 0) {
                            $desempenos = Desempeno::whereIn('id', $desempenosIds)->get();
                        }

                        $competenciasInfo[] = [
                            'competencia' => $competencia,
                            'capacidades' => $capacidades,
                            'desempenos' => $desempenos,
                            'criterios' => $competenciaData['criterios'] ?? null,
                            'evidencias' => $competenciaData['evidencias'] ?? null,
                            'instrumentos' => $competenciaData['instrumentos'] ?? []
                        ];
                    }
                }

                $cursosInfo[] = [
                    'curso' => $curso,
                    'competencias' => $competenciasInfo
                ];
            }
        }

        return $cursosInfo;
    }
    private function procesarContenidoCurricularTemplate($templateProcessor, $cursosInfo)
    {
        if (count($cursosInfo) > 0) {
            // ✅ ARRAYS para acumular TODAS las filas (una por competencia)
            $areas = [];
            $competenciasTexto = [];
            $desempenosTexto = [];
            $criteriosTexto = [];
            $evidenciasTexto = [];
            $instrumentosTexto = [];

            foreach ($cursosInfo as $cursoInfo) {
                $nombreCurso = $cursoInfo['curso']->curso;
                $competencias = $cursoInfo['competencias'];

                if (count($competencias) > 0) {
                    // ✅ CREAR UNA FILA POR CADA COMPETENCIA
                    foreach ($competencias as $index => $competenciaInfo) {
                        
                        // ✅ ÁREA: Solo mostrar en la primera competencia del curso
                        if ($index === 0) {
                            $areas[] = $nombreCurso;
                        } else {
                            $areas[] = ''; // Celda vacía para competencias adicionales del mismo curso
                        }

                        // ✅ COMPETENCIA + CAPACIDADES en una sola celda
                        $competenciaCompleta = $competenciaInfo['competencia']->nombre;
                        if ($competenciaInfo['capacidades']->count() > 0) {
                            foreach ($competenciaInfo['capacidades'] as $capacidad) {
                                $competenciaCompleta .= "\n• " . $capacidad->nombre;
                            }
                        }
                        $competenciasTexto[] = $competenciaCompleta;

                        // ✅ DESEMPEÑOS en una sola celda
                        if ($competenciaInfo['desempenos']->count() > 0) {
                            $desempenosArray = [];
                            foreach ($competenciaInfo['desempenos'] as $desempeno) {
                                $desempenosArray[] = "• " . $desempeno->descripcion;
                            }
                            $desempenosTexto[] = implode("\n", $desempenosArray);
                        } else {
                            $desempenosTexto[] = "No especificado";
                        }

                        // ✅ CRITERIOS
                        $criteriosTexto[] = $competenciaInfo['criterios'] ?: 'No especificado';

                        // ✅ EVIDENCIAS
                        $evidenciasTexto[] = $competenciaInfo['evidencias'] ?: 'No especificado';

                        // ✅ INSTRUMENTOS
                        if (is_array($competenciaInfo['instrumentos']) && count($competenciaInfo['instrumentos']) > 0) {
                            $instrumentosTexto[] = implode("\n", $competenciaInfo['instrumentos']);
                        } else {
                            $instrumentosTexto[] = 'No especificado';
                        }
                    }
                } else {
                    // Si el curso no tiene competencias
                    $areas[] = $nombreCurso;
                    $competenciasTexto[] = 'No hay competencias definidas';
                    $desempenosTexto[] = '';
                    $criteriosTexto[] = '';
                    $evidenciasTexto[] = '';
                    $instrumentosTexto[] = '';
                }
            }

            // ✅ INTENTAR USAR CLONEROW PARA GENERAR FILAS DINÁMICAS
            try {
                if (count($areas) > 1) {
                    $templateProcessor->cloneRow('CURSO', count($areas));
                    
                    // Asignar valores a cada fila clonada
                    for ($i = 0; $i < count($areas); $i++) {
                        $index = $i + 1;
                        $templateProcessor->setValue("CURSO#${index}", $areas[$i]);
                        $templateProcessor->setValue("COMPETENCIA#${index}", $competenciasTexto[$i]);
                        $templateProcessor->setValue("DESEMPEÑOS#${index}", $desempenosTexto[$i]);
                        $templateProcessor->setValue("CRITERIOS#${index}", $criteriosTexto[$i]);
                        $templateProcessor->setValue("EVIDENCIAS#${index}", $evidenciasTexto[$i]);
                        $templateProcessor->setValue("INSTRUMENTOS#${index}", $instrumentosTexto[$i]);
                    }
                } else {
                    // Si solo hay una fila, usar método tradicional
                    throw new \Exception("Solo una fila, usar método tradicional");
                }
            } catch (\Exception $e) {
                // ✅ FALLBACK: Si cloneRow no funciona, usar el método tradicional
                // Cada "\n" representa una nueva fila en la tabla de Word
                $templateProcessor->setValue('CURSO', implode("\n", $areas));
                $templateProcessor->setValue('COMPETENCIA', implode("\n", $competenciasTexto));
                $templateProcessor->setValue('DESEMPEÑOS', implode("\n", $desempenosTexto));
                $templateProcessor->setValue('CRITERIOS', implode("\n", $criteriosTexto));
                $templateProcessor->setValue('EVIDENCIAS', implode("\n", $evidenciasTexto));
                $templateProcessor->setValue('INSTRUMENTOS', implode("\n", $instrumentosTexto));
                
                // También establecer las variables con números por si la plantilla las usa
                $templateProcessor->setValue('CAPACIDADES', implode("\n", $competenciasTexto));
            }

        } else {
            // No hay contenido curricular
            $templateProcessor->setValue('CURSO', 'No se ha definido contenido curricular');
            $templateProcessor->setValue('COMPETENCIA', '');
            $templateProcessor->setValue('DESEMPEÑOS', '');
            $templateProcessor->setValue('CRITERIOS', '');
            $templateProcessor->setValue('EVIDENCIAS', '');
            $templateProcessor->setValue('INSTRUMENTOS', '');
            $templateProcessor->setValue('CAPACIDADES', '');
        }
    }
    
    private function procesarMateriales($templateProcessor, $detalle)
    {
        $materialesBasicos = $detalle && $detalle->materiales_basicos
            ? $detalle->materiales_basicos
            : 'No especificado';

        $recursos = $detalle && $detalle->recursos
            ? $detalle->recursos
            : 'No especificado';

        $templateProcessor->setValue('MATERIALES_BASICOS', $materialesBasicos);
        $templateProcessor->setValue('RECURSOS', $recursos);
    }

    // === MÉTODOS HELPER ===

    private function getProfesoresInfo($profesoresResponsables)
    {
        if (!$profesoresResponsables || empty($profesoresResponsables)) {
            return collect();
        }

        // Decodificar JSON si es string
        $profesoresIds = is_string($profesoresResponsables)
            ? json_decode($profesoresResponsables, true)
            : $profesoresResponsables;

        if (!is_array($profesoresIds)) {
            return collect();
        }

        // Obtener solo los IDs del array/objeto
        $ids = [];
        foreach ($profesoresIds as $key => $value) {
            if (is_numeric($key)) {
                // Si la clave es numérica, el valor es el ID
                $ids[] = $value;
            } elseif (is_numeric($value)) {
                // Si el valor es numérico, es el ID
                $ids[] = $value;
            } elseif (isset($value['id'])) {
                // Si es un objeto con ID
                $ids[] = $value['id'];
            }
        }

        if (empty($ids)) {
            return collect();
        }

        return User::whereIn('id', $ids)
            ->with('persona')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'nombre_completo' => trim(($user->persona->nombre ?? '') . ' ' . ($user->persona->apellido ?? ''))
                ];
            });
    }

    public function vistaPreviaHtml($id, Request $request)
    {
        try {
            $unidad = Unidad::findOrFail($id);
            $detalle = $unidad->detalles->first();
            $orientacion = $request->get('orientacion', 'vertical');

            // Procesar datos
            $profesores = $this->getProfesoresInfo($unidad->profesores_responsables);
            $cursosInfo = $this->procesarContenidoCurricular($detalle);
            $enfoquesInfo = $this->procesarEnfoquesTransversales($detalle);

            // Generar datos para la vista
            $datosVista = [
                'unidad' => $unidad,
                'detalle' => $detalle,
                'profesores' => $profesores,
                'cursosInfo' => $cursosInfo,
                'enfoquesInfo' => $enfoquesInfo,
                'orientacion' => $orientacion,
                'materialesBasicos' => $detalle ? $detalle->materiales_basicos : 'No especificado',
                'recursos' => $detalle ? $detalle->recursos : 'No especificado'
            ];

            // ✅ SELECCIONAR VISTA SEGÚN ORIENTACIÓN
            $vista = $orientacion === 'horizontal' 
                ? 'panel.documentos.vista-previa-unidad-horizontal'
                : 'panel.documentos.vista-previa-unidad';

            return view($vista, $datosVista);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error al generar vista previa: ' . $e->getMessage()
            ], 500);
        }
    }
    public function debug($id)
    {
        $unidad = Unidad::findOrFail($id);
        $detalle = $unidad->detalles->first();

        echo "<h2>🔍 DEBUG - Unidad ID: {$id}</h2>";

        // Debug profesores
        echo "<h3>📋 Profesores Responsables (RAW):</h3>";
        echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
        var_dump($unidad->profesores_responsables);
        echo "</pre>";

        $profesores = $this->getProfesoresInfo($unidad->profesores_responsables);
        echo "<h3>👥 Profesores Procesados:</h3>";
        echo "<pre style='background: #f0f8ff; padding: 10px; border: 1px solid #ddd;'>";
        var_dump($profesores->toArray());
        echo "</pre>";

        // Debug enfoques - ⚠️ Cambiar aquí también
        echo "<h3>📊 Enfoques Transversales (RAW):</h3>";
        if ($detalle) {
            echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ddd;'>";
            var_dump($detalle->enfoques); // ⚠️ Cambiar de 'enfoques_transversales' a 'enfoques'
            echo "</pre>";

            $enfoquesInfo = $this->procesarEnfoquesTransversales($detalle);
            echo "<h3>🎯 Enfoques Procesados:</h3>";
            echo "<pre style='background: #f0fff0; padding: 10px; border: 1px solid #ddd;'>";
            var_dump($enfoquesInfo);
            echo "</pre>";
        } else {
            echo "<p style='color: red;'>❌ No se encontró detalle para esta unidad</p>";
        }

        // Debug contenido curricular
        echo "<h3>📚 Contenido Curricular (RAW):</h3>";
        if ($detalle && $detalle->contenido) {
            echo "<pre style='background: #fff5ee; padding: 10px; border: 1px solid #ddd;'>";
            var_dump($detalle->contenido);
            echo "</pre>";
        } else {
            echo "<p style='color: red;'>❌ No hay contenido curricular</p>";
        }
    }
}

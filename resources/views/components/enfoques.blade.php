{{-- Sección de Enfoques Transversales --}}
<div class="card mt-4 border-warning">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-warning">
                <i class="fas fa-lightbulb me-2"></i>Enfoques Transversales <span class="text-danger">*</span>
            </h5>
            <button type="button" class="btn btn-outline-warning btn-sm" id="agregar-enfoque">
                <i class="fas fa-plus me-1"></i>Agregar Enfoque
            </button>
        </div>
    </div>
    <div class="card-body">
        <div id="enfoques-container">
            {{-- Los enfoques se agregarán aquí dinámicamente --}}
        </div>
        <small class="form-text text-muted">
            <strong>Obligatorio:</strong> Los enfoques transversales son valores y actitudes que se desarrollan de manera integral en todas las áreas curriculares. Debe agregar al menos uno.
        </small>
    </div>
</div>

<style>
/* Estilos específicos para enfoques - versión simple */
.enfoque-card {
    border: 1px solid #ffc107;
    border-radius: 8px;
    margin-bottom: 15px;
    background-color: #fffef7;
}

.enfoque-card .card-body {
    padding: 20px;
}

.valor-box {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 10px;
    background-color: #fff;
}

.form-control {
    width: 100% !important;
    margin-bottom: 10px;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

#enfoques-container {
    min-height: 50px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let enfoqueCounter = 0;
    
    // Botón agregar enfoque
    document.getElementById('agregar-enfoque').addEventListener('click', agregarEnfoque);
    
    function agregarEnfoque() {
        enfoqueCounter++;
        const container = document.getElementById('enfoques-container');
        
        const enfoqueHTML = `
            <div class="enfoque-card card" data-enfoque="${enfoqueCounter}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-warning mb-0">
                            <i class="fas fa-lightbulb me-2"></i>Enfoque ${enfoqueCounter}
                        </h6>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarEnfoque(this)">
                            <i class="fas fa-times"></i> Eliminar
                        </button>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label">Enfoque Transversal</label>
                            <select class="form-control" name="enfoques[${enfoqueCounter}][enfoque_id]" onchange="cargarValores(this)">
                                <option value="">Seleccionar enfoque...</option>
                                @if(isset($enfoques) && count($enfoques) > 0)
                                    @foreach($enfoques as $enfoque)
                                        <option value="{{ $enfoque['id'] }}">{{ $enfoque['nombre'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-outline-primary btn-sm d-block" onclick="agregarValor(this)">
                                <i class="fas fa-plus me-1"></i>Agregar Valor
                            </button>
                        </div>
                    </div>
                    
                    <div class="valores-container">
                        <h6 class="text-primary mb-2">Valores y Actitudes</h6>
                        <div class="valores-list">
                            <!-- Los valores se agregarán aquí -->
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', enfoqueHTML);
    }
    
    // Función global para eliminar enfoque
    window.eliminarEnfoque = function(btn) {
        btn.closest('.enfoque-card').remove();
        actualizarNumeracion();
    };
    
    // Función global para agregar valor
    window.agregarValor = function(btn) {
        const enfoqueCard = btn.closest('.enfoque-card');
        const enfoqueNum = enfoqueCard.dataset.enfoque;
        const valoresList = enfoqueCard.querySelector('.valores-list');
        const valorCounter = valoresList.children.length + 1;
        
        const valorHTML = `
            <div class="valor-box">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted fw-bold">Valor ${valorCounter}</small>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarValor(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Valor</label>
                        <select class="form-control valor-select" name="enfoques[${enfoqueNum}][valores][${valorCounter}][valor]" onchange="actualizarActitud(this)">
                            <option value="">Seleccionar valor...</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Actitud</label>
                        <textarea class="form-control actitud-textarea" name="enfoques[${enfoqueNum}][valores][${valorCounter}][actitud]" rows="2" placeholder="Se llenará automáticamente"></textarea>
                    </div>
                </div>
            </div>
        `;
        
        valoresList.insertAdjacentHTML('beforeend', valorHTML);
        
        // Copiar opciones del enfoque seleccionado
        const enfoqueSelect = enfoqueCard.querySelector('select[name*="enfoque_id"]');
        if (enfoqueSelect.value) {
            cargarValoresParaNuevoSelect(enfoqueSelect, valoresList.lastElementChild.querySelector('.valor-select'));
        }
    };
    
    // Función global para eliminar valor
    window.eliminarValor = function(btn) {
        btn.closest('.valor-box').remove();
    };
    
    // Función global para cargar valores
    window.cargarValores = function(select) {
        const enfoqueCard = select.closest('.enfoque-card');
        const valorSelects = enfoqueCard.querySelectorAll('.valor-select');
        
        valorSelects.forEach(valorSelect => {
            cargarValoresParaNuevoSelect(select, valorSelect);
        });
    };
    
    // Función para cargar valores en un select específico
    function cargarValoresParaNuevoSelect(enfoqueSelect, valorSelect) {
        const enfoqueId = enfoqueSelect.value;
        
        if (!enfoqueId) {
            valorSelect.innerHTML = '<option value="">Seleccionar valor...</option>';
            return;
        }
        
        @if(isset($enfoques) && count($enfoques) > 0)
        const enfoques = @json($enfoques);
        const enfoqueSeleccionado = enfoques.find(e => e.id == enfoqueId);
        
        if (enfoqueSeleccionado && enfoqueSeleccionado.valores) {
            let opciones = '<option value="">Seleccionar valor...</option>';
            
            // Manejar la estructura específica del JSON
            enfoqueSeleccionado.valores.forEach(item => {
                let valor = '';
                let actitud = '';
                
                // Verificar si tiene la estructura type/data
                if (item.type === 'valor_actitud' && item.data) {
                    valor = item.data.Valores || '';
                    actitud = item.data.Actitudes || '';
                } else {
                    // Estructura simple (fallback)
                    valor = item.valor || item.Valores || '';
                    actitud = item.actitud || item.Actitudes || '';
                }
                
                if (valor) {
                    // Escapar caracteres especiales para HTML
                    const valorEscapado = valor.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                    const actitudEscapada = actitud.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                    opciones += `<option value="${valorEscapado}" data-actitud="${actitudEscapada}">${valorEscapado}</option>`;
                }
            });
            
            valorSelect.innerHTML = opciones;
        }
        @endif
    }
    
    // Función global para actualizar actitud
    window.actualizarActitud = function(select) {
        const valorBox = select.closest('.valor-box');
        const actitudTextarea = valorBox.querySelector('.actitud-textarea');
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption && selectedOption.dataset.actitud) {
            // Decodificar entidades HTML si es necesario
            const actitud = selectedOption.dataset.actitud;
            actitudTextarea.value = actitud;
        } else {
            actitudTextarea.value = '';
        }
    };
    
    function actualizarNumeracion() {
        const enfoques = document.querySelectorAll('.enfoque-card');
        enfoques.forEach((enfoque, index) => {
            const numero = index + 1;
            enfoque.dataset.enfoque = numero;
            enfoque.querySelector('h6').innerHTML = `<i class="fas fa-lightbulb me-2"></i>Enfoque ${numero}`;
        });
        enfoqueCounter = enfoques.length;
    }
});
</script>

<link href="{{ asset('css/panel/contenido_curricular.css') }}" rel="stylesheet">

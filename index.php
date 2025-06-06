<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulación de Flujo en Presas Hidroeléctricas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style id="app-style">
        :root {
            --primary-color: #1a73e8;
            --primary-dark: #0d47a1;
            --secondary-color: #34a853;
            --secondary-dark: #2e7d32;
            --error-color: #ea4335;
            --background-color: #f5f7fa;
            --card-bg: #ffffff;
            --text-color: #202124;
            --text-secondary: #5f6368;
            --border-color: #dadce0;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 1.5rem 0;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .header h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
            flex: 1;
        }
        
        .card {
            background: var(--card-bg);
            border-radius: 8px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .checkbox-container input {
            margin-right: 0.5rem;
            width: auto;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn i {
            margin-right: 0.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: var(--secondary-dark);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline:hover {
            background-color: rgba(26, 115, 232, 0.1);
        }
        
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }
        
        .result-container {
            display: none;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .result-value {
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--primary-color);
            margin: 1rem 0;
            padding: 1rem;
            background-color: rgba(26, 115, 232, 0.1);
            border-radius: 4px;
            text-align: center;
        }
        
        .result-details {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .loading .spinner {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            border: 0.25rem solid rgba(26, 115, 232, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s linear infinite;
        }
        
        .derivative-fields {
            display: none;
            padding-top: 1rem;
            margin-top: 1rem;
            border-top: 1px dashed var(--border-color);
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
        }
        
        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem 0;
            margin-top: auto;
            font-size: 0.875rem;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .hidden {
            display: none;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 0 0.5rem;
                margin: 1rem auto;
            }
            
            .card-body {
                padding: 1.5rem;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 1rem;
            }
            
            .btn {
                width: 100%;
            }
        }
        
        /* Tooltip styles */
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: help;
            margin-left: 0.3rem;
        }
        
        .tooltip i {
            color: var(--primary-color);
        }
        
        .tooltip .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 0.5rem;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.75rem;
        }
        
        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
        
        /* Water wave animation for the header */
        .header {
            position: relative;
            overflow: hidden;
        }
        
        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 15px;
            background: url('https://cdn.pixabay.com/photo/2017/03/09/18/12/wave-2129787_960_720.png');
            background-size: 400px 15px;
            animation: wave 8s linear infinite;
            opacity: 0.3;
        }
        
        .wave:nth-child(2) {
            bottom: 5px;
            animation: wave 10s linear infinite;
            opacity: 0.2;
        }
        
        @keyframes wave {
            0% { background-position-x: 0; }
            100% { background-position-x: 400px; }
        }
        
        /* History panel styling */
        .history-card {
            margin-top: 2rem;
        }
        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: var(--primary-color);
            color: #fff;
            border-radius: 8px 8px 0 0;
        }
        .history-body {
            padding: 1rem;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-top: none;
            border-radius: 0 0 8px 8px;
        }
        .history-toggle {
            margin-left: 1rem;
        }
        .history-list, .history-table {
            display: none;
            width: 100%;
        }
        .history-list.active, .history-table.active {
            display: block;
        }
        .history-list-item {
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="wave"></div>
        <div class="wave"></div>
        <h1>Proyecto de simulación de flujo en presas</h1>
        <p>Ingeniería Hidroeléctrica</p>
    </header>
    
    <main class="container">
        <div class="card" id="calculator-card">
            <div class="card-header">
                <h2><i class="fas fa-calculator"></i> Calculadora de Flujo de Agua</h2>
            </div>
            <div class="card-body">
                <div id="form-container">
                    <form id="flow-form" method="post">
                        <div class="form-group">
                            <label for="gateWidth">Ancho de la Compuerta (m):</label>
                            <input type="number" id="gateWidth" name="gateWidth" step="0.01" min="0.01" class="form-control" required>
                            <div class="error-message" id="gateWidth-error">Por favor ingrese un valor positivo.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="waterHeight">Altura del Agua (m):</label>
                            <input type="number" id="waterHeight" name="waterHeight" step="0.01" min="0.01" class="form-control" required>
                            <div class="error-message" id="waterHeight-error">Por favor ingrese un valor positivo.</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="dischargeCd">
                                Coeficiente de Descarga (Cd):
                                <span class="tooltip">
                                    <i class="fas fa-info-circle"></i>
                                    <span class="tooltip-text">El coeficiente de descarga típicamente varía entre 0.6 y 0.8 para compuertas estándar.</span>
                                </span>
                            </label>
                            <input type="number" id="dischargeCd" name="dischargeCd" step="0.01" min="0.1" max="1" value="0.62" class="form-control" required>
                            <div class="error-message" id="dischargeCd-error">Por favor ingrese un valor entre 0.1 y 1.</div>
                        </div>
                        
                        <div class="form-group checkbox-container">
                            <input type="checkbox" id="useDerivative" name="useDerivative">
                            <label for="useDerivative">Calcular derivada numérica</label>
                        </div>
                        
                        <div class="derivative-fields" id="derivative-fields">
                            <div class="form-group">
                                <label for="diffIncrement">
                                    Incremento Diferencial (Δ):
                                    <span class="tooltip">
                                        <i class="fas fa-info-circle"></i>
                                        <span class="tooltip-text">Valor de incremento utilizado para calcular la derivada numérica.</span>
                                    </span>
                                </label>
                                <input type="number" id="diffIncrement" name="diffIncrement" step="0.001" min="0.001" value="0.01" class="form-control">
                                <div class="error-message" id="diffIncrement-error">Por favor ingrese un valor positivo.</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="precision">Precisión (decimales):</label>
                                <input type="number" id="precision" name="precision" min="1" max="10" value="2" class="form-control">
                                <div class="error-message" id="precision-error">Por favor ingrese un valor entre 1 y 10.</div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" id="reset-btn" class="btn btn-outline">
                                <i class="fas fa-sync-alt"></i> Restablecer
                            </button>
                            <button type="submit" id="calculate-btn" class="btn btn-primary">
                                <i class="fas fa-calculator"></i> Calcular Flujo
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="loading" id="loading-indicator">
                    <div class="spinner"></div>
                    <p>Calculando...</p>
                </div>
                
                <div class="result-container" id="result-container">
                    <h3>Resultados del Cálculo</h3>
                    
                    <div class="result-value" id="flow-result">
                        El flujo calculado es: <span id="flow-value">0.00</span> metros cúbicos por segundo
                    </div>
                    
                    <div class="result-value derivative-result hidden" id="derivative-result">
                        La derivada del flujo es: <span id="derivative-value">0.00</span> unidades por unidad
                    </div>
                    
                    <div class="result-details">
                        <h4>Parámetros utilizados:</h4>
                        <ul id="parameters-list">
                            <!-- Parámetros del cálculo serán insertados aquí -->
                        </ul>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" id="back-btn" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Formulario
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-info-circle"></i> Acerca de esta Calculadora</h2>
            </div>
            <div class="card-body">
                <p>Esta herramienta permite simular el flujo de agua a través de una compuerta en una presa hidroeléctrica, 
                utilizando principios fundamentales de la mecánica de fluidos.</p>
                
                <p>La ecuación básica utilizada es:</p>
                <p style="font-weight: bold; text-align: center; margin: 1rem 0;">
                    Q = Cd × L × H × √(2g × H)
                </p>
                
                <p>Donde:</p>
                <ul style="margin-left: 1.5rem;">
                    <li>Q = Flujo de agua (m³/s)</li>
                    <li>Cd = Coeficiente de descarga</li>
                    <li>L = Ancho de la compuerta (m)</li>
                    <li>H = Altura del agua (m)</li>
                    <li>g = Aceleración de la gravedad (9.81 m/s²)</li>
                </ul>
            </div>
        </div>
        
        <!-- ADD: History panel below the calculator card -->
        <div class="card history-card" id="history-card">
          <div class="history-header">
            <h2><i class="fas fa-history"></i> Historial de Cálculos</h2>
            <div>
              <button type="button" id="clear-history-btn" class="btn btn-outline">
                <i class="fas fa-trash-alt"></i> Borrar Historial
              </button>
              <button type="button" id="export-csv-btn" class="btn btn-outline">
                <i class="fas fa-file-csv"></i> Exportar a CSV
              </button>
              <select id="history-view-toggle" class="form-control history-toggle">
                <option value="list">Vista Lista</option>
                <option value="table">Vista Tabla</option>
              </select>
            </div>
          </div>
          <div class="history-body">
            <ul class="history-list" id="history-list">
              <!-- lista dinámica de históricos -->
            </ul>
            <table class="history-table" id="history-table">
              <thead>
                <tr>
                  <th>Ancho</th><th>Altura</th><th>Cd</th>
                  <th>Flujo</th><th>Derivada</th><th>Fecha/Hora</th>
                </tr>
              </thead>
              <tbody>
                <!-- filas de históricos -->
              </tbody>
            </table>
          </div>
        </div>
    </main>
    
    <footer class="footer">
        <p>Proyecto de simulación de flujo en presas - Ingeniería © 2025</p>
        <p>Versión 1.0 | Desarrollado para aplicaciones educativas</p>
    </footer>

    <script id="app-script">
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const form = document.getElementById('flow-form');
            const formContainer = document.getElementById('form-container');
            const loadingIndicator = document.getElementById('loading-indicator');
            const resultContainer = document.getElementById('result-container');
            const backBtn = document.getElementById('back-btn');
            const resetBtn = document.getElementById('reset-btn');
            const useDerivative = document.getElementById('useDerivative');
            const derivativeFields = document.getElementById('derivative-fields');
            const derivativeResult = document.getElementById('derivative-result');
            const clearHistoryBtn = document.getElementById('clear-history-btn');
            const exportCsvBtn    = document.getElementById('export-csv-btn');
            const historyList     = document.getElementById('history-list');
            const historyTable    = document.getElementById('history-table');
            const historyToggle   = document.getElementById('history-view-toggle');

            // Load any existing history
            renderHistory();

            // Toggle view
            historyToggle.addEventListener('change', function() {
                const mode = this.value;
                historyList.classList.toggle('active', mode === 'list');
                historyTable.classList.toggle('active', mode === 'table');
            });

            // Clear history
            clearHistoryBtn.addEventListener('click', function() {
                localStorage.removeItem('flowHistory');
                renderHistory();
            });

            // Export to CSV
            exportCsvBtn.addEventListener('click', function() {
                const history = JSON.parse(localStorage.getItem('flowHistory') || '[]');
                if (!history.length) return alert('No hay datos de historial.');
                const header = ['GateWidth','WaterHeight','Cd','Flow','Derivative','Timestamp'];
                const rows = history.map(item => [
                  item.gateWidth, item.waterHeight, item.dischargeCd,
                  item.flowRate, item.derivative || '', item.timestamp
                ]);
                const csvContent = [header, ...rows].map(r => r.join(',')).join('\n');
                const blob = new Blob([csvContent], { type: 'text/csv' });
                const url  = URL.createObjectURL(blob);
                const a    = document.createElement('a');
                a.href     = url;
                a.download = 'flow_history.csv';
                a.click();
                URL.revokeObjectURL(url);
            });

            // After calculation completes, save to history
            function saveToHistory(entry) {
                const history = JSON.parse(localStorage.getItem('flowHistory') || '[]');
                history.unshift(entry);
                localStorage.setItem('flowHistory', JSON.stringify(history.slice(0, 50))); // max 50 entries
                renderHistory();
            }

            // Render history in both views
            function renderHistory() {
                const history = JSON.parse(localStorage.getItem('flowHistory') || '[]');
                // List view
                historyList.innerHTML = history.map(item => `
                  <li class="history-list-item">
                    <strong>${item.timestamp}</strong><br>
                    Q=${item.flowRate} m³/s
                    ${item.derivative ? `, Q'=${item.derivative}` : ''}
                    <br>
                    [L=${item.gateWidth}, H=${item.waterHeight}, Cd=${item.dischargeCd}]
                  </li>
                `).join('') || '<li>No hay registros.</li>';
                // Table view
                historyTable.querySelector('tbody').innerHTML = history.map(item => `
                  <tr>
                    <td>${item.gateWidth}</td>
                    <td>${item.waterHeight}</td>
                    <td>${item.dischargeCd}</td>
                    <td>${item.flowRate}</td>
                    <td>${item.derivative || '-'}</td>
                    <td>${item.timestamp}</td>
                  </tr>
                `).join('');
            }

            // Event Listeners
            useDerivative.addEventListener('change', function() {
                derivativeFields.style.display = this.checked ? 'block' : 'none';
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate form
                if (!validateForm()) return;
                
                // Show loading indicator
                formContainer.style.display = 'none';
                loadingIndicator.style.display = 'block';
                
                // Simulate API call/processing
                setTimeout(function() {
                    calculateFlow();
                }, 1000);
            });

            backBtn.addEventListener('click', function() {
                resultContainer.style.display = 'none';
                formContainer.style.display = 'block';
            });

            resetBtn.addEventListener('click', function() {
                form.reset();
                derivativeFields.style.display = 'none';
                clearErrors();
            });

            // Form Validation
            function validateForm() {
                let isValid = true;
                clearErrors();
                
                // Validate Gate Width
                const gateWidth = parseFloat(document.getElementById('gateWidth').value);
                if (isNaN(gateWidth) || gateWidth <= 0) {
                    showError('gateWidth', 'Por favor ingrese un valor positivo.');
                    isValid = false;
                }
                
                // Validate Water Height
                const waterHeight = parseFloat(document.getElementById('waterHeight').value);
                if (isNaN(waterHeight) || waterHeight <= 0) {
                    showError('waterHeight', 'Por favor ingrese un valor positivo.');
                    isValid = false;
                }
                
                // Validate Discharge Coefficient
                const dischargeCd = parseFloat(document.getElementById('dischargeCd').value);
                if (isNaN(dischargeCd) || dischargeCd <= 0 || dischargeCd > 1) {
                    showError('dischargeCd', 'Por favor ingrese un valor entre 0.1 y 1.');
                    isValid = false;
                }
                
                // Validate derivative fields if checked
                if (useDerivative.checked) {
                    const diffIncrement = parseFloat(document.getElementById('diffIncrement').value);
                    if (isNaN(diffIncrement) || diffIncrement <= 0) {
                        showError('diffIncrement', 'Por favor ingrese un valor positivo.');
                        isValid = false;
                    }
                    
                    const precision = parseInt(document.getElementById('precision').value);
                    if (isNaN(precision) || precision < 1 || precision > 10) {
                        showError('precision', 'Por favor ingrese un valor entre 1 y 10.');
                        isValid = false;
                    }
                }
                
                return isValid;
            }

            function showError(fieldId, message) {
                const errorElement = document.getElementById(`${fieldId}-error`);
                errorElement.textContent = message;
                errorElement.style.display = 'block';
                document.getElementById(fieldId).classList.add('error');
            }

            function clearErrors() {
                const errorElements = document.querySelectorAll('.error-message');
                errorElements.forEach(el => el.style.display = 'none');
                
                const formControls = document.querySelectorAll('.form-control');
                formControls.forEach(el => el.classList.remove('error'));
            }

            // Flow Calculation
            function calculateFlow() {
                const gateWidth = parseFloat(document.getElementById('gateWidth').value);
                const waterHeight = parseFloat(document.getElementById('waterHeight').value);
                const dischargeCd = parseFloat(document.getElementById('dischargeCd').value);
                const g = 9.81; // gravitational acceleration constant
                
                // Calculate flow rate: Q = Cd * L * H * sqrt(2g * H)
                const flowRate = dischargeCd * gateWidth * waterHeight * Math.sqrt(2 * g * waterHeight);
                
                // Check if derivative calculation is requested
                let derivativeValue = null;
                if (useDerivative.checked) {
                    const diffIncrement = parseFloat(document.getElementById('diffIncrement').value);
                    const precision = parseInt(document.getElementById('precision').value);
                    
                    // Calculate derivative with respect to water height
                    // Using central difference approximation: f'(x) ≈ [f(x + h) - f(x - h)] / (2h)
                    const flowRatePlus = dischargeCd * gateWidth * (waterHeight + diffIncrement) * 
                                        Math.sqrt(2 * g * (waterHeight + diffIncrement));
                    const flowRateMinus = dischargeCd * gateWidth * (waterHeight - diffIncrement) * 
                                        Math.sqrt(2 * g * (waterHeight - diffIncrement));
                    
                    derivativeValue = (flowRatePlus - flowRateMinus) / (2 * diffIncrement);
                    derivativeValue = derivativeValue.toFixed(precision);
                }
                
                // Display results
                document.getElementById('flow-value').textContent = flowRate.toFixed(2);
                
                // Build parameters list
                const parametersList = document.getElementById('parameters-list');
                parametersList.innerHTML = `
                    <li>Ancho de la compuerta: ${gateWidth} metros</li>
                    <li>Altura del agua: ${waterHeight} metros</li>
                    <li>Coeficiente de descarga (Cd): ${dischargeCd}</li>
                    <li>Gravedad: ${g} m/s²</li>
                `;
                
                // Show derivative result if calculated
                if (derivativeValue !== null) {
                    document.getElementById('derivative-value').textContent = derivativeValue;
                    derivativeResult.classList.remove('hidden');
                    
                    // Add derivative parameters to the list
                    const diffIncrement = parseFloat(document.getElementById('diffIncrement').value);
                    const precision = parseInt(document.getElementById('precision').value);
                    
                    parametersList.innerHTML += `
                        <li>Incremento diferencial (Δ): ${diffIncrement}</li>
                        <li>Precisión: ${precision} decimales</li>
                    `;
                } else {
                    derivativeResult.classList.add('hidden');
                }
                
                // Hide loading indicator and show results
                loadingIndicator.style.display = 'none';
                resultContainer.style.display = 'block';
                
                // After calculation completes, save to history
                const timestamp = new Date().toLocaleString();
                const entry = {
                  gateWidth, waterHeight, dischargeCd,
                  flowRate: flowRate.toFixed(2),
                  derivative: derivativeValue || null,
                  timestamp
                };
                saveToHistory(entry);
            }
            
        });
    </script>
</body>
</html>
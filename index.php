<?php
// Configuración del evento (datos editables)
$evento = [
    'nombre' => 'Santiaguito',
    'ocasion' => 'Mi primer añito',
    'fecha' => '31/08/25',
    'hora' => '16:00',
    'lugar' => 'Salón de eventos Sakura',
    'direccion' => 'Av. Virgen de Cotoca #422',
    'tematica' => 'Príncipe de Dios',
    'whatsapp' => '+59160733692' // Reemplaza con tu número
];

// Procesamiento del formulario RSVP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars($_POST['nombre'] ?? '');
    $asistentes = intval($_POST['asistentes'] ?? 0);
    $mensaje = htmlspecialchars($_POST['mensaje'] ?? '');
    
    // Validación básica
    if (!empty($nombre) && $asistentes > 0) {
        // Preparar mensaje para WhatsApp
        $textoWhatsApp = rawurlencode(
            "¡Confirmo asistencia al cumple de {$evento['nombre']}!\n" .
            "Nombre: $nombre\n" .
            "Asistentes: $asistentes\n" .
            "Mensaje: $mensaje"
        );
        
        // Redirigir a WhatsApp con los datos
        header("Location: https://wa.me/{$evento['whatsapp']}?text=$textoWhatsApp");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Celebra el primer añito de <?= $evento['nombre'] ?>!</title>
    <style>
        /* Reset y estilos base */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
         --color-primario: #3498db;  /* Azul vibrante */
    --color-secundario: #d4af37; /* Dorado clásico */  
            --color-texto: #333;
            --color-fondo: #f9f9f9;
            --sombra: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--color-texto);
            background: var(--color-fondo);
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(142, 68, 173, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(241, 196, 15, 0.1) 0%, transparent 20%);
            background-attachment: fixed;
        }
        
        /* Animaciones */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes shine {
            0% { background-position: -100%; }
            100% { background-position: 100%; }
        }
        
        /* Estructura principal */
        .contenedor {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }
        
        .invitacion {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: var(--sombra);
            position: relative;
            overflow: hidden;
            margin: 20px 0;
            animation: pulse 3s infinite;
        }
        
        .invitacion::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--color-primario), var(--color-secundario));
        }
        
        /* Encabezado */
        .encabezado {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }
        
        .titulo {
            font-size: clamp(2rem, 5vw, 3rem);
            color: var(--color-primario);
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }
        
        .titulo::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 3px;
            background: linear-gradient(90deg, var(--color-primario), var(--color-secundario));
        }
        
        .subtitulo {
            font-size: clamp(1.2rem, 3vw, 1.5rem);
            color: var(--color-secundario);
            font-weight: bold;
        }
        
        /* Detalles del evento */
        .detalles {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .detalle-item {
            background: rgba(142, 68, 173, 0.1);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
        }
        
        .detalle-item:hover {
            transform: translateY(-5px);
        }
        
        .detalle-item i {
            font-size: 2rem;
            color: var(--color-primario);
            margin-bottom: 10px;
            display: block;
        }
        
        .detalle-titulo {
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--color-primario);
        }
        
        /* Contador regresivo */
        .contador {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        
        .contador-item {
            background: var(--color-primario);
            color: white;
            padding: 15px;
            border-radius: 10px;
            min-width: 80px;
            text-align: center;
            box-shadow: var(--sombra);
        }
        
        .contador-numero {
            font-size: 2rem;
            font-weight: bold;
        }
        
        .contador-texto {
            font-size: 0.8rem;
            text-transform: uppercase;
        }
        
        /* Formulario RSVP */
        .formulario {
            background: rgba(241, 196, 15, 0.1);
            padding: 25px;
            border-radius: 10px;
            margin-top: 30px;
        }
        
        .form-titulo {
            text-align: center;
            margin-bottom: 20px;
            color: var(--color-primario);
        }
        
        .form-grupo {
            margin-bottom: 15px;
        }
        
        .form-grupo label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-grupo input, 
        .form-grupo textarea,
        .form-grupo select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
        }
        
        .form-grupo textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .boton {
            display: inline-block;
            background: linear-gradient(45deg, var(--color-primario), var(--color-secundario));
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .boton:hover {
            transform: translateY(-3px);
            box-shadow:  0 2px 10px rgba(212, 175, 55, 0.3);
        }
        
        .boton::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s;
        }
        
        .boton:hover::after {
            transform: translateX(100%);
        }
        
        /* Elementos decorativos */
        .decoracion {
            position: absolute;
            z-index: -1;
        }
        
        .corona {
            top: 20px;
            right: 20px;
            font-size: 3rem;
            color: var(--color-secundario);
            animation: float 3s ease-in-out infinite;
        }
        
        .estrella {
            bottom: 20px;
            left: 20px;
            font-size: 2rem;
            color: var(--color-primario);
            animation: float 4s ease-in-out infinite 1s;
        }
        
        /* Responsive */
        @media (max-width: 600px) {
            .detalles {
                grid-template-columns: 1fr;
            }
            
            .contador-item {
                min-width: 60px;
                padding: 10px;
            }
            
            .contador-numero {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <!-- Elementos decorativos -->
        <div class="decoracion corona">👑</div>
        <div class="decoracion estrella">⭐</div>
        
        <div class="invitacion">
            <div class="encabezado">
                <h1 class="titulo">¡Estás invitado!</h1>
                <p class="subtitulo">A celebrar <?= $evento['ocasion'] ?></p>
            </div>
            
            <div class="detalles">
                <div class="detalle-item">
                    <i>🎂</i>
                    <div class="detalle-titulo">Cumpleañero</div>
                    <div><?= $evento['nombre'] ?></div>
                </div>
                
                <div class="detalle-item">
                    <i>📅</i>
                    <div class="detalle-titulo">Fecha</div>
                    <div><?= $evento['fecha'] ?></div>
                </div>
                
                <div class="detalle-item">
                    <i>⏰</i>
                    <div class="detalle-titulo">Hora</div>
                    <div><?= $evento['hora'] ?></div>
                </div>
                
                <div class="detalle-item">
                    <i>📍</i>
                    <div class="detalle-titulo">Lugar</div>
                    <div><?= $evento['lugar'] ?></div>
                    <div><?= $evento['direccion'] ?></div>
                </div>
            </div>
            
            <div class="contador" id="contador">
                <div class="contador-item">
                    <div class="contador-numero" id="dias">00</div>
                    <div class="contador-texto">Días</div>
                </div>
                <div class="contador-item">
                    <div class="contador-numero" id="horas">00</div>
                    <div class="contador-texto">Horas</div>
                </div>
                <div class="contador-item">
                    <div class="contador-numero" id="minutos">00</div>
                    <div class="contador-texto">Minutos</div>
                </div>
                <div class="contador-item">
                    <div class="contador-numero" id="segundos">00</div>
                    <div class="contador-texto">Segundos</div>
                </div>
            </div>
            
            <div class="formulario">
                <h3 class="form-titulo">Confirma tu asistencia</h3>
                <form method="POST" id="rsvpForm">
                    <div class="form-grupo">
                        <label for="nombre">Tu nombre</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    
                    <div class="form-grupo">
                        <label for="asistentes">Número de asistentes</label>
                        <select id="asistentes" name="asistentes" required>
                            <option value="" disabled selected>Selecciona</option>
                            <option value="1">1 persona</option>
                            <option value="2">2 personas</option>
                            <option value="3">3 personas</option>
                            <option value="4">4 personas</option>
                            <option value="5">5 personas</option>
                            <option value="6">6+ personas</option>
                        </select>
                    </div>
                    
                    <div class="form-grupo">
                        <label for="mensaje">Mensaje especial (opcional)</label>
                        <textarea id="mensaje" name="mensaje" placeholder="Escribe un mensaje para el cumpleañero..."></textarea>
                    </div>
                    
                    <button type="submit" class="boton">Confirmar por WhatsApp</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Contador regresivo
        function actualizarContador() {
            const fechaEvento = new Date('<?= $evento['fecha'] ?> <?= $evento['hora'] ?>').getTime();
            const ahora = new Date().getTime();
            const diferencia = fechaEvento - ahora;
            
            if (diferencia > 0) {
                const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
                const horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
                const segundos = Math.floor((diferencia % (1000 * 60)) / 1000);
                
                document.getElementById('dias').textContent = dias.toString().padStart(2, '0');
                document.getElementById('horas').textContent = horas.toString().padStart(2, '0');
                document.getElementById('minutos').textContent = minutos.toString().padStart(2, '0');
                document.getElementById('segundos').textContent = segundos.toString().padStart(2, '0');
            } else {
                document.getElementById('contador').innerHTML = '<div class="contador-item" style="grid-column: 1/-1">¡El evento ha comenzado!</div>';
                clearInterval(intervalo);
            }
        }
        
        // Iniciar contador
        actualizarContador();
        const intervalo = setInterval(actualizarContador, 1000);
        
        // Efectos interactivos
        document.querySelectorAll('.detalle-item').forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.querySelector('i').style.transform = 'scale(1.2)';
            });
            
            item.addEventListener('mouseleave', () => {
                item.querySelector('i').style.transform = 'scale(1)';
            });
        });
        
        // Validación del formulario
        document.getElementById('rsvpForm').addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value.trim();
            const asistentes = document.getElementById('asistentes').value;
            
            if (!nombre || !asistentes) {
                e.preventDefault();
                alert('Por favor completa los campos requeridos');
            }
        });
    </script>
</body>
</html>
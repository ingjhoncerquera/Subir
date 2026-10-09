<?php

require_once __DIR__ . '/../../models/EmpresaModel.php';
require_once __DIR__ . '/../../models/SedeModel.php';

$empresaModel = new EmpresaModel();
$sedeModel = new SedeModel();

$empresa = $empresaModel->obtener();

$id_sede = intval($pedido['id_sede'] ?? 0);

$sede = null;

if ($id_sede > 0) {
    $sede = $sedeModel->obtener($id_sede);
}


/*
|--------------------------------------------------------------------------
| DATOS DE EMPRESA
|--------------------------------------------------------------------------
*/

$nombreEmpresa = $empresa['nombre']
    ?? 'Restaurante';

$nitEmpresa = $empresa['nit']
    ?? '';

$propietarioEmpresa = $empresa['propietario']
    ?? '';

$telefonoEmpresa = $empresa['telefono']
    ?? '';

$celularEmpresa = $empresa['celular']
    ?? '';

$correoEmpresa = $empresa['correo']
    ?? '';

$direccionEmpresa = $empresa['direccion']
    ?? '';

$ciudadEmpresa = $empresa['ciudad']
    ?? '';


/*
|--------------------------------------------------------------------------
| DATOS DE SEDE
|--------------------------------------------------------------------------
*/

$nombreSede = $sede['nombre']
    ?? 'Sede principal';

$direccionSede = $sede['direccion']
    ?? $direccionEmpresa;

$ciudadSede = $sede['ciudad']
    ?? $ciudadEmpresa;

$telefonoSede = $sede['telefono']
    ?? $telefonoEmpresa;

$celularSede = $sede['celular']
    ?? $celularEmpresa;

$correoSede = $sede['correo']
    ?? $correoEmpresa;


/*
|--------------------------------------------------------------------------
| DATOS DEL CLIENTE
|--------------------------------------------------------------------------
*/

$nombreCliente =
    $pedido['nombre_cliente']
    ?? $pedido['nombre']
    ?? 'Cliente general';

$emailCliente =
    $pedido['email_cliente']
    ?? $pedido['email']
    ?? 'N/A';

$telefonoCliente =
    $pedido['telefono_cliente']
    ?? $pedido['telefono']
    ?? 'N/A';


/*
|--------------------------------------------------------------------------
| TOTAL DE LA FACTURA
|--------------------------------------------------------------------------
*/

$totalFactura = floatval(
    $pedido['total'] ?? 0
);

$descuentoFactura = floatval(
    $pedido['descuento'] ?? 0
);

$porcentajeImpoconsumo = 0.08;


/*
|--------------------------------------------------------------------------
| CALCULAR SUBTOTAL BRUTO
|--------------------------------------------------------------------------
*/

$subtotalBrutoFactura = 0;

foreach ($detalle as $item) {

    $subtotalBrutoFactura += floatval(
        $item['subtotal'] ?? 0
    );
}


/*
|--------------------------------------------------------------------------
| SEPARAR SUBTOTAL NETO E IMPOCONSUMO
|--------------------------------------------------------------------------
*/

$subtotalFactura = round(
    $subtotalBrutoFactura /
    (1 + $porcentajeImpoconsumo)
);

$impoconsumo = round(
    $subtotalBrutoFactura -
    $subtotalFactura
);


/*
|--------------------------------------------------------------------------
| NÚMERO DE FACTURA
|--------------------------------------------------------------------------
*/

$numeroFactura = str_pad(
    $pedido['id_pedido'] ?? 0,
    6,
    '0',
    STR_PAD_LEFT
);


/*
|--------------------------------------------------------------------------
| ORIGEN DE LA FACTURA
|--------------------------------------------------------------------------
|
| Puede venir desde:
|
| origen=mesa
| origen=pedidos
|
| Si no viene ninguno, por seguridad
| regresamos a Gestión de Pedidos.
|
*/

$origen = strtolower(
    trim(
        $_GET['origen'] ?? 'pedidos'
    )
);


/*
|--------------------------------------------------------------------------
| URL DE REGRESO
|--------------------------------------------------------------------------
*/

if ($origen === 'mesa') {

    /*
     * IMPORTANTE:
     *
     * NO utilizamos:
     *
     * action=mesas
     *
     * porque esa acción no existe.
     *
     * La acción que estamos usando
     * para regresar es index.
     */

    $urlVolver =
        'index.php?controller=mesa&action=index';

    $textoVolver =
        '← Volver a las mesas';

} else {

    $urlVolver =
        'index.php?controller=pedido&action=index';

    $textoVolver =
        '← Volver a pedidos';

}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Recibo #<?= htmlspecialchars($numeroFactura) ?>
    </title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family:
                'Courier New',
                monospace;

            font-size: 11px;

            background: #f0f0f0;

            display: flex;

            justify-content: center;

            padding: 20px;
        }


        .factura {

            background: white;

            width: 80mm;

            padding: 10px;

            box-shadow:
                0 2px 10px
                rgba(0,0,0,0.15);
        }


        .centro {

            text-align: center;
        }


        .restaurante-nombre {

            font-size: 16px;

            font-weight: bold;

            text-transform: uppercase;

            margin-bottom: 3px;
        }


        .empresa-dato {

            font-size: 10px;

            margin: 2px 0;

            line-height: 1.3;
        }


        .sede {

            margin-top: 7px;

            padding-top: 6px;

            border-top:
                1px dashed #333;

            border-bottom:
                1px dashed #333;

            padding-bottom: 6px;
        }


        .sede-titulo {

            font-size: 13px;

            font-weight: bold;

            text-transform: uppercase;

            margin-bottom: 3px;
        }


        .sede-dato {

            font-size: 10px;

            margin: 2px 0;
        }


        .linea {

            border-top:
                1px dashed #333;

            margin: 8px 0;
        }


        .linea-doble {

            border-top:
                2px solid #333;

            margin: 8px 0;
        }


        .dato {

            display: flex;

            justify-content:
                space-between;

            gap: 8px;

            margin: 3px 0;
        }


        .dato-label {

            color: #555;
        }


        table {

            width: 100%;

            border-collapse:
                collapse;

            margin: 5px 0;
        }


        table th {

            font-size: 10px;

            border-bottom:
                1px dashed #333;

            padding: 3px 0;

            text-align: left;
        }


        table th:last-child,
        table td:last-child {

            text-align: right;
        }


        table td {

            padding: 4px 0;

            font-size: 10px;

            vertical-align: top;
        }


        .producto-nombre {

            font-weight: bold;

            line-height: 1.2;
        }


        .producto-detalle {

            color: #555;

            font-size: 9px;

            margin-top: 2px;
        }


        .total-row {

            display: flex;

            justify-content:
                space-between;

            padding: 4px 0;
        }


        .total-final {

            font-size: 15px;

            font-weight: bold;
        }


        .impuesto {

            font-size: 11px;

            color: #555;
        }


        .descuento {

            font-size: 11px;

            color: #dc2626;

            font-weight: 600;
        }


        .mensaje-final {

            text-align: center;

            font-size: 11px;

            color: #555;

            margin-top: 5px;

            line-height: 1.4;
        }


        .btn-imprimir {

            display: block;

            width: 100%;

            padding: 10px;

            background: #198754;

            color: white;

            border: none;

            border-radius: 6px;

            font-size: 14px;

            cursor: pointer;

            margin-top: 15px;
        }


        .btn-volver {

            display: block;

            width: 100%;

            padding: 8px;

            background: white;

            color: #333;

            border: 1px solid #ccc;

            border-radius: 6px;

            font-size: 13px;

            cursor: pointer;

            margin-top: 8px;

            text-align: center;

            text-decoration: none;
        }


        .btn-volver:hover {

            background: #f5f5f5;

            color: #000;
        }

@page {
    size: 80mm auto;
    margin: 0;
}


@media print {

    body {
        background: white;
        padding: 0;
    }

    .factura {
        box-shadow: none;
        width: 100%;
    }

    .btn-imprimir,
    .btn-volver,
    .no-print {
        display: none !important;
    }

}

        @media print {

            body {

                background: white;

                padding: 0;
            }


            .factura {

                box-shadow: none;

                width: 100%;
            }


            .btn-imprimir,
            .btn-volver,
            .no-print {

                display: none !important;
            }

        }

    </style>

</head>


<body>


<div class="factura">


    <!-- ===================================================== -->
    <!-- EMPRESA -->
    <!-- ===================================================== -->

    <div class="centro">

        <div class="restaurante-nombre">

            <?= htmlspecialchars(
                $nombreEmpresa
            ) ?>

        </div>


        <?php if ($nitEmpresa !== ''): ?>

            <div class="empresa-dato">

                NIT:
                <?= htmlspecialchars(
                    $nitEmpresa
                ) ?>

            </div>

        <?php endif; ?>


        <?php if ($propietarioEmpresa !== ''): ?>

            <div class="empresa-dato">

                Propietario:
                <?= htmlspecialchars(
                    $propietarioEmpresa
                ) ?>

            </div>

        <?php endif; ?>


        <!-- ================================================= -->
        <!-- SEDE -->
        <!-- ================================================= -->

        <div class="sede">

            <div class="sede-titulo">

                <?= htmlspecialchars(
                    $nombreSede
                ) ?>

            </div>


            <?php if ($direccionSede !== ''): ?>

                <div class="sede-dato">

                    <?= htmlspecialchars(
                        $direccionSede
                    ) ?>

                </div>

            <?php endif; ?>


            <?php if ($ciudadSede !== ''): ?>

                <div class="sede-dato">

                    <?= htmlspecialchars(
                        $ciudadSede
                    ) ?>

                </div>

            <?php endif; ?>


            <?php if ($telefonoSede !== ''): ?>

                <div class="sede-dato">

                    Tel:
                    <?= htmlspecialchars(
                        $telefonoSede
                    ) ?>

                </div>

            <?php endif; ?>


            <?php if ($celularSede !== ''): ?>

                <div class="sede-dato">

                    Cel:
                    <?= htmlspecialchars(
                        $celularSede
                    ) ?>

                </div>

            <?php endif; ?>


            <?php if ($correoSede !== ''): ?>

                <div class="sede-dato">

                    <?= htmlspecialchars(
                        $correoSede
                    ) ?>

                </div>

            <?php endif; ?>

        </div>

    </div>


    <div class="linea-doble"></div>


    <!-- ===================================================== -->
    <!-- DATOS DEL PEDIDO -->
    <!-- ===================================================== -->

    <div class="dato">

        <span class="dato-label">
            Recibo #:
        </span>

        <span>

            <strong>
                <?= htmlspecialchars(
                    $numeroFactura
                ) ?>
            </strong>

        </span>

    </div>


    <div class="dato">

        <span class="dato-label">
            Pedido #:
        </span>

        <span>

            <?= htmlspecialchars(
                $pedido['numero_pedido']
                ?? $pedido['id_pedido']
            ) ?>

        </span>

    </div>


    <div class="dato">

        <span class="dato-label">
            Sede:
        </span>

        <span>

            <?= htmlspecialchars(
                $nombreSede
            ) ?>

        </span>

    </div>


    <!-- ===================================================== -->
    <!-- MESA / DOMICILIO -->
    <!-- ===================================================== -->

    <?php if (
        ($pedido['tipo_entrega'] ?? '') === 'domicilio'
    ): ?>

        <div class="dato">

            <span class="dato-label">
                Entrega:
            </span>

            <span>

                <strong>
                    🛵 DOMICILIO
                </strong>

            </span>

        </div>


        <?php if (!empty($pedido['direccion'])): ?>

            <div class="dato">

                <span class="dato-label">
                    Dirección:
                </span>

                <span>

                    <?= htmlspecialchars(
                        $pedido['direccion']
                    ) ?>

                </span>

            </div>

        <?php endif; ?>


    <?php else: ?>

        <div class="dato">

            <span class="dato-label">
                Mesa:
            </span>

            <span>

                <?= htmlspecialchars(
                    $pedido['numero_mesa']
                    ?? 'N/A'
                ) ?>

            </span>

        </div>

    <?php endif; ?>


    <div class="dato">

        <span class="dato-label">
            Fecha:
        </span>

        <span>

            <?= date(
                'd/m/Y',
                strtotime(
                    $pedido['creado_en']
                )
            ) ?>

        </span>

    </div>


    <div class="dato">

        <span class="dato-label">
            Hora:
        </span>

        <span>

            <?= date(
                'h:i A',
                strtotime(
                    $pedido['creado_en']
                )
            ) ?>

        </span>

    </div>


    <div class="linea"></div>


    <!-- ===================================================== -->
    <!-- CLIENTE -->
    <!-- ===================================================== -->

    <div class="dato">

    <span class="dato-label">
        Cliente:
    </span>

    <span>

        <?= htmlspecialchars(
            $nombreCliente
        ) ?>

    </span>

</div>


<?php if (
    $telefonoCliente !== 'N/A' &&
    trim($telefonoCliente) !== ''
): ?>

    <div class="dato">

        <span class="dato-label">
            Teléfono:
        </span>

        <span>

            <?= htmlspecialchars(
                $telefonoCliente
            ) ?>

        </span>

    </div>

<?php endif; ?>


    <div class="linea"></div>


    <!-- ===================================================== -->
    <!-- PRODUCTOS -->
    <!-- ===================================================== -->

    <table>

        <thead>

            <tr>

                <th>
                    Producto
                </th>

                <th
                    style="text-align:center;"
                >
                    Cant.
                </th>

                <th>
                    Total
                </th>

            </tr>

        </thead>


        <tbody>

        <?php foreach ($detalle as $item): ?>

            <?php

            $valorBruto = floatval(
                $item['subtotal'] ?? 0
            );


            $valorNeto =
                $valorBruto /
                (1 + $porcentajeImpoconsumo);


            $impuestoLinea =
                $valorBruto -
                $valorNeto;


            $precioUnitario =
                floatval(
                    $item['precio_sede'] ?? 0
                );


            $precioUnitarioNeto =
                $precioUnitario /
                (1 + $porcentajeImpoconsumo);

            ?>

            <tr>

                <td>

                    <div class="producto-nombre">

                        <?= htmlspecialchars(
                            $item['nombre']
                        ) ?>

                    </div>


                    <div class="producto-detalle">

                        $<?= number_format(
                            $precioUnitario,
                            0,
                            ',',
                            '.'
                        ) ?>

                        c/u

                    </div>

                </td>


                <td
                    style="text-align:center;"
                >

                    <?= intval(
                        $item['cantidad']
                    ) ?>

                </td>


                <td>

                    $<?= number_format(
                        round($valorBruto),
                        0,
                        ',',
                        '.'
                    ) ?>

                </td>

            </tr>


        <?php endforeach; ?>

        </tbody>

    </table>


    <div class="linea"></div>


    <!-- ===================================================== -->
    <!-- TOTALES -->
    <!-- ===================================================== -->

    <div class="total-row">

        <span class="dato-label">

            Subtotal:

        </span>


        <span>

            $<?= number_format(
                $subtotalFactura,
                0,
                ',',
                '.'
            ) ?>

        </span>

    </div>


    <div class="total-row impuesto">

        <span>

            Impoconsumo incluido (8%):

        </span>


        <span>

            $<?= number_format(
                $impoconsumo,
                0,
                ',',
                '.'
            ) ?>

        </span>

    </div>

<?php

$valorDomicilioFactura = floatval(
    $pedido['valor_domicilio'] ?? 0
);

$esDomicilio =
    ($pedido['tipo_entrega'] ?? '') === 'domicilio';

?>

<?php if ($esDomicilio && $valorDomicilioFactura > 0): ?>

    <div class="total-row impuesto">

        <span>

            🛵 Domicilio:

        </span>


        <span>

            $<?= number_format(
                $valorDomicilioFactura,
                0,
                ',',
                '.'
            ) ?>

        </span>

    </div>

<?php endif; ?>

    <?php if ($descuentoFactura > 0): ?>

        <div class="total-row descuento">

            <span>

                Descuento empleado:

            </span>


            <span>

                -$<?= number_format(
                    $descuentoFactura,
                    0,
                    ',',
                    '.'
                ) ?>

            </span>

        </div>

    <?php endif; ?>


    <div class="linea-doble"></div>


    <div class="total-row total-final">

        <span>

            TOTAL A PAGAR:

        </span>


        <span>

            $<?= number_format(
                $totalFactura,
                0,
                ',',
                '.'
            ) ?>

        </span>

    </div>


    <!-- ===================================================== -->
    <!-- FORMA DE PAGO -->
    <!-- ===================================================== -->

    <?php if (
        !empty($pedido['tipo_pago'])
    ): ?>

        <div class="dato">

            <span class="dato-label">

                Forma de pago:

            </span>


            <span>

                <?= htmlspecialchars(
                    $pedido['tipo_pago']
                ) ?>

            </span>

        </div>

    <?php endif; ?>


    <!-- ===================================================== -->
    <!-- ESTADO -->
    <!-- ===================================================== -->

    <div class="dato">

        <span class="dato-label">

            Estado:

        </span>


        <span>

            <strong>
                PAGADO ✅
            </strong>

        </span>

    </div>


    <div class="linea"></div>


    <!-- ===================================================== -->
    <!-- MENSAJE -->
    <!-- ===================================================== -->

    <div class="mensaje-final">

        <p>
            ¡Gracias por su visita!
        </p>

        <p>
            Esperamos verle pronto 😊
        </p>


        <?php if (
            $correoEmpresa !== ''
        ): ?>

            <p style="margin-top:5px;">

                <?= htmlspecialchars(
                    $correoEmpresa
                ) ?>

            </p>

        <?php endif; ?>

    </div>


    <!-- ===================================================== -->
    <!-- BOTÓN IMPRIMIR -->
    <!-- ===================================================== -->

    <button
        class="btn-imprimir"
        onclick="window.print()"
    >

        🖨️ Imprimir Recibo

    </button>


    <!-- ===================================================== -->
    <!-- BOTÓN VOLVER -->
    <!-- ===================================================== -->

    <a
        href="<?= htmlspecialchars($urlVolver) ?>"
        class="btn-volver"
    >

        <?= htmlspecialchars($textoVolver) ?>

    </a>


</div>


</body>

</html>
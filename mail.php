<?php
if(isset($_POST['email'])){

    $valid = true;
    $labels = '';

    // Formulario de contacto
    $fields = [
        'name' => 'Nombre',
        'email' => 'Email',
        'company' => 'Empresa',
        'message' => 'Mensaje',
    ];

    $titulo = 'TAHO - Formulario de contacto';
    $para='info@taho.com.ar';

    // Validacion
    foreach ($fields as $field => $label) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) == '') {
            $valid = false;
            $labels .= $label.', ';
        }
    }
    if ($valid) {
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $mensaje = '<h3>'.$titulo.'</h3><hr>';

        foreach ($fields as $field => $label) {
            $mensaje .= '<strong>'.$label.':</strong> '.$_POST[$field].'<br><br>';
        }

        // Envio de mail
        if (mail($para, $titulo, $mensaje, $cabeceras)) {
            $response_array['status'] = 'success';
            $response_array['message'] = 'Formulario enviado con éxito. Nos comunicaremos con usted a la brevedad.';
        } else {
            $response_array['status'] = 'error';
            $response_array['message'] = 'No se pudo enviar el formulario. Inténtelo nuevamente en unos momentos.';
        }
    } else {
        $labels = rtrim($labels, ', ');
        $response_array['status'] = 'error';
        $response_array['message'] = 'Debe completar todos los campos requeridos: '.$labels;
    }

    header('Content-type: application/json');
    echo json_encode($response_array);
}

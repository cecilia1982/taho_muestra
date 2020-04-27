<?php
if(isset($_POST)){

    $valid = true;
    $labels = '';

    if (isset($_POST['contactForm'])) {

        // Formulario de contacto
        $fields = [
            'name' => 'Nombre',
            'email' => 'Email',
            'empresa' => 'Empresa',
            'message' => 'Mensaje',
        ];

        $titulo = 'TAHO - Formulario de contacto';
    }

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
        $para='info@taho.com.ar';
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

<?php

function mostrarSweetAlert()
{
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>'; // Incluir la librería SweetAlert2

    echo '<style>';
    echo '.swal2-confirm,';
    echo '.swal2-cancel {';
    echo '    font-family:"gaming";';
    echo '}';
    echo '.swal2-cancel {';
    echo '    background-color: #B9DA32 !important;';
    echo '    color: #000 !important;';
    echo '}';
    echo '@font-face {';
    echo 'font-family:"gaming";';
    echo ' src: url("../fonts/BrunoAceSC-Regular.ttf");';
    echo '}';
    echo '</style>';

    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo '  Swal.fire({';
    echo '    title: "Seleccione el turno",';
    echo '    text: "¿En que turno vas a usar el ordenador?",';
    echo '    showCancelButton: true,';
    echo '    confirmButtonText: "Mañana",';
    echo '    cancelButtonText: "Tarde"';
    echo '  }).then((result) => {';
    echo '    if (result.isConfirmed) {';
    echo '      document.cookie = "turno=mañana";';
    echo '    } else {';
    echo '      document.cookie = "turno=tarde";';
    echo '    }';
    echo '  });';
    echo '});';
    echo '</script>';
}

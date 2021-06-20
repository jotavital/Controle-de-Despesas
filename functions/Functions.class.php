<?php

class Functions
{

    function formatarReal($valor)
    {
        $formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);
        $valor = ($formatter->formatCurrency($valor, 'BRL'));
        return $valor;
    }

    function formatarRealSemCifrao($valor)
    {
        return number_format($valor, 2, ',', '.');
    }

    function calcularPorcentagem($atingido, $total){
        $porcento = ($atingido * 100) / $total;
        $porcento = sprintf("%.2f", $porcento);
        return $porcento;
    }
}

<?php

class Functions
{

    function formatarReal($valor)
    {
        $formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);
        $valor = ($formatter->formatCurrency($valor, 'BRL'));
        return $valor;
    }

    function formatarRealSemCifrao($valor){
        return number_format($valor, 2, ',', '.');
    }
}

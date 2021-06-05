<?php

class Functions
{

    function formatarReal($valor)
    {
        $formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);
        $valor = ($formatter->formatCurrency($valor, 'BRL'));
        return $valor;
    }
}

<?php namespace Eppiks\IfThenPay;

class IfThenPay
{

    function formatNumber($number)
    {
        $verifySepDecimal = number_format(99, 2);

        $valorTmp = $number;

        $sepDecimal = substr($verifySepDecimal, 2, 1);

        $hasSepDecimal = True;

        $i = (strlen($valorTmp) - 1);

        for ($i; $i != 0; $i -= 1) {
            if (substr($valorTmp, $i, 1) == "." || substr($valorTmp, $i, 1) == ",") {
                $hasSepDecimal = True;
                $valorTmp = trim(substr($valorTmp, 0, $i)) . "@" . trim(substr($valorTmp, 1 + $i));
                break;
            }
        }

        if ($hasSepDecimal != True) {
            $valorTmp = number_format($valorTmp, 2);

            $i = (strlen($valorTmp) - 1);

            for ($i; $i != 1; $i--) {
                if (substr($valorTmp, $i, 1) == "." || substr($valorTmp, $i, 1) == ",") {
                    $hasSepDecimal = True;
                    $valorTmp = trim(substr($valorTmp, 0, $i)) . "@" . trim(substr($valorTmp, 1 + $i));
                    break;
                }
            }
        }

        for ($i = 1; $i != (strlen($valorTmp) - 1); $i++) {
            if (substr($valorTmp, $i, 1) == "." || substr($valorTmp, $i, 1) == "," || substr($valorTmp, $i, 1) == " ") {
                $valorTmp = trim(substr($valorTmp, 0, $i)) . trim(substr($valorTmp, 1 + $i));
                break;
            }
        }

        if (strlen(strstr($valorTmp, '@')) > 0) {
            $valorTmp = trim(substr($valorTmp, 0, strpos($valorTmp, '@'))) . trim($sepDecimal) . trim(substr($valorTmp, strpos($valorTmp, '@') + 1));
        }

        return $valorTmp;
    }

    public function generateRef($order_id, $order_value)
    {
        $ent_id = config('ifthenpay.entity');
        $subent_id = config('ifthenpay.subentity');

        $chk_val = 0;

        $order_id = "0000" . $order_id;

        if (strlen($ent_id) < 5) {
            echo "Lamentamos mas tem de indicar uma entidade válida";
            return;
        } else if (strlen($ent_id) > 5) {
            echo "Lamentamos mas tem de indicar uma entidade válida";
            return;
        }
        if (strlen($subent_id) == 0) {
            echo "Lamentamos mas tem de indicar uma subentidade válida";
            return;
        }

        $order_value = sprintf("%01.2f", $order_value);

        $order_value = $this->formatNumber($order_value);

        if ($order_value < 1) {
            echo "Lamentamos mas é impossível gerar uma referência MB para valores inferiores a 1 Euro";
            return;
        }
        if ($order_value >= 1000000) {
            echo "<b>AVISO:</b> Pagamento fraccionado por exceder o valor limite para pagamentos no sistema Multibanco<br>";
        }

        if (strlen($subent_id) == 1) {
            //Apenas sao considerados os 6 caracteres mais a direita do order_id
            $order_id = substr($order_id, (strlen($order_id) - 6), strlen($order_id));
            $chk_str = sprintf('%05u%01u%06u%08u', $ent_id, $subent_id, $order_id, round($order_value * 100));
        } else if (strlen($subent_id) == 2) {
            //Apenas sao considerados os 5 caracteres mais a direita do order_id
            $order_id = substr($order_id, (strlen($order_id) - 5), strlen($order_id));
            $chk_str = sprintf('%05u%02u%05u%08u', $ent_id, $subent_id, $order_id, round($order_value * 100));
        } else {
            //Apenas sao considerados os 4 caracteres mais a direita do order_id
            $order_id = substr($order_id, (strlen($order_id) - 4), strlen($order_id));
            $chk_str = sprintf('%05u%03u%04u%08u', $ent_id, $subent_id, $order_id, round($order_value * 100));
        }

        //c�lculo dos check digits

        $chk_array = array(3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51);

        for ($i = 0; $i < 20; $i++) {
            $chk_int = substr($chk_str, 19 - $i, 1);
            $chk_val += ($chk_int % 10) * $chk_array[$i];
        }

        $chk_val %= 97;

        $chk_digits = sprintf('%02u', 98 - $chk_val);

        return [
            "entity" => $ent_id,
            "reference" => substr($chk_str, 5, 3) . " " . substr($chk_str, 8, 3) . " " . substr($chk_str, 11, 1) . $chk_digits,
            "value" => number_format($order_value, 2, ',', ' ')
        ];
    }

}
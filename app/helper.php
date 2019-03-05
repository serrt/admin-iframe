<?php

function formatResult($result)
{
    $return_code = data_get($result, 'return_code');

    if ($return_code != 'SUCCESS') {
        return data_get($result, 'return_msg');
    }

    $result_code = data_get($result, 'result_code');
    if ($result_code != 'SUCCESS') {
        return data_get($result, 'err_code_des');
    }

    return true;
}
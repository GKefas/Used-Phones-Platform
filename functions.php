<?php
function filterized_msg($message)
{
        $sanitizedMsg = filter_var($message);
        return $sanitizedMsg ;
}

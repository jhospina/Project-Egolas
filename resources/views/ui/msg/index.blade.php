<?php
if (Session::get('message_type')) {
    $message_type = Session::get('message_type');
    $message_params = Session::get('message_params');
    $message = Session::get('message');
    $message_pos = Session::get('message_pos');
}
?>

{{--VERIFICA SI HAY UN MENSAJE EMERGENTE PARA MOSTRARLE AL USUARIO--}}
@if(isset($message_type))
@if($message_pos==$message_id)
@include("ui/msg/".$message_type)
@endif
@endif
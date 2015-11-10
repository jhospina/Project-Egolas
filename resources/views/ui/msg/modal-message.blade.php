<?php
if(!session()->has("modal_message_title"))
    return;
?>
<div class="modal fade"  id="modal-message" tabindex="-1" role="dialog" aria-labelledby="modal-message" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="color:black;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 class="modal-title" id="modal-message-title">{{session("modal_message_title")}}</h1>
            </div>
            <div class="modal-body text-justify">
                {{session("modal_message_content")}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{session("modal_message_btn_close")}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(document).ready(function () {
        $("#modal-message").modal("show");
    });
</script>

<?php
//Elimina los datos en sesion del mensaje
session()->forget("modal_message_title");
session()->forget("modal_message_content");
session()->forget("modal_message_btn_close");
?>
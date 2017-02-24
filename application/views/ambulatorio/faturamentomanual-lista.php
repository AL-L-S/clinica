
<div class="content"> <!-- Inicio da DIV content -->
    <table>
        <tr>
            <td width="70">
                <div class="bt_link_new">
                    <a href="#">
                        Guia Ambualtorial
                    </a>
                </div>
            </td>
            <td width="20"></td>
            <td>
                <div class="bt_link_new">
                    <a href="<?php echo base_url() ?>ambulatorio/exame/carregarguiacirurgica">
                        Guia Cirurgica
                    </a>
                </div>
            </td>
            <td width="20"></td>
        </tr>
    </table>

    <div id="accordion">
        <h3 class="singular"><a href="#">Faturamento Manual</a></h3>
        <div>

        </div>
    </div>

</div> <!-- Final da DIV content -->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.5.custom.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-meiomask.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.validate.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script type="text/javascript">
    $(document).ready(function () {

        $(function () {
            $("#accordion").accordion();
        });

    });
</script>

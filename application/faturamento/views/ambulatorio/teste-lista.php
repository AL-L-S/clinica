
<form name="form_guia" id="form_guia" action="<?= base_url() ?>ambulatorio/guia/teste2" method="post">
<ul id="sortable">
<?
$i=0;
foreach ($arquivo_pasta as $value) {
    ?>
    <li class="ui-state-default"> <input type="hidden"  value="<?=$value?>" name="teste[]" class="size2" /><img  width="100px" height="100px" src="<?= base_url() . "upload/20/" . $value ?>"></li>
    <?
    $i++;
}
?>
    
    </ul>

</form>
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 1000px; }
    #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; height: 90px; font-size: 4em; text-align: center; }
</style>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script>
    $(document).ready(function(){ 
        $('#sortable').sortable();
    });


</script>
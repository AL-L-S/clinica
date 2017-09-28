<!--<embed
    type="application/pdf"
    src="http://localhost/clinicas/upload/consulta/135257/A-Team.pdf"
    id="pdfDocument"
    width="100%"
    height="100%" />-->


<iframe id="printf" name="printf" src="http://localhost/clinicas/upload/consulta/135257/A-Team.pdf"></iframe>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<!--                            <link href="<?= base_url() ?>css/estilo.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/form.css" rel="stylesheet" type="text/css" />-->
<!--                            <link href="<?= base_url() ?>css/jquery-ui-1.8.5.custom.css" rel="stylesheet" type="text/css" />
                            <link href="<?= base_url() ?>css/jquery-treeview.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.9.1.js" ></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.4.js" ></script>
<script>
//    printDocument('pdfDocument');
//    var doc = $('#pdfDocument').val();

//    function printDocument(documentId) {
//
//        var doc = document.getElementById('pdfDocument');
////        console.log(doc);
//        //Wait until PDF is ready to print    
//        if (typeof doc.print === 'undefined') {
//            setTimeout(function () {
//                printDocument(documentId);
//            }, 1000);
//        } else {
//            doc.print();
//        }
//    }
    document.frames['printf'].focus();
    document.frames['printf'].contentWindow.print();
//    window.frames["printf"].focus();
//    window.frames["printf"].print();
</script>
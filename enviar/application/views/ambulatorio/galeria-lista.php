<body>
    <div class="widget">

        <input type="button" value="<" class="prev">
        <input type="button" value=">" class="next">
        <div class="carrossel" id="carrossel">
            <ul>
                <?
                $i = 0;
                foreach ($arquivo_pasta as $value) {
                    ?>
                    <li><img width="750px" height="600px"
                             src="<?= base_url() . "upload/" . $exame_id . "/" . $value ?>" alt="1"></li>
                        <?
                        $i++;
                    }
                    ?>
            </ul>
        </div>

    </div>
</body>
<style>

    *{
        margin:0;
        padding:0;
    }

    #container{
        width: 950px;
    }

    #carrossel{
        width:600px;
        height:600px;
        overflow:hidden;
        margin:0 auto;
    }

    #carrossel ul{
        list-style:none;
        float:left
    }
    #carrossel ul li{
        float:left;
        display:inline;
        margin-left:4px;
    }

    .prev{
        width:60px;
        height:60px;
        float: left;
        margin-left:0px;
    }

    .next{
        width:60px;
        height:60px;
        float: right;
        margin-left:0px;
    }
</style>

<script type="text/javascript" src="<?= base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.jcarousel.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jcarousellite_1.0.1.min.js"></script>
<script type="text/javascript">
    $(function(){
        $("#carrossel").jCarouselLite({
            btnPrev : '.prev',
            btnNext : '.next',
            //auto    : 9,
            speed   : 200,
            visible : 1
        })
    })

</script>
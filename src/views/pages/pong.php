<?= $render('header', ['loggedUser'=>$loggedUser]); ?>
    <section class="container main">
        <?=$render('sidebar', ['activeMenu'=>'pong','user'=>$user,'loggedUser'=>$loggedUser]); ?>       

        <section class="feed">
            
                <div class="quiz-box">
                    <script src="<?=$base;?>/assets/js/game.js"></script>
                </div>
            

        </section>

    </section>


<?=$render('footer');?>
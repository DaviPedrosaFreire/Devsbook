<?= $render('header', ['loggedUser'=>$loggedUser]); ?>
    <section class="container main">
        <?=$render('sidebar', ['activeMenu'=>'quiz','user'=>$user,'loggedUser'=>$loggedUser]); ?>       

        <section class="feed">
            
                <div class="quiz-box">
                    

                    <div class="questionArea">
                        <div class="question"></div>
                        <div class="options">
                            
                        </div>
                    </div>

                    <div class="scoreArea">
                        <img src="<?=$base?>/assets/images/prize.png" class="prizeImage" />
                        <div class="scoreText1">Parabéns!</div>
                        <div class="scorePct">Acertou 99%</div>
                        <div class="scoreText2">Você respondeu 9 questões e acertou 8.</div>
                        <button>Fazer novamente</button>
                    </div>
                </div>
            

        </section>

    </section>

<script type="text/javascript" src="<?=$base;?>/assets/js/questions.js"></script>
<script type="text/javascript" src="<?=$base;?>/assets/js/quiz.js"></script>

<?=$render('footer');?>
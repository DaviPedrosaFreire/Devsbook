<?= $render('header', ['loggedUser'=>$loggedUser]); ?>
    <section class="container main">
        <?=$render('sidebar', ['activeMenu'=>'comment','user'=>$user,'loggedUser'=>$loggedUser]); ?>       

        <section class="feed">
            
            <div class="modal_bg" style="display: none;">
                <div class="modal_area">

                </div>

            </div>
            
                <div class="chat-box">
                    
                    <nav>
                        <ul>
                            
                            
                        </ul>
                        <button class="add_tab">+</button>

                    </nav>

                    <div class="messages">
                        <div class="message">
                                <div class="m_info">
                                    <span class="m_sender">Root</span>
                                    <span class="m_date">10:00</span>
                                </div>
                            <div class="m_body">
                                Seja bem vindo! entre em um de nossos chats e se divirta com a comunidade XD 
                            </div>
                        </div>
                    </div>

                    <div class="sender_area">
                        <input type="text" id="sender_input" placeholder="Digite uma mensagem"/>
                        <div class="sender_tools">
                            <div class="sender_tool">
                                <button id="send"></button>
                            </div>
                        </div>
                    </div>
                </div>
            

        </section>

    </section>

    <script type="text/javascript" src="<?=$base?>/assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?=$base?>/assets/js/chat.js"></script>
    <script type="text/javascript" src="<?=$base?>/assets/js/modeloChat.js"></script>    


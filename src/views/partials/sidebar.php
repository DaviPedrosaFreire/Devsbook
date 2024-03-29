<aside class="mt-10">
            <nav>
                <a href="<?=$base;?>">
                    <div class="menu-item <?=($activeMenu=='home')?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/home-run.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Home
                        </div>
                    </div>
                </a>
                <a href="<?=$base;?>/perfil">
                    <div class="menu-item <?=($activeMenu=='perfil')?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/user.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Meu Perfil
                        </div>
                    </div>
                </a>
                <a href="<?=$base;?>/amigos">
                    <div class="menu-item <?=($activeMenu=='friends')?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/friends.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Amigos
                        </div>
                        <div class="menu-item-badge">

                            <?php
                            if($user->id != $loggedUser->id){
                                echo count($contagem->followersCount);
                                
                            }else{
                                echo count($user->followersCount);
                            }
                                
                            ?>
                            
                        </div>
                    </div>
                </a>

                <a href="<?=$base;?>/Quiz">
                    <div class="menu-item <?=($activeMenu=='quiz')?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/brain.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Quiz
                        </div>
                    </div>
                </a>

                <a href="<?=$base;?>/Pong">
                    <div class="menu-item <?=($activeMenu=='pong')?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/game.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Pong
                        </div>
                    </div>
                </a>

                <a href="<?=$base;?>/Comment">
                    <div class="menu-item <?=($activeMenu=='comment')?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/comment.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Chat
                        </div>
                    </div>
                </a>

                <a href="<?=$base;?>/fotos">
                    <div class="menu-item <?=($activeMenu=='fotos')?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/photo.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Fotos
                        </div>
                    </div>
                </a>
                <div class="menu-splitter"></div>
                <a href="<?=$base;?>/config">
                    <div class="menu-item <?=($activeMenu=='config')?'active':'';?>">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/settings.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Configurações
                        </div>
                    </div>
                </a>
                <a href="<?=$base;?>/sair">
                    <div class="menu-item">
                        <div class="menu-item-icon">
                            <img src="<?=$base;?>/assets/images/power.png" width="16" height="16" />
                        </div>
                        <div class="menu-item-text">
                            Sair
                        </div>
                    </div>
                </a>
                
            </nav>
        </aside>
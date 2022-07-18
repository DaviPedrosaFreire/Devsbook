<?= $render('header', ['loggedUser'=>$loggedUser]); ?>
    <section class="container main">
        <?=$render('sidebar', ['activeMenu'=>'perfil','user'=>$user,'loggedUser'=>$loggedUser,'contagem'=>$contagem]); ?>       

        <section class="feed">

            <?=$render('perfil-header', ['user'=>$user,'loggedUser'=>$loggedUser,'isFollowing'=>$isFollowing]); ?>

            <div class="row">
                <div class="column side pr-5">
                    
                    <div class="box">
                        <div class="box-body">
                            
                            <div class="user-info-mini">
                                <img src="<?=$base;?>/assets/images/calendar.png" />
                                <?=date('d/m/Y', strtotime($user->birthdate)); ?> (<?=$user->ageYears;?> anos)
                            </div>

                            <?php if(!empty($user->city)): ?>

                            <div class="user-info-mini">
                                <img src="<?=$base;?>/assets/images/pin.png" />
                                <?=$user->city?>
                            </div>
                                
                            <?php endif; ?>

                            <?php if(!empty($user->work)): ?>

                            <div class="user-info-mini">
                                <img src="<? $base;?>/assets/images/work.png" />
                                <?=$user->work?>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>



                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Seguindo
                                <span>(<?=count($user->followingCount);?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?=$base;?>/perfil/<?=$user->id;?>/amigos">Amigos</a>
                            </div>
                        </div>
                        <div class="box-body friend-list">



                            <?php  for($q=0;$q<4;$q++):     ?>  

                                <?php    if(isset($user->followingCount[$q])):       ?> 
                                
                                    <div class="friend-icon">
                                        <a href="<?=$base;?>/perfil/<?=$user->followingCount[$q]->id?>">
                                            <div class="friend-icon-avatar">
                                                <img src="<?=$base;?>/media/avatars/<?=$user->followingCount[$q]->avatar?>" />
                                            </div>
                                            <div class="friend-icon-name">
                                                <?=$user->followingCount[$q]->name;?>
                                            </div>
                                        </a>
                                    </div>

                                <?php endif; ?>   
                            <?php endfor;  ?>

                        </div>
                    </div>

                </div>
                <div class="column pl-5">

                    <div class="box">
                        <div class="box-header m-10">
                            <div class="box-header-text">
                                Fotos
                                <span>(<?=count($user->photos);?>)</span>
                            </div>
                            <div class="box-header-buttons">
                                <a href="<?=$base;?>/perfil/<?=$user->id;?>/fotos">ver todos</a>
                            </div>
                        </div>
                        <div class="box-body row m-20">
                            
                                <?php for($q=0;$q<4;$q++): ?>   
                                    <?php if(isset($user->photos[$q])): ?>

                                        <div class="user-photo-item">
                                            <a href="#modal-<?=$user->photos[$q]->id ;?>" data-modal-open>
                                                <img src="<?=$base;?>/media/uploads/<?=$user->photos[$q]->body;?>" />
                                            </a>
                                            <div id="modal-<?=$user->photos[$q]->id ;?>" style="display:none">
                                                <img src="<?=$base;?>/media/uploads/<?=$user->photos[$q]->body;?>" />
                                            </div>
                                        </div>
                                        
                                    <?php endif; ?>
                                <?php endfor; ?>


                           
                            
                        </div>
                    </div>

                    <?php if($user->id == $loggedUser->id): ?>
                                        
                        <?=$render('feed-editor', ['loggedUser'=>$loggedUser] ); ?>
                        
                    <?php endif; ?>

                    <?php foreach($feed['posts'] as $feedItem): ?>
                        <?=$render('feed-item', [
                                'loggedUser'=>$loggedUser,
                                'data' => $feedItem
                            ]);  ?>
                    <?php endforeach; ?>

                    <div class="feed-pagination">
                        <?php for($q=0;$q<$feed['pageCount'];$q++ ): ?>
                            <a class="<?=($q==$feed['currentPage']?'active':'');?>" href="<?=$base;?>/perfil/<?=$user->id;?>?page=<?=$q;?>"><?=$q+1?></a>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            
            
            
        </section>
        <div class="modal">
            <div class="modal-inner">
                <a data-modal-close>&times;</a>
                <div class="modal-content"></div>
            </div>
        </div>

    </section>
    

<?=$render('footer');?>
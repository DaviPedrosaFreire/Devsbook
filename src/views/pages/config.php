<?= $render('header', ['loggedUser'=>$loggedUser]); ?>

    <section class="container main">
        <?=$render('sidebar', ['activeMenu'=>'config','user'=>$user,'loggedUser'=>$loggedUser]); ?> 

        <form class="formController" method="POST" enctype="multipart/form-data" action="<?=$base;?>/config">
            <h1>Novo Avatar:</h1><br/>
            <input type="file" name="avatar"/><br/><br/>
            <h1>Nova Capa:</h1><br/>
            <input type="file" name="cover" /><br/><br/><hr/>
            <span>Nome:</span><br/>
            <input placeholder="Digite seu Nome" class="input" type="text" name="name" value="<?=$loggedUser->name;?>" />
            <span>Email:</span><br/>
            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" value="<?=$user->email;?>"/>
            <span>dataNascimento:</span><br/>
            <input placeholder="Digite sua data de nascimento" class="input" type="text" name="birthdate" id="birthdate" value="<?=$user->birthdate;?>"/><hr/><br/>
            <?php if(isset($_SESSION['flash'])){ ?>
                <h2 style="background-color:#efefef; font-size: 15px; padding: 10px; border-radius: 10px;"><?=$_SESSION['flash']; ?></h2>
            <?php } ?>
            <span>Password:</span><br/>
            <input placeholder="Digite sua senha" class="input" type="password" name="password" />
            <span>PassConfirm:</span><br/>
            <input placeholder="Digite sua senha" class="input" type="password" name="passConfirm" />
            <input type="hidden" name="id" value="<?=$user->id?>"/>
            <input class="button" type="submit" value="Atualizar" />

        </form>
    

    </section>

<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.getElementById('birthdate'),
        {
            mask:'00/00/0000'
        }
    );
</script>

    <?=$render('footer');?>
